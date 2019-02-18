<?php
namespace app\index\controller;
use think\Controller;

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

                $code=input('code');                //这是提取页面上打字输入的code即验证码
                if(captcha_check($code)){       //给function.php中定义的函数check_code，然后它返回真假
                    $user=db('user')->where($data)->find();
                    if ($user==null) {
                        //用户不存在或密码错误
                        $this->error('用户不存在或密码错误');
                    }else{
                        $_SESSION=$user;
                        $this->redirect('Index/index');
                        $this->error('验证码错误');
                    }
                }else{
                     $this->error('验证码错误');
                }

            }else{
                //普通访问
                return view();
            }

        }
    }

    //验证码
    public function verify(){
        $Verify = new \think\Verify();
        $Verify->length = 4;
        $Verify->entry();

    }
}
