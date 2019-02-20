<?php
namespace app\index\controller;

use think\Db;
use think\Cache;
use think\Session;
class Change
{
    public function video(){
        return view();
    }
    public function split(){
        return view();
    }
    public function crop(){
        return view();
    }
	//检测是否有断点
	public function check_breakpoint(){
		$post=request()->post();
		// 找出分片目录
		$dir=ROOT_PATH . 'data' . DS . 'upload'.DS.'video'.DS.$post['fileMd5'];
		if (file_exists($dir)) {
			// 扫描文件
			$block_info=scandir($dir);
			// 去除无用文件
			foreach ($block_info as $key => $block) {
				 if ($block == '.' || $block == '..') unset($block_info[$key]);
			}
			natsort($block_info);
			$end=end($block_info);
	    	if ($end>$post['chunk'] || $end==$post['chunk']) {
	    		echo json_encode(["ifExist"=>"1",'block_info'=>$end]);
	    	}

		}else{
			// 无断点
		    echo json_encode(["ifExist"=>"0"]);
		}

	}

	// 视频上传
	public function vupload(){
		$post=request()->post();
		$dir=ROOT_PATH . 'data' . DS . 'upload'.DS.'video'.DS.$post['fileMd5'];
		$file = request()->file('file');
		if (file_exists($dir)) {
			$block_info=scandir($dir);
			natsort($block_info);
			// 去除无用文件
			foreach ($block_info as $key => $block) {
				 if ($block == '.' || $block == '..') unset($block_info[$key]);
			}
			$end=end($block_info);
			if ($post['chunk']>$end) {
				$info = $file->move($dir.DS.$post['chunk'],'');

			}

			if (isset($info)) {
	        	die('{"status":1,"msg":"正在上传请稍等"}');
			}else{
				die('{"status":0,"msg":"跳过 "}');
			}
		}else{
			if (empty($post['chunk'])) {
				$info = $file->move($dir.DS.'0','');
			}else{
				$info = $file->move($dir.DS.$post['chunk'],'');
			}
			if ($info) {
	        	die('{"status":1,"msg":"正在上传请稍等"}');
			}
		}


  	}

	// 合并视频
  	public function vupload_merge()
  	{
  		$post=request()->post();
  		$dir=ROOT_PATH . 'data' . DS . 'upload'.DS.'video'.DS.$post['fileMd5'];
  		$block_info = scandir($dir);
  		 // 除去无用文件
  		 foreach ($block_info as $key => $block) {
  		     if ($block == '.' || $block == '..') unset($block_info[$key]);
  		 }
  		 // 数组按照正常规则排序
  		 natsort($block_info);
  		 // 定义保存文件
  		 $save_file = ROOT_PATH . 'data' . DS . 'upload'.DS.'video'.DS.date('Ymd');

  		 // 没有？建立
  		 if (!file_exists($save_file)) {
  		 	@mkdir ($save_file,0755,true);
  		 };
  		 $count=count($block_info);
  		 	// 开始写入
  		 	// 获取文件后缀
  		 	$name=explode('.',$post['fileName']);
  		 	$ext=end($name);
  		 	$out = @fopen($save_file.DS.date('Ymdhis').'.'.$ext, "wb");
  		 	$url='video'.DS.date('Ymd').DS.date('Ymdhis').'.'.$ext;
		 	// 增加文件锁
		 	if (flock($out, LOCK_EX)) {
		 	    foreach ($block_info as $b) {
		 	        // 读取文件
 	        	if (!$in = @fopen($dir.DS.$b.DS.$post['fileName'], "rb")) {
 	        	    break;
 	        	}
		 	        // 写入文件
		 	        while ($buff = fread($in, 4096)) {
		 	            fwrite($out, $buff);
		 	        }

		 	        @fclose($in);
		 	        @unlink($dir.'/'.$b);
		 	    }
		 	    flock($out, LOCK_UN);
		 	}
  		 	@fclose($out);
  		 	delete_dir_file($dir);
  		 echo json_encode(["code"=>"0",'url'=>$url]);//
  	}
}