<?php
namespace V1\Controller;
use V1\Common\ApiController;
class WishController extends ApiController {
	protected $use_wx = TRUE;
	protected $wish;

	public function __construct()
	{
		parent::__construct();
		$this->wish = D('wish');
	}

	public function list()
	{
		$u_id = session('user');
		$list = $this->wish->list($u_id);
		$this->apiReturn($list);
	}

	public function pubPage()
	{
		$user = D('user');
		$userInfo = $user->userInfo();
		if(FALSE === $userInfo)
		{
			$this->apiReturn($user->getError(), FALSE);
		}
		//模板暂未通过审核
		// $userList = D('nefuer')->list();
		// $template_id = '';
		// $data = array();
		// $url = 'http://wish.nefuer.net/';
		// for($i = 0, $iloop = count($userList); $i < $iloop; $i++)
		// {
		// 	$this->wx->msgTemp($openid, $template_id, $data, $url);
		// }
		return $userInfo;
	}

	public function pub()
	{
		$data = I('post.');
		$u_id     = session('user');
		$content  = $data['content'];
		$img      = $data['img'];
		$guy      = $data['guy'];
		$phone    = $data['phone'];
		$deadline = $data['deadline'];

		$user = D('user');
		$userInfo = $user->userInfo();
		if(FALSE === $userInfo)
		{
			$this->apiReturn($user->getError(), FALSE);
		}
		if(empty($content))
			$this->apiReturn('请填写心愿内容', FALSE);
		if(empty($guy))
			$this->apiReturn('请填写联系人', FALSE);
		if(empty($phone))
			$this->apiReturn('请填写联系方式', FALSE);
		if(empty($deadline))
			$this->apiReturn('请填写截止时间', FALSE);
		$deadline = strtotime($deadline);
		if($deadline - time() < 900)
			$this->apiReturn('截止时间至少为15分钟，请修改', FALSE);

		$this->wish->pub($u_id, $content, $img,  $guy, $phone, $deadline);
		$this->apiReturn();
	}

	public function info()
	{
		$id = I('get.id');
		if(empty($id))
			$this->apiReturn('请指定心愿id', FALSE);

		$wishInfo = $this->wish->wishInfo($id);
		if(FALSE === $wishInfo)
		{
			$this->apiReturn($this->wish->getError(), FALSE);
		}
		$this->apiReturn($wishInfo);
	}

	public function cancel()
	{
		$id = I('post.id');
		$reason = I('post.reason');
		if(empty($id))
			$this->apiReturn('请指定心愿id', FALSE);
		if(empty($reason))
			$this->apiReturn('请填写取消原因', FALSE);
		$wishCancel = $this->wish->cancel($id, $reason);
		if(FALSE === $wishCancel)
		{
			$this->apiReturn($this->wish->getError(), FALSE);
		}
		$this->apiReturn();
	}

	public function accept()
	{
		$u_id = session('acc');
		if(empty($u_id))
			$this->apiReturn('请使用学生端登录');
		$data = I('post.data');
		$id = $data['id'];
		$guy = $data['guy'];
		$phone = $data['phone'];
		if(empty($id))
			$this->apiReturn('请指定心愿id', FALSE);
		if(empty($guy))
			$this->apiReturn('请填写联系人', FALSE);
		if(empty($phone))
			$this->apiReturn('请填写联系方式', FALSE);

		$wishAccept = $this->wish->accept($id, $u_id, $guy, $phone);
		if(FALSE === $wishAccept)
		{
			$this->apiReturn($this->wish->getError(), FALSE);
		}
		$this->apiReturn();
	}

	public function confirm()
	{
		$id = I('post.id');
		if(empty($id))
			$this->apiReturn('请指定心愿id', FALSE);
		$wishConfirm = $this->wish->confirm($id);
		if(FALSE === $wishConfirm)
		{
			$this->apiReturn($this->wish->getError(), FALSE);
		}
		$this->apiReturn();
	}
}