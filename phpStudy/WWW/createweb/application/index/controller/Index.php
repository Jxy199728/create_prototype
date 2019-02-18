<?php
namespace app\index\controller;
use think\Controller;

class Index extends Common
{
    public function index()
    {
        $pdRes=db('product')->where('cate_id=7')->select();
        $pdfRes=db('product')->where('cate_id=8')->select();
        $this->assign([
            'pdRes'=>$pdRes,
            'pdfRes'=>$pdfRes,
        ]);
        return view();
    }

}
