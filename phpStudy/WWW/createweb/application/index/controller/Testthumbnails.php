<?php
namespace app\index\controller;
use think\Controller;

class Testthumbnails extends Controller
{
    public function index()
    {
        if (isset($_POST['submit'])) {
            $ffmpeg = "D:\\ffmpegdownload\\ffmpeg\\bin\\ffmpeg.exe";
            echo $ffmpeg;
            $videoFile = $_FILES["video"]["tmp_name"];
            $imageFile = "1.jpg";
            $size = "120x90";
            $getFromSecond = 5;
            $cmd = "$ffmpeg -i $videoFile -an -ss $getFromSecond -s $size $imageFile";
            exec($cmd);

        }
        return view();

    }
}