<?php

namespace app\index\controller;
use http\Env\Request;
use think\Controller;
include_once "D:\phpStudy\WWW\createweb\application\index\common\uniupload.func.php";
use think\Db;
use think\Cache;
use think\Session;

class Umanage extends Ucommon{
    public function video(){
        $ucateid=1;
        $ucateids=db('ucate')->find($ucateid);
        $this->assign([
            'ucateids'=>$ucateids,
        ]);
        return view();
    }
    public function upload(){
        $ucateid=1;
        $ucateids=db('ucate')->find($ucateid);
        $this->assign([
            'ucateids'=>$ucateids,
        ]);

/*        if(isset($_POST['submit'])){
            $fileInfo = $_FILES['med_pic'];

            if($fileInfo){
                print_r(getimagesize($fileInfo['tmp_name']));
            }
            $allowExt = array('jpeg', 'jpg', 'png', 'gif');
            $flag = true;
            $maxSize = 2097152;
            $uploadPath = 'uploadpath';

            $newName = uploadFile($fileInfo, $allowExt, $flag, $maxSize, $uploadPath);
            print_r($newName);
        }*/

        return view();
    }
    public function classify(){
        $ucateid=1;
        $ucateids=db('ucate')->find($ucateid);
        $this->assign([
            'ucateids'=>$ucateids,
        ]);
        return view();
    }
}