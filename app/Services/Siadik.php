<?php
namespace App\Services;

use Error;
use Illuminate\Support\Facades\Http;

class Siadik {
    private static function post(string $path, array $data) {
        $data['key'] = env('APP_SIADIK_KEY');
        try {
            return Http::asForm()->timeout(5)->post(env('APP_SIADIK_URL').$path, $data)->json();
        } catch (\Throwable $th) {
            throw new Error('Siadik. '.$th->getMessage() ?? 'Siadik error');
        }
    }

    public static function findByNRK(string $nrk) {
        $request = self::post('/api/pegawai/get', ['nrk' => $nrk]);
        if ($request['status'] != true) throw new Error('Siadik. '.$request['message'] ?? 'Siadik error');
        if (count($request['data']) == 0) return [];
        $result = $request['data'][0];
        return $result;
    }
}

