<?php
class upload{
    protected $fileName;
    protected $maxSize;
    protected $allowMime;
    protected $allowExt;
    protected $uploadPath;
    protected $imgFlag;
    protected $fileInfo;
    protected $error;
    protected $ext;

    public function __construct($fileName='myFile',$uploadPath='./uploadsclass',$imgFlag=true,$maxSize=5242880,$allowExt=array('jpeg','jpg','png','gif'),$allowMime=array('image/jpeg','image/png','image/gif')){
        $this->fileName=$fileName;
        $this->maxSize=$maxSize;
        $this->allowMime=$allowMime;
        $this->allowExt=$allowExt;
        $this->uploadPath=$uploadPath;
        $this->imgFlag=$imgFlag;
        $this->fileInfo=$_FILES[$this->fileName];
    }

//    检测上传文件是否出错
    protected function checkError(){
        if($this->fileInfo['error']>0){
            switch($this->fileInfo['error']){
                case 1:
                    $this->error='超过了PHP配置文件中upload_max_filesize选项的值';
                    break;
                case 2:
                    $this->error='超过了表单中MAX_FILE_SIZE设置的值';
                    break;
                case 3:
                    $this->error='文件部分被上传';
                    break;
                case 4:
                    $this->error='没有选择上传文件';
                    break;
                case 6:
                    $this->error='没有找到临时目录';
                    break;
                case 7:
                    $this->error='文件不可写';
                    break;
                case 8:
                    $this->error='由于PHP的扩展程序中断文件上传';
                    break;
            }
            return false;
        }
        return true;
    }
//    检测上传文件大小
    protected function checkSize(){
        if($this->fileInfo['size']>$this->maxSize){
            $this->error='上传文件过大';
            return false;
        }
        return true;
    }
//    检测扩展名
    protected function checkExt(){
        $this->ext=strtolower(pathinfo($this->fileInfo['name'],PATHINFO_EXTENSION));
        if(!in_array($this->ext,$this->allowExt)){
            $this->error='不允许的扩展名';
            return false;
        }
        return true;
    }
//    检测文件类型
    protected function checkMime(){
        if(!in_array($this->fileInfo['type'],$this->allowMime)){
            $this->error='不允许的文件类型';
            return false;
        }
        return true;
    }
//    检测是否为真实图片
    protected function checkTrueImg(){
        if($this->imgFlag){
            if(!@getimagesize($this->fileInfo['tmp_name'])){
                $this->error='不是真实图片';
                return false;
            }
            return true;
        }
    }
//    检测是否通过HTTP POST方式上传
    protected function checkHTTPPost(){
        if(!is_uploaded_file($this->fileInfo['tmp_name'])){
            $this->error='文件不是通过HTTP POST方式上传上来的';
            return false;
        }
        return true;
    }
//    显示错误
    protected  function showError(){
        exit('<span style="color:red">'.$this->error.'</span>');
    }
//    检测目录不存在则创建
    protected function checkUploadPath(){
        if(!file_exists($this->uploadPath)){
            mkdir($this->uploadPath,0777,true);
        }
    }
//    产生唯一字符串
    protected function getUniName(){
        return md5(uniqid(microtime(true),true));
    }
    public function uploadFile(){
        if($this->checkError()&&$this->chekSize()&&$this->checkExt()&&$this->checkMime()&&$this->checkTrueImg()&&$this->checkHTTPPost()){
            $this->checkUploadPath();
            $this->uniName=$this->getUniName();
            $this->destination=$this->uploadPath.'/'.$this->uniName.'.'.$this->ext;
            if(move_uploaded_file($this->fileInfo['tmp_name'],$this->destination)){
                return $this->destination;
            }else{
                $this->error='文件移动失败';
                $this->showError();
            }
        }else{
            $this->showError();
        }
    }
}