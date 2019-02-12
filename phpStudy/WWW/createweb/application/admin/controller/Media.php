<?php
namespace app\admin\controller;
use think\Controller;

class Media extends Controller
{
    public function add()
    {
        if(request()->isPost()) {
            $data=input('post.');
            $data['addtime']=time();

            // 处理上传图片
            if($_FILES['med_pic']['tmp_name']){
                $data['med_pic']=$this->upload();
            }

            // 执行验证
            $validate = validate('media');
            if(!$validate->check($data)){
                $this->error($validate->getError());
            }

            $add=db('media')->insert($data);
            if($add){
                $this->success("内容添加成功",url("lst"));
            }else{
                $this->error("内容添加失败");
            }
        }
        $catepid=db('cate')->field(array('pid'))->select();
        static $arr=array(); // 创建静态数组
        foreach($catepid as $k => $v){
            $arr[]=$v['pid'];
        }
        $catepid=array_unique($arr);

        $cateRes=model('cate')->cateTree();
        $this->assign([
            'cateRes'=>$cateRes,
            'catepid'=>$catepid,
        ]);
        return view();

    }

    public function edit()
    {
        if(request()->isPost()) {
            $data=input('post.');

            // 处理上传图片
            if($_FILES['med_pic']['tmp_name']){

                $oldartpic=db('media')->field('med_pic')->find($id);
                $oldpicSrc=IMG_UPLOADS.$oldartpic['med_pic'];
                if(file_exists($oldpicSrc)){
                    @unlink($oldpicSrc); // 执行删除
                }
                $data['med_pic']=$this->upload();
            }

            // 执行验证
            $validate = validate('media');
            if(!$validate->check($data)){
                $this->error($validate->getError());
            }

            $save=db('media')->update($data);
            if(!$save==false){
                $this->success("内容添加成功",url("lst"));
            }else{
                $this->error("内容添加失败");
            }
        }

        // 获取旧数据
        $id=input('id');
        $medid=db('media')->find($id);

        $catepid=db('cate')->field(array('pid'))->select();
        static $arr=array(); // 创建静态数组
        foreach($catepid as $k => $v){
            $arr[]=$v['pid'];
        }
        $catepid=array_unique($arr);

        $cateRes=model('cate')->cateTree();
        $this->assign([
            'cateRes'=>$cateRes,
            'catepid'=>$catepid,
            'medid'=>$medid,
        ]);
        return view();

    }

    public function lst(){
        $medRes=db('media')->alias('m')->field('m.*,b.cate_name')->join('cr_cate b','m.cate_id=b.id')->paginate(5);
        $this->assign([
            'medRes'=>$medRes,
        ]);
        return view();
    }

    // 图片上传
    public function upload(){
        // 获取表单上传文件 例如上传了001.jpg
        $file = request()->file('med_pic');

        // 移动到框架应用根目录/public/uploads/ 目录下
        if($file){
            $info = $file->move(ROOT_PATH . 'public' . DS .'static'. DS . 'uploads');
            if($info){
                // 成功上传后 获取上传信息
                // 输出 20160820/42a79759f284b767dfcb2a0197904287.jpg
                return $info->getSaveName();
            }else{
                // 上传失败获取错误信息
                echo $file->getError();
                die();
            }
        }
    }


}
