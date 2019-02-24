<?php
// +----------------------------------------------------------------------
// | thinkpphp [ WE CAN DO IT MORE SIMPLE ]
// +----------------------------------------------------------------------
// | Copyright (c) 2018 rights reserved.
// +----------------------------------------------------------------------
// | Author: luyunoob <595080590@qq.com>
// +----------------------------------------------------------------------
namespace app\index\controller;
use think\Controller;
header('content-type:text/html;charset=urf-8');

require_once 'D:\phpStudy\WWW\createweb\application\index\common\multiupload.func.php';
require_once 'D:\phpStudy\WWW\createweb\application\index\common\common.func.php';

use think\Db;
use think\Cache;
use think\Session;


class Testmultiupload extends Controller{

    public function index()
    {
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
    }
}