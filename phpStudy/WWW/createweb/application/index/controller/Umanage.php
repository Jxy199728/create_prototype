<?php
namespace app\index\controller;
use think\Controller;

class Umanage extends Ucommon{
    public function video(){
        $ucateid=1;
        $ucateids=db('ucate')->find($ucateid);
        $this->assign([
            'ucateids'=>$ucateids,
        ]);
        return view();
    }
    public function upload(){
        $ucateid=1;
        $ucateids=db('ucate')->find($ucateid);
        $this->assign([
            'ucateids'=>$ucateids,
        ]);
        return view();
    }
    public function classify(){
        $ucateid=1;
        $ucateids=db('ucate')->find($ucateid);
        $this->assign([
            'ucateids'=>$ucateids,
        ]);
        return view();
    }
}