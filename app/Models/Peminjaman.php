<?php

namespace App\Models;

use App\Trait\UuidTrait;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
 
class Peminjaman extends Model
{
    use SoftDeletes, UuidTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $table = 'asset_peminjamans';
    protected $primaryKey = 'asset_peminjaman_id';
    CONST STATUS_ASSET_MENUNGGU = 'MENUNGGU PERSETUJUAN';
    CONST STATUS_ASSET_MENUNGGU_PROSES = 'MENUNGGU PROSES PERSETUJUAN';
    CONST STATUS_ASSET_DISETUJUI = 'DISETUJUI';
    CONST STATUS_ASSET_DITOLAK = 'DITOLAK';

    protected $fillable = [
        'asset_peminjaman_id',
        'asset_id',
        'user_id',
        'asset_peminjaman_datetime',
        'asset_pengembalian_datetime',
        'asset_peminjaman_status'
    ];
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'user_id');
    }

    public function asset()
    {
        return $this->belongsTo(Asset::class, 'asset_id', 'asset_id');
    }

    public function peminjamanApproval()
    {
        return $this->hasMany(PeminjamanApproval::class, 'asset_peminjaman_id', 'asset_peminjaman_id');
    }

    public static function normalize($input) {
        Log::info('normalize asset');
        Log::info($input);
        $result = $input;
        $result['asset_peminjaman_datetime'] = Carbon::createFromFormat('d-m-Y H:i', $input['asset_peminjaman_datetime'])->toDateTimeString();
        $result['asset_pengembalian_datetime'] = Carbon::createFromFormat('d-m-Y H:i', $input['asset_pengembalian_datetime'])->toDateTimeString();
        return $result;
    }

    public static function createPeminjaman($input) {
        Log::info('create asset');
        Log::info($input);

        // Ambil tanggal peminjaman dan tanggal pengembalian dari input
        $peminjaman     = $input['asset_peminjaman_datetime'];
        $pengembalian   = $input['asset_pengembalian_datetime'];
        $assetID        = $input['asset_id'];

        // Periksa apakah rentang tanggal yang diinput bertabrakan dengan rentang tanggal yang sudah ada di database
        $existingPeminjaman = Peminjaman::select('asset_peminjamans.asset_id', 'assets.asset_name')
                ->join('assets', 'asset_peminjamans.asset_id', '=', 'assets.asset_id')
                ->where('assets.asset_status', '!=', 'DIGUNAKAN')
                ->where('asset_peminjamans.asset_peminjaman_status', '!=', 'DISETUJUI')
                ->where('asset_peminjamans.asset_id', '=', $assetID)
                ->where(function ($query) use ($peminjaman, $pengembalian) {
                    $query->whereBetween('asset_peminjamans.asset_peminjaman_datetime', [$peminjaman, $pengembalian])
                    ->orWhereBetween('asset_peminjamans.asset_pengembalian_datetime', [$peminjaman, $pengembalian])
                    ->orWhereRaw("'$peminjaman' BETWEEN asset_peminjamans.asset_peminjaman_datetime AND asset_peminjamans.asset_pengembalian_datetime")
                    ->orWhereRaw("'$pengembalian' BETWEEN asset_peminjamans.asset_peminjaman_datetime AND asset_peminjamans.asset_pengembalian_datetime");
                })
                ->exists();

        if (!$existingPeminjaman) {
            $createPeminjaman = Peminjaman::create($input);
            $historyId = $createPeminjaman->asset_peminjaman_id;
            $approver = User::whereIn('user_nrk', User::PEJABAT_ASET)->orderBy('user_nrk', 'DESC')->get();
            foreach ($approver as $key => $value) {
                Log::info($value);
                $sort = '1';
                $statusPeminjaman = Peminjaman::STATUS_ASSET_MENUNGGU;
                if ($key == 1) $statusPeminjaman = Peminjaman::STATUS_ASSET_MENUNGGU_PROSES AND $sort = '2';
                PeminjamanApproval::create([
                    'asset_peminjaman_id' => $historyId,
                    'user_id' => $value->user_id,
                    'asset_peminjaman_approval_status' => $statusPeminjaman,
                    'sort' => $sort
                ]);
            }
            
            return $createPeminjaman;

        } 
            throw new \Exception("Asset tidak tersedia dipinjam diwaktu yang dipilih");
    }

    public static function updatePeminjaman($input) {
        Log::info('update asset');
        Log::info($input);
        $user = Auth::user();
        $Userpeminjaman = $user->user_nrk;
        if ($input['status'] == 'true') {
            // @dd('status true');
            if ($Userpeminjaman == '187792')
            {

                PeminjamanApproval::where('asset_peminjaman_id', $input['asset_peminjaman_id'])
                    ->where('sort', 1)
                    ->update(['asset_peminjaman_approval_status' => 'DISETUJUI']);

                PeminjamanApproval::where('asset_peminjaman_id', $input['asset_peminjaman_id'])
                    ->where('sort', 2)
                    ->update(['asset_peminjaman_approval_status' => 'MENUNGGU PERSETUJUAN']);

            }
            else if ($Userpeminjaman == '124842')
            {
                Peminjaman::where('asset_peminjaman_id', $input['asset_peminjaman_id'])
                    ->where('asset_peminjaman_status', 'MENUNGGU PERSETUJUAN')
                    ->update(['asset_peminjaman_status' => 'DISETUJUI']);

                PeminjamanApproval::where('asset_peminjaman_id', $input['asset_peminjaman_id'])
                    ->where('asset_peminjaman_approval_status', 'MENUNGGU PERSETUJUAN')
                    ->where('sort', 2)
                    ->update(['asset_peminjaman_approval_status' => 'DISETUJUI']);
            }
        }
        else if ($input['status'] == 'false') 
        {
            // @dd('status false');
            Peminjaman::where('asset_peminjaman_id', $input['asset_peminjaman_id'])
                ->where('asset_peminjaman_status', 'MENUNGGU PERSETUJUAN')
                ->update(['asset_peminjaman_status' => 'DITOLAK']);

            PeminjamanApproval::where('asset_peminjaman_id', $input['asset_peminjaman_id'])
                ->where('sort', 1)
                ->update(['asset_peminjaman_approval_status' => 'DITOLAK']);

            PeminjamanApproval::where('asset_peminjaman_id', $input['asset_peminjaman_id'])
                ->where('sort', 2)
                ->update(['asset_peminjaman_approval_status' => 'DITOLAK']);
        }

    }

    public static function transform($data) {
        return [
            'asset_id' => $data->asset_id ?? null,
            'user_id' => $data->user_id ?? null,
            'user_fullname' => $data->user->user_fullname ?? null,
            'asset_peminjaman_status' => $data->asset_peminjaman_status ?? null,
        ];
    }
}