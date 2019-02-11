<?php
namespace app\admin\controller;
use think\Controller;

class Cate extends Controller
{
    public function add()
    {
        if(request()->isPost()){
            $data=Input('post.');
            $data['time']=time();

            // 执行验证
            $validate = validate('cate');
            if(!$validate->scene('add')->check($data)){
                $this->error($validate->getError());

            }

            $add=model('cate')->save($data);
            if($add){
                $this->success('添加栏目成功',url('lst'));
            }else{
                $this->error('添加栏目失败');
            }
        }
        $cateRes=model('cate')->cateTree();

        // 分配数据
        $this->assign([
            'cateRes'=>$cateRes,
        ]);

        return view();

    }

    public function lst(){
        $cateRes=model('cate')->cateTree();
        $this->assign([
            'cateRes'=>$cateRes,
        ]);
        return view();
    }

    public function del(){
        $id=input('id');
        $childIds=model('cate')->getChildIds($id);
        $childIds[]=intval($id);
        //dump($childIds);die();
        //删除栏目后删除栏目下文章S
        //$_childIds=implode(',',$childIds);//所有要删除的文章 用‘,’组合成一个字符串 1,2,3
        //db('article')->where('cate_id','in',$childIds)->delete();//批量删除
        //删除栏目后删除栏目下文章E
        $del=db('cate')->delete($childIds);
        if ($del !== false) {
            $this->success('删除栏目成功!',url('lst'));
        }else{
            $this->error('删除栏目失败!');
        }
    }

    public function edit(){
        if(request()->isPost()){
            $data=Input('post.');

            $save=model('cate')->update($data);
            if(!$save==false){
                $this->success('修改栏目成功',url('lst'));
            }else{
                $this->error('修改栏目失败');
            }
        }
         $id=input('id');
         $myself=db('cate')->find($id);

         $childIds=model('cate')->getChildIds($id);
         $childIds[]=intval($id);

         $cateRes=model('cate')->cateTree();

         // 分配数据
         $this->assign([
             'cateRes'=>$cateRes,
             'myself'=>$myself,
             'childIds'=>$childIds
         ]);

         return view();
    }

}
