<?php
namespace app\index\controller;
use think\Controller;

class Common extends Controller
{
	public function __construct(){
		parent::__construct();
		$this->nav();
	}
    public function nav()
    {

        $cateRes=model('cate')->cateTree();

        $catepid=db('cate')->field(array('pid'))->select();
                static $arr=array(); // 创建静态数组
                foreach($catepid as $k => $v){
                    $arr[]=$v['pid'];

                }
                $catepid=array_unique($arr);

        $ccRR=db('cate')->where('pid=4')->select();

        $this->assign([
            'cateRes'=>$cateRes,
            'catepid'=>$catepid,
            'ccRR'=>$ccRR,
        ]);
        return view();

    }
}
