<?php
namespace app\index\controller;
use think\Controller;

class Ucommon extends Controller
{
	public function __construct(){
		parent::__construct();
		$this->nav();

	}
    public function nav()
    {
        $ucateRes=db('ucate')->select();

        $this->assign([
            'ucateRes'=>$ucateRes,

        ]);
        return view();

    }

}
