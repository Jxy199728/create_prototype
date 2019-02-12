<?php
namespace app\admin\validate;
use think\Validate;
class Media extends Validate
{
    // 验证规则
    protected $rule =   [
        'title'  => 'require',
    ];

    // 验证提示
    protected $message  =   [
        'title.require' => '标题必填，不得为空',

    ];


}
