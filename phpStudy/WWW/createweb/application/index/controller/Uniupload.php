<?php
// +----------------------------------------------------------------------
// | thinkpphp [ WE CAN DO IT MORE SIMPLE ]
// +----------------------------------------------------------------------
// | Copyright (c) 2018 rights reserved.
// +----------------------------------------------------------------------
// | Author: luyunoob <595080590@qq.com>
// +----------------------------------------------------------------------
namespace app\index\controller;
include_once "D:\phpStudy\WWW\createweb\application\index\common\uniupload.func.php";
use think\Db;
use think\Cache;
use think\Session;
class Uniupload
{
    public function index(){
        if(isset($_POST['submit'])){
            $fileInfo = $_FILES['file_upload'];

            if($fileInfo){
                print_r(getimagesize($fileInfo['tmp_name']));
            }
            $allowExt = array('jpeg', 'jpg', 'png', 'gif');
            $flag = true;
            $maxSize = 2097152;
            $uploadPath = 'uploadpath';
            //$fileInfo=$_FILES['med_pic'];

            $newName = uploadFile($fileInfo, $allowExt, $flag, $maxSize, $uploadPath);
            print_r($newName);
        }

        return view();

    }
}