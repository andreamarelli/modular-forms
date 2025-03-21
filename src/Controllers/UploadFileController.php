<?php

namespace ModularForms\Controllers;

use ModularForms\Helpers\File\File;
use ModularForms\Models\Module;
use ModularForms\Models\Traits\Upload;
use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;


/**
 * Class UploadFileController
 *
 * @package ModularForms\Controllers
 */
class UploadFileController extends Controller
{

    /**
     * Upload file
     *
     * @param Request $request
     * @return array
     */
    public static function upload(Request $request): array
    {
        $uploaded = Upload::uploadFile($request->file('file_upload'));
        if($uploaded!==null){
            return $uploaded;
        } else {
            throw new BadRequestHttpException();
        }
    }

    /**
     * Download file (by hash)
     *
     * @param $hash
     * @return BinaryFileResponse
     * @throws FileNotFoundException
     */
    public static function download($hash): BinaryFileResponse
    {
        [$file_content, $file_name] = Module::getFileByHash($hash);
        $disk = Storage::disk(File::TEMP_STORAGE);
        $disk->put($hash, $file_content);
        $file_path = $disk->path($hash);
        return response()
            ->download($file_path, $file_name);
    }


}
