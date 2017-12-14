<?php
namespace V1\Common;
use Think\Controller;
class ApiController extends Controller {

	protected $appid = 'wx00c21901537bc5a6';
	protected $secret = '821ab731206d8993146f3d151d6217b5';
	protected $use_wx = TRUE;
	protected $wx;

	public function __construct(){
		parent::__construct();
		Vendor('Wx');

		session('user', '1');

		$this->checkLogin();
		if($this->use_wx)
			$this->wx = $this->wx();
	}

	private function checkLogin(){
		$path_info = I('server.PATH_INFO', '');
		if(FALSE !== strpos($path_info, 'user/login'))
		{
			return TRUE;
		}
		$path_info = explode('/', $path_info);
		if(empty($path_info[0]) || empty($path_info[1]))
		{
			$this->apiReturn('url错误', FALSE);
		}
		if(empty(session('user')) && empty(session('acc')))
		{
			$this->goLogin();
		}
	}

	protected function goLogin()
	{
		$result = array(
			'code'    => 2,
			'message' => '请登录',
			'data'    => NULL
		);
		$this->ajaxReturn($result);
	}

	protected function apiReturn($data = array(), bool $correct = TRUE)
	{
		$result = array(
			'code'    => 0,
			'data'    => $data
		);
		if( ! $correct)
		{
			$result = array(
				'code'    => 1,
				'message' => $data
			);
		}
		$this->ajaxReturn($result);
	}

	private function wx()
	{
        if(empty(S('access_token')))
        {
	        $wx = new \Wx($this->appid, $this->secret);
	        S('access_token', $wx->getAccess_token, 3600);
	        return $wx;
        }
        return new \Wx($this->appid, $this->secret, S('access_token'));
	}

}