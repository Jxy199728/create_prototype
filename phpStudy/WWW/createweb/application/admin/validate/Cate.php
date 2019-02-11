<?php
namespace app\admin\validate;
use think\Validate;
class Cate extends Validate
{
    protected $rule =   [
        'cate_name'  => 'require|unique:cate|min:3',
        'cate_desc'  => 'require',
    ];

    protected $message  =   [
        'cate_name.require' => '栏目名称不得为空',
        'cate_name.unique' => '栏目不得重复',
        'cate_name.min' => '栏目名称过短',
        'cate_desc.require' => '栏目描述不得为空',

    ];

    //protected $scene = [
    //    'edit'  =>  ['cate_name'],
    //    'add'  =>  ['cate_name'],
    //];


}
