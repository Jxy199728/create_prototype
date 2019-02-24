<?php
function uploadFile($fileInfo,$allowExt=array('jpeg', 'jpg', 'png', 'gif'),$flag=true,$maxSize=2097152,$uploadPath='uploadpath'){
    // 判断错误号
    if($fileInfo['error']>0){
        // 匹配错误号
        switch ($fileInfo['error']){
            case 1:
                $mes='上传文件超过了PHP配置文件中upload_max_filesize选项的值';
                break;
            case 2:
                $mes='上传文件超过了表单MAX_FILE_SIZE限制大小的值';
                break;
            case 3:
                $mes='上传文件只部分上传';
                break;
            case 4:
                $mes='没有上传文件';
                break;
            case 6:
                $mes='没有找到临时目录';
                break;
            case 7:
            case 8:
                $mes='系统错误';
                break;
        }
        exit($mes);
    }
    $ext=pathInfo($fileInfo['name'],PATHINFO_EXTENSION);
    if(!is_array($allowExt)){
        exit($mes);
    }
    //
    if(!in_array($ext,$allowExt)){
        exit('非法文件类型');
    }
    //
    if($flag){
        if(!getimagesize($fileInfo['tmp_name'])){
            exit('上传文件类型不真实');
        }
    }
    //
    if($fileInfo['size']>$maxSize){
        exit('上传文件过大');
    }
    //
    if(!is_uploaded_file($fileInfo['tmp_name'])){
        exit('不是HTTP POST');
    }
    //
    if(!file_exists($uploadPath)){
        mkdir($uploadPath,0777,true);
        chmod($uploadPath,0777);
    }
    //
    $uniName=md5(uniqid(microtime(true),true)).'.'.$ext;
    $destination=$uploadPath.'/'.$uniName;
    if(!@move_uploaded_file($fileInfo['tmp_name'],$destination)){
        exit('文件移动失败');
    }
    return array(
        'newName'=>$destination,
        'size'=>$fileInfo['size'],
        'type'=>$fileInfo['type'],
    );

}