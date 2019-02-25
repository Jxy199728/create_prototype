<?php

namespace app\index\controller;
use http\Env\Request;
use think\Controller;
require_once 'D:\phpStudy\WWW\createweb\application\index\common\multiupload.func.php';
require_once 'D:\phpStudy\WWW\createweb\application\index\common\common.func.php';
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

        // 遍历
        if (isset($_POST['submit'])) {

            $files = getFiles();
            foreach ($files as $fileInfo) {
                $res = uploadmultiFiles($fileInfo);
                echo $res['mes'], '<br/>';

                if (isset($res['dest'])) {
                    $uploadFiles[] = $res['dest'];
                }
            }
            if (isset($uploadFiles)) {
                $uploadFiles = array_values(array_filter($uploadFiles));
                print_r($uploadFiles);

            }
            return view();
        }


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