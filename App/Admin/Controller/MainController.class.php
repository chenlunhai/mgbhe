<?php
namespace Admin\Controller;
use Think\Controller;
use Common\Service\LogService;
class MainController extends Controller {
	static $adminid;
    static $adminname;

	public function _initialize(){
        G('begin');
        self::setAid();    #管理员是否登陆
        $this->inLog(); #写入日志
    }
    /**
     * 写入日志
     * @param 2017/11/6
     * @param $type:0(开始)、1(结束),$runtime string
     */
    private function inLog($type = 0,$runtime=0)
    {
        $LogService = new LogService();

        $info = [
            0 => [
                'status'=>'begin','time'=>date('Y-m-d H:i:s',NOW_TIME),'ip'=>get_client_ip(),'adminname'=>self::$adminname,'controller_name'=>CONTROLLER_NAME,'action_name'=>ACTION_NAME,'url'=>getFullUrl(),
            ],
            1 => [
                'status'=>'end','runtime'=>$runtime,
            ],
        ];
        $LogService->write(json_encode($info[$type]));
    }
    private function setAid()
    {
        $admin_info = session('admin_info');
        $this->assign('admin_info',$admin_info);
        if($admin_info['id'] > 0){
            self::$adminid   = $admin_info['id'];
            self::$adminname = $admin_info['adminname'];
        }
        
    }
    public function __destruct(){
        G('end');
        $runtime = G('begin','end').'s';
        $this->inLog(1,$runtime);
    }
}