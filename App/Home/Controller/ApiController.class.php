<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/1/5
 * Time: 17:47
 */

namespace Home\Controller;


use Think\Controller;
use think\Db;
use Think\Exception;
use think\Model;

header("Content-Type: text/html;charset=utf-8");

class ApiController extends Controller
{
    public function api()
    {
        $request = I('');
        if (empty($request)) {
            return $this->ajaxReturn($this->error());
            exit();
        }
        $m = $request['m'];
        if (!empty($m)) {
            $apiName = 'api_' . $m;
            if (!method_exists($this, $apiName)) {
                // 方法不存在
                return $this->ajaxReturn($this->error());
                exit();
            }
            $this->$apiName();
        } else {

            return $this->ajaxReturn($this->error());
            exit();
        }
        //    return $this->$apiName();
    }

    public function info($condition)
    {
        // 响应状态和文字
        if ($condition) {
            $json['status'] = 200;
            $json['info'] = '请求成功';
        } else {
            $json['status'] = 400;
            $json['info'] = '请求失败，请参见API文档';
        }
        return $json;
    }

    public function error($info)
    {
        // 返回错误
        $attr = I('post.');
        $json = $this->info(false);
        if (isset($info)) $json['info'] = $info;
        return $attr['callback'] === null ? $json : jsonp($json);
    }

    public function api_qrcode()
    {


        $ordersn = self::create_order_sn();
        $qrcode_url = 'http://' . $_SERVER['HTTP_HOST'] .U("Order/cashier",['osn' => $ordersn, 'ltime' => time() + 300],false);

        Vendor('phpqrcode.phpqrcode');

        $object = new \QRcode();

        $qrcode = '/Data/apiQrcode/' . $ordersn . '.jpg';

        $object->png($qrcode_url, $_SERVER['DOCUMENT_ROOT'] . $qrcode, 2, 6.4, 2);

        try {
            $post = I('post.');
            $check_res = check_data($post, ['price', 'dsn', 'ctype']);
            if (isset($check_res['status'])) throw new Exception($check_res['msg'], 11000);
            $price = $post['price'];
            $device_sn = $post['dsn'];
            $choose_type = $post['ctype'];
            $in = [
                'osn' => $ordersn, 'price' => $price, 'device_sn' => $device_sn
            ];
            $Dmodel = M('device_order');
            $Dmodel->add($in);
            return $this->ajaxReturn(['status' => 1, 'url' => $qrcode_url, 'msg' => C('IMG_URL') . $qrcode]);
        } catch (\Exception $ex) {
            return $this->ajaxReturn(['status' => '501', 'msg' => '内部错误']);
           // throw new Exception($ex, 100);
        }

    }

    public function api_order()
    {
        $post = I('post');
        $check_res = check_data($post, ['osn', 'ltime']);
        if (isset($check_res['status'])) throw new Exception($check_res['msg'], 11000);
        $osn = $post['osn'];
        $ltime = $post['ltime'];
        if ($ltime > time()) {
            //超时
            return $this->ajaxReturn(['status' => '300', 'msg' => '超时！请重新下单']);
        } else {
            $file='/Data/apiQrcode/' . $osn . '.jpg';
            $result = @unlink ($file);


        }
    }

    private function create_order_sn()

    {

        return '9' . date('YmdHis') . rand(10000, 99999);

    }
}