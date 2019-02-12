<?php
namespace app\index\controller;
use think\Controller;

class Index extends Controller
{
    public function index()
    {

        //$navers=db('cate')->select();
        //$this->assign([
        //    'navers'=>$navers,
        //]);
        $cateRes=model('cate')->cateTree();
        $this->assign([
            'cateRes'=>$cateRes,
        ]);
        return view();

    }
}
