<?php
namespace app\index\controller;
use think\Controller;

class Media extends Common
{
    public function crNews(){
        $crnews=db('media')->where('cate_id=5')->select();
        $this->assign([
            'crnews'=>$crnews,
        ]);
        return view();
    }

    public function crNewsContent(){
        $id=input('id');
        $crnc=db('media')->find($id);
        $this->assign([
            'crnc'=>$crnc,
        ]);
        return view();
    }

    public function odNews(){
        $odnews=db('media')->where('cate_id=6')->select();
        $this->assign([
            'odnews'=>$odnews,
        ]);
        return view();
    }

    public function odNewsContent(){
        $id=input('id');
        $odnc=db('media')->find($id);
        $this->assign([
            'odnc'=>$odnc,
        ]);
        return view();
    }
}
