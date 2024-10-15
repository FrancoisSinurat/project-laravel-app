<?php

namespace App\Models;

use App\Trait\UuidTrait;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Log;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use LDAP\Result;

class AssetGroup extends Model
{
    use SoftDeletes, UuidTrait;
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $table = 'asset_groups';

    protected $primaryKey = 'asset_group_id';

    protected $fillable = [
        'asalpengadaan_category_id',
        'asaloleh_category_id',
        'asset_document_number',
        'asset_asaloleh_date',
        'asset_procurement_year',
        'asset_documents',
        'asset_group_items'
    ];

    public function asset()
    {
        return $this->hasMany(Asset::class, 'asset_group_id', 'asset_group_id');
    }

    public function asal_oleh()
    {
        return $this->belongsTo(AsalolehCategory::class, 'asaloleh_category_id', 'asaloleh_category_id');
    }

    public function asal_pengadaan()
    {
        return $this->belongsTo(AsalpengadaanCategory::class, 'asalpengadaan_category_id', 'asalpengadaan_category_id');
    }

    public static function deleteAsset($id)
    {
        try {
            $assetGroup = assetGroup::findOrFail($id);
            $assetGroup->delete();
        } catch (\Throwable $th) {
            throw new \Exception($th->getMessage());
        }
    }

    /**
     * Normalize the input data.
     *
     * @param array
     * @return array
     */
    public static function normalize($input)
    {
        if (isset($input['asset_asaloleh_date']) && !empty($input['asset_asaloleh_date'])) {
            $input['asset_asaloleh_date'] = Carbon::createFromFormat('d-m-Y', $input['asset_asaloleh_date'])->toDateString();
        } else {
            $input['asset_asaloleh_date'] = null; // Set to null if not provided or empty
        }
        return $input;
    }
    /**
     * Create or update an asset group.
     *
     * @param array $input
     * @return \App\Models\AssetGroup
     */
    public static function updateorCreateAssetGroup($input)
    {
        if (isset($input['asset_group_id'])) {
            $updateGroup = [
                'asalpengadaan_category_id' => $input['asalpengadaan_category_id'],
                'asaloleh_category_id' => $input['asaloleh_category_id'],
                'asset_document_number' => $input['asset_document_number'],
                'asset_asaloleh_date' => Carbon::createFromFormat('d-m-Y', $input['asset_asaloleh_date'])->toDateString(),
                'asset_procurement_year' => $input['asset_procurement_year'],
            ];
            if ($request->hasFile('asset_documents')) {
                $originalName = $file->getClientOriginalName(); // Nama asli file
                $extension = $file->getClientOriginalExtension(); // Ekstensi file
                $filename = pathinfo($originalName, PATHINFO_FILENAME); // Nama tanpa ekstensi

                // Cek jika file dengan nama yang sama sudah ada
                $filePath = 'assets/documents/' . $originalName;
                $counter = 1;

                // Cek jika file sudah ada dan ubah nama jika perlu
                while (Storage::disk('public')->exists($filePath)) {
                    $newFilename = $filename . '_' . $counter . '.' . $extension;
                    $filePath = 'assets/documents/' . $newFilename;
                    $counter++;
                }

                // Menyimpan file ke storage
                $file->storeAs('assets/documents', $filePath, 'public');
                $input['asset_documents'] = $filePath; // Menyimpan path file ke database
            }


            AssetGroup::where('asset_group_id', $input['asset_group_id'])->update($updateGroup);
            // if not same group recalculate
            if (isset($input['old_asset_group_id'])) {
                if ($input['old_asset_group_id'] != $input['asset_group_id']) {
                    self::decrementAssetGroup(['asset_group_id' => $input['old_asset_group_id']]);
                    self::incrementAssetGroup(['asset_group_id' => $input['asset_group_id']]);
                }
            }
            return AssetGroup::where('asset_group_id', $input['asset_group_id'])->first();
        }  else {
            $createAssetGroup = AssetGroup::create($input);
            return $createAssetGroup;
        }
    }
    public static function updateAssetGroup($input)
    {
        return self::updateOrCreateAssetGroup($input);
    }
}
