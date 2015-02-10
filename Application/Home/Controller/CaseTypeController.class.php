<?php
namespace Home\Controller;
use Think\Controller;

class CaseTypeController extends Controller {
    
	//默认跳转到listCaseType，显示case_type表列表
	public function index(){
        header("Location: listCaseType");
    }
	
	//列表，其中，$p为当前分页数，$limit为每页显示的记录数
	public function listCaseType(){
		$p	= I("p",1,"int");
		$limit	= 10;
		$case_type_list = D('CaseType')->listCaseType($p,$limit);
		$this->assign('case_type_list',$case_type_list['case_type_list']);
		$this->assign('case_type_page',$case_type_list['case_type_page']);

		$this->display();
	}
	
	//新增
	public function add(){
		$data	=	array();
		$data['case_type_name']	=	trim(I('post.case_type_name'));
		
		if(!$data['case_type_name']){
			$this->error('未填写费用名称');
		} 

		$result = D('CaseType')->addCaseType($data);
		
		if(false !== $result){
			$this->success('新增成功', 'listCaseType');
		}else{
			$this->error('增加失败');
		}
	}
		
	public function edit(){
		if(IS_POST){
			
			$case_type_id	=	trim(I('post.case_type_id'));
			
			$data=array();
			$data['case_type_name']	=	trim(I('post.case_type_name'));

			$result = D('CaseType')->editCaseType($case_type_id,$data);
			if(false !== $result){
				$this->success('修改成功', 'listCaseType');
				//header("Location: listCaseType");
			}else{
				$this->error('修改失败');
			}
		} else{
			$case_type_id = I('get.id',0,'int');

			if(!$case_type_id){
				$this->error('未指明要编辑的客户');
			}

			$case_type_list = D('CaseType')->getByCaseTypeId($case_type_id);
			
			$this->assign('case_type_list',$case_type_list);

			$this->display();
		}
	}
}