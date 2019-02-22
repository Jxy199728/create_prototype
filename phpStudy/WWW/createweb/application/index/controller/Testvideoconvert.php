<?php
namespace app\index\controller;
use think\Controller;

class Testvideoconvert extends Controller
{
    public function index()
    {
        if(isset($_POST['submit'])){
	$currentPath=$_FILES["video"]["tmp_name"];
                exec("__ROOT__/ffmpeg.exe");
                exec("ffmpeg -i ".$currentPath." -an ./output/video.mp4");}
        
        return view();
    }

}