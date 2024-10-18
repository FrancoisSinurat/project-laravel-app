<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;


class MediaController extends Controller
{
    public function uploadSingleFile(Request $request) {
        $this->validate($request, [
            'file' => 'required|file|mimes:pdf,png,jpeg,jpg|max:2048', // max ukuran file dalam kilobyte
        ], [
            'file.required' => 'File wajid diupload.',
            'file.file' => 'File wajib diupload.',
            'file.mimes' => 'Hanya file PDF, PNG, JPEG, atau JPG yang diperbolehkan.',
            'file.max' => 'Ukuran file maksimal adalah 2 MB.',
        ]);
        $result = ['data' => null];
        $name = $request->input('name') ?? null;
        $path = $request->input('path') ?? 'dokumen';
        if (!$name) return response()->json($result);
        try {
            $file = $request->file('file');
            $filePath = $path.'/'. date('Y-m-d');

            $fileKey = str_pad(rand(0, pow(10, 2)-1), 3, '0', STR_PAD_LEFT);
            $fileExt = $file->getClientOriginalExtension();
            $fileName = 'app_file_'.Str::slug($name) .'_'. date('Y_m_d') . $fileKey .'.'. $fileExt;
            if (env('FILESYSTEM_CLOUD') == 's3') {
                $upload = Storage::cloud()->putFileAs($filePath, $file, $fileName);
            } else {
                $upload = $file->storeAs($filePath, $fileName, 'local');
            }
            if ($upload) {
                $user = Auth::user();
                $result['data'] = ['file' => [
                    'filepath' => $filePath,
                    'filename' => $fileName,
                    'user_id' => $user->user_id,
                    'user_name' => $user->user_name,
                    'key' => $name,
                    'ext' => $fileExt,
                    'driver' => env('FILESYSTEM_CLOUD')
                    ]
                ];
            }
            return response()->json($result);
        } catch (\Throwable $th) {
            @dd($th);
           return response()->json($result);
        }
        return response()->json($result);
    }

    public function getSingleFile(Request $request) {
        try {
            $doc = $request->doc;
            $path = $request->query('path');
            $driver = $request->query('driver');
            if ($driver == 'local') {
                $path = storage_path('app/'.$path.'/'. $doc);
                return response()->file($path);
            } else {
                $filesystem = Storage::disk('s3');
                $path = $path.'/'.$doc;
                if (!$filesystem->exists($path)) abort(404);
                $mimeType = $filesystem->mimeType($path);
                $headers = [
                    'Content-Type' => $mimeType
                ];
                if (preg_match('/bmp|jpg|jpeg|png|gif|pdf/i', $doc) == false) {
                    $headers['Content-disposition'] = 'attachment; filename="' . $doc . '"';
                }
                $file = $filesystem->get($path);
                return response()->stream(function () use ($file) {
                    echo $file;
                }, 200, $headers);
            }
        } catch (\Throwable $th) {
            @dd($th);
            abort(404, 'file tidak ditemukan');
        }
    }
}
