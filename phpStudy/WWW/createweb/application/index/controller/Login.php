<?php
namespace app\index\controller;
use think\Controller;
use think\Session;

class Login extends Controller
{
     public function login()
    {
        if (isset($_SESSION['user_name'])) {
            //已登陆
            $this->redirect('Index/index');
        }else{
                //未登录
            if (request()->isPost()) {
                //提交登陆数据
                $data=input('post.');
                $name = $data['user_name'];
                $password = $data['user_password'];
                $code = $data['code'];

                //调用验证器
                $validate = validate('login');
                //验证是否符合验证器里定义(验证码)的规范,不符合返回错误信息
                if(!$validate->check($data)){
                    $this->error($validate->getError());
                }


                //$data = ['user_name' => $name, 'user_password' => $password, 'code' => $code];


                //查询数据试库
                $where['user_name'] = $name;
                $userInfo = db('user')->where($where)->find();
                if ($userInfo && $userInfo['user_password'] === $password) {
                    //登入成功，存入session
                    Session::set('user',['user_name' => $userInfo['user_name'],'user_id' => $userInfo['user_id'],'logintime' => time()]);
                    $this->success('登录成功',url('Index/index'));
                } else {
                    $this->error('用户名或密码错误!',url('Index/index'));
                }

            }else{
                //普通访问
                return view();
            }

        }
    }

}
