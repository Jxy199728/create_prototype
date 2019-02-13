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
        //$idd=model('cate')->cateTreeId();
        //$id=$cateRes['id'];
        //$id=db('cate')

        $catepid=db('cate')->field(array('pid'))->select();
                static $arr=array(); // 创建静态数组
                foreach($catepid as $k => $v){
                    $arr[]=$v['pid'];

                }
                $catepid=array_unique($arr);

        //$ccRR=db('cate')->where(array('pid')==4)->select();
        $ccRR=db('cate')->where('pid=4')->select();

        //$childIds=model('cate')->getChildIds($idd);
        $this->assign([
            'cateRes'=>$cateRes,
            //'idd'=>$idd,
            //'childIds'=>$childIds,
            'catepid'=>$catepid,
            'ccRR'=>$ccRR,
        ]);
        return view();

    }
}
