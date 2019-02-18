<?php
namespace app\index\controller;
use think\Controller;
class Base extends Controller {
	public function _initialize()
	{
		if (isset($_SESSION['user_name'])) {
			//已登陆，不做任何操作
		}else{
			$this->error('请先登录!',url('Login/login'));
		}
	}
    
}