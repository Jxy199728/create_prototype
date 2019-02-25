<?php

//构建上传文件信息，3维数组变2维数组
function getFiles(){
    $i=0;
        foreach($_FILES as $file){
            // 说明是单文件
            if(is_string($file['name'])){
                $files[$i]=$file;
                $i++;
            }elseif(is_array($file['name'])){
                //说明是多文件
                foreach($file['name'] as $key=>$val){
                    $files[$i]['name']=$file['name'][$key];
                    $files[$i]['type']=$file['type'][$key];
                    $files[$i]['tmp_name']=$file['tmp_name'][$key];
                    $files[$i]['error']=$file['error'][$key];
                    $files[$i]['size']=$file['size'][$key];
                    $i++;
                }
            }
        }

    return $files;
    //print_r($files);
}
function uploadmultiFiles($fileInfo,$path='./multiuploads',$flag=true,$maxSize=1048576,$allowExt=array('jpeg','jpg','png','gif')){
    $res = array();

    if($fileInfo['error']===UPLOAD_ERR_OK){
        // 检测上传文件大小
        if($fileInfo['size']>$maxSize){
            $res['mes']=$fileInfo['name'].'上传文件过大';
        }
        // 上传文件类型
        $ext=getExt($fileInfo['name']);
        if(!in_array($ext,$allowExt)){
            $res['mes']=$fileInfo['name'].'非法文件类型';
        }
        // 检测上传文件类型是否真实
        if($flag){
            if(!getimagesize($fileInfo['tmp_name'])){
                $res['mes']=$fileInfo['name'].'上传文件类型不真实';
            }
        }
        // 检测上传文件是否通过HTTP POST上传
        if(!is_uploaded_file($fileInfo['tmp_name'])){
            $res['mes']=$fileInfo['name'].'上传文件不是通过HTTP POST上传';
        }
        // 临时文件是否移动成功
        if($res) return $res;
        $path='./multiuploads';
        if(!file_exists($path)){
            mkdir($path,0777,true);
            chmod($path,0777);
        }
        $uniName=getUniName();
        $destination=$path.'/'.$uniName.'.'.$ext;

        $pinjie='multiuploads/'.$uniName;
        if(!move_uploaded_file($fileInfo['tmp_name'],$destination)){
            $res['mes']=$fileInfo['name'].'上传文件移动失败';
        }
        $res['mes']=$fileInfo['name'].'上传成功';
        $res['dest']=$destination;
        $res['pinjie']=$pinjie;

        return $res;
    }else{
        // 匹配错误号
        switch ($fileInfo['error']){
            case 1:
                $res['mes']='上传文件超过了PHP配置文件中upload_max_filesize选项的值';
                break;
            case 2:
                $res['mes']='上传文件超过了表单MAX_FILE_SIZE限制大小的值';
                break;
            case 3:
                $res['mes']='上传文件只部分上传';
                break;
            case 4:
                $res['mes']='没有上传文件';
                break;
            case 6:
                $res['mes']='没有找到临时目录';
                break;
            case 7:
            case 8:
                $res['mes']='系统错误';
                break;
        }
        return $res;
    }
}