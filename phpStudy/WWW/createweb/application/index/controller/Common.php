<?php
namespace app\index\controller;
use think\Controller;

class Common extends Controller
{
	public function __construct(){
		parent::__construct();
		$this->nav();

		//
		$this->comments();
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

        $ccRR=db('cate')->where('pid=2||pid=4')->select();

        $this->assign([
            'cateRes'=>$cateRes,
            'catepid'=>$catepid,
            'ccRR'=>$ccRR,
        ]);
        return view();

    }

    public function comments(){
        // 留言
        if(request()->isPost()){
            $data=input('post.');
            $data['time']=time();
            $add=db('message')->insert($data);
            if($add){
                $this->success('留言成功！');
            }else{
                $this->error('留言失败');
            }
        }

        // 传到指定文章下
        $id=input('id');
        $medid=db('media')->find($id);

        // 显示

        // 取出留言
        $messRes=db('message')->select();
        $this->assign([
            'messRes'=>$messRes,
            'medid'=>$medid,
        ]);

        return view();
    }
}
