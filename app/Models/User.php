<?php

namespace App\Models;

use App\Trait\UuidTrait;
use Error;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Log;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Support\Arr;

class User extends Authenticatable
{
    use HasFactory, SoftDeletes, UuidTrait, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $primaryKey = 'user_id';

    protected $fillable = ['user_name', 'user_email', 'user_status', 'user_password', 'user_address', 'user_phone', 'user_fullname', 'user_nrk'];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'user_password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'user_password' => 'hashed',
    ];

    public function getAuthPassword()
    {
        return $this->user_password;
    }

    CONST PEJABAT_ASET = ['124842', '187792'];

    /**
     * Get the user that owns the User
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function profile()
    {
        return $this->hasOne(Profile::class, 'user_id', 'user_id');
    }

    public function position()
    {
        return $this->hasOne(Position::class, 'user_id', 'user_id');
    }

    public function asset()
    {
        return $this->hasMany(Asset::class, 'user_id', 'asset_used_by');
    }

    public function asset_history()
    {
        return $this->hasMany(AssetHistory::class, 'user_id', 'asset_history_user_id');
    }

    public static function getUserByNRKOrEmail ($data) {
        return User::where('user_nrk', $data)->orWhere('user_email', $data)->first();
    }

    public static function createUserFromSiadik($data)
    {
        try {
            $user = [
                'user_name' => $data['nrk'],
                'user_fullname' => $data['nama_pegawai'],
                'user_email' => $data['email'],
                'user_password' => $data['nrk'],
                'user_nrk' => $data['nrk'],
                'user_status' => 1,
                'user_address' => $data['alamat'],
                'user_phone' => $data['telepon'],
            ];
            $findUser = User::where('user_nrk', $data['nrk'])->first();
            if ($findUser) return $findUser->toArray();
            $user = User::create($user);
            $profile = [
                'user_id' => $user->user_id,
                'profile_pegawai_id' => $data['id_pegawai'],
                'profile_nip' => $data['nip'],
                'profile_photo' => $data['foto'],
                'profile_photo_thumbnail' =>  $data['thumb_foto'],
                'profile_signature' => $data['signature']
            ];
            $position = [
                'user_id' => $user->user_id,
                'position_name' => $data['jabatan'],
                'position_status' => $data['nama_status_jabatan'],
                'position_location' => $data['nama_lokasi_kerja'],
                'position_sub_location' => $data['sub_lokasi_kerja'],
                'position_type' => $data['nama_status_pegawai'],
                'position_category' => $data['golongan'],
                'position_echelon' => $data['eselon']
            ];
            $isPejabatAset = in_array($data['nrk'], self::PEJABAT_ASET);
            Log::error($isPejabatAset);
            if ($isPejabatAset) $user->assignRole('Pejabat Aset');
            if (!$isPejabatAset) $user->assignRole('Pegawai');

            Profile::create($profile);
            Position::create($position);
            return $user->toArray();
        } catch (\Throwable $th) {
            Log::error($th);
            throw new Error('Error Create User From Siadik');
        }
    }
}
