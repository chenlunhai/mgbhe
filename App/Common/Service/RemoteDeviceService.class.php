<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/1/2
 * Time: 15:08
 */

namespace Common\Service;


use Think\Exception;

class RemoteDeviceService
{
    const APIURL = 'http://www.wee188.com/WebSerivces/ThirdWebService.asmx?WSDL';    #热饮咖啡机接口地址

    public function HotCoffee($param)
    {
        try {


            header("content-type:text/html;charset=utf-8");
            $client = new SoapClient(self::APIURL);
            $p = $client->__soapCall('AddMemberInfo', array('parameters' => $param));
            $s = json_decode($p->AddMemberInfoResult);
            if ($s->code == "success") {
                return true;
            } else {
                return false;
            }
        } catch (\Exception $e) {
            return false;
        }
    }

    public function GetSign($str)
    {
        try {
            header("content-type:text/html;charset=utf-8");
            $client = new SoapClient(self::APIURL);
            $param = array('strSignValue' => $str);
            $p = $client->__soapCall('GetSignValue', array('parameters' => $param));
            return $p->GetSignValueResult;
        } catch (\Exception $e) {
            return "error";
        }
    }

}