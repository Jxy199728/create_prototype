<?php
namespace app\index\validate;
use think\Validate;
class Login extends Validate
{
    protected $rule =   [
        'user_name'  => 'require',
        'user_password'  => 'require',
        'code' => 'require|checkCaptcha:null'
    ];

    protected $message  =   [
        'user_name.require' => '用户名不得为空',
        'user_password.require' => '密码不得为空',
        'code.require' => '验证码不得为空',
    ];


    protected function checkCaptcha($value)  //验证码输入的进验证的它
    {
        if(captcha_check($value)) {
           return true;
        }else{
           // 校验失败
           return '验证码错误!';
        }

    }


}
