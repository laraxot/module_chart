<?php

/**
 * @see https://stackoverflow.com/questions/42102803/how-to-save-base64-image-server-side
 */

declare(strict_types=1);

namespace Modules\Chart\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\File;
use Modules\Xot\Services\FileService;

class ApiController extends Controller {
    public function imageStore(Request $request): JsonResponse {
        $data = $request->all();

        $img = 'chart/'.$data['filename'].'.png';
        $filename = public_path($img);

        FileService::createDirectoryForFilename($filename);
        $content = $data['content'];
        $image_parts = explode(';base64,', $content);
        $image_type_aux = explode('image/', $image_parts[0]);
        $image_type = $image_type_aux[1];
        $image_base64 = base64_decode($image_parts[1]);

        // $content = base64_decode($data['content']);

        File::put($filename, $image_base64);

        return response()->json([
            'message' => 'true',
        ], 200);
    }
}
