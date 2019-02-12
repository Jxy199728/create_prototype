<?php
namespace app\index\model;
use think\Model;
class Cate extends Model
{
	protected $field=true;

	// 无限极栏目
    public function cateTree(){
        $data=$this->order('id desc')->select();
        return $this->sortCate($data);
    }

    public function sortCate($data,$pid=0,$level=0){
        static $arr=[];
        foreach ($data as $k => $v) { //找顶级栏目  v是他的值
            if ($v['pid']==$pid) {//如果是顶级栏目就将其放进数组里
                $v['level']=$level;
                $arr[]=$v;
                $this->sortCate($data,$v['id'],$level+1);//找到顶级栏目后找其他栏目
            }
        }
        return $arr;
    }

}