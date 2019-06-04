<?php
/**
 */


namespace App\Http\Controllers;


use Illuminate\Support\Facades\Input;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class UploadController extends Controller
{
    public function upload(Request $request)
    {
        $output = ['status' => 0,'message' => '上传失败，请重试'];
        $target = $request->input('target');
        $file = $request->file('file');
        $type = $request->input('type');
        if (!$file || !$target || !$file->isValid()) {//图片
            $output['message'] = '参数错误';
            return $this->tojson($output);
        }
        $clientName = $file->getClientOriginalName();
        $extension = $file->getClientOriginalExtension();
        $new_file_name = $target.'/'.date('Ym').'/'.date('d');
        $path = Storage::disk('public')->putFileAs(
            $new_file_name, $file, md5($clientName) . '.' . $extension
        );
        if ($path){
            $output['status'] = 1;
            $output['message'] = '上传成功';
            $output['path'] = '/storage/public/'.$path;
            if ($type == 'keditor'){
                $output['error'] = 0;
                $output['url'] = $request->getSchemeAndHttpHost().$output['path'];
            }
        }
        return $this->tojson($output);
    }
}