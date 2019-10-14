<?php

namespace App\Http\Controllers\tool;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class ToolController extends Controller
{
    /*上传图片通用*/
    public function upload_image(Request $request){
       // return $_GET;
        $ck = $request->get('CKEditorFuncNum')?:'';
        $file_character = $request->file('upload');
        //return $file_character;
        if($file_character&&$file_character->isValid()) {
            $pic = $file_character->store('/public/'. date('Y-m-d').'/articles' );
            //return $pic;
            //上传的头像字段avatar是文件类型
            $url = Storage::url($pic);//就是很简单的一个步骤
            echo "<script type='text/javascript'>window.parent.CKEDITOR.tools.callFunction($ck, '$url', '上传成功');</script>";
        }else{
            //return 1;
            echo "<script></script>";

        }



    }
}
