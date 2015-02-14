<?php
namespace Home\Model;

//因为启动数据表视图模型，必须继承 ViewModel ，注释 Model
//use Think\Model;
use Think\Model\ViewModel;

class CaseFeeViewModel extends ViewModel {
	
	//定义 CaseFee 表与 Case 表的视图关系
	protected $viewFields = array(
		'CaseFee'	=>	array(
			'case_fee_id',
			'case_id',
			'fee_type_id',
			'official_fee',
			'service_fee',
			'oa_date',
			'due_date',
			'allow_date',
			'finish_date',
			'payer_id',
			'bill_id',
			'invoice_id',
			'claim_id',
			'_type'=>'LEFT'
		),
		
		'Case'	=>	array(
			'our_ref',
			'_on'	=>	'Case.case_id=CaseFee.case_id'
		),
		
		'FeeType'	=>	array(
			'fee_type_name',
			'_on'	=>	'FeeType.fee_type_id=CaseFee.fee_type_id'
		),	
		
		'Payer'	=>	array(
			'payer_name',
			'_on'	=>	'Payer.payer_id=CaseFee.payer_id'
		),
	);
	
	//返回本数据视图的所有数据
	public function listAll() {
		$order['bill_date']	=	'desc';
		$list	=	$this->field(true)->order($order)->select();
		return $list;
	}
		
	//返回本数据视图的基本数据
	public function listBasic() {
		$list	=	$this->listAll();
		return $list;
	}
	
	//分页返回本数据视图的所有数据，$p为当前页数，$limit为每页显示的记录条数
	public function listPage($p,$limit) {
		$order['bill_date']	=	'desc';	
		$list	=	$this->field(true)->order($order)->page($p.','.$limit)->select();
		
		$count	= $this->count();
		
		$Page	= new \Think\Page($count,$limit);
		$show	= $Page->show();
		
		return array("list"=>$list,"page"=>$show);
	}
}