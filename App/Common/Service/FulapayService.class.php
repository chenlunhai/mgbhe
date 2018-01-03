<?php
namespace Common\Service;
class FulapayService {
    public function send($province_name, $city_name = '', $bank_name)
    {
        $arr = ['广西省'=>'广西壮族自治区','内蒙古省'=>'内蒙古自治区','宁夏省'=>'宁夏回族自治区','新疆省'=>"新疆维吾尔自治区"];
        if(array_key_exists($province_name,$arr)){
            $province_name = $arr[$province_name];
        }
        
        $service = 'open.bank.branch';
        $fula_appid = '1000161';
        
        // 银行支行信息查询
        $fula_url = "https://api.fulapay.com/open/bank/branch";

        //商户私钥(pkcs8格式)
        // $MCH_PRIVATE_KEY = file_get_contents('rsa_private_key.pem');
        // $MCH_PRIVATE_KEY = file_get_contents('rsa_public_key.pem');
        // print_r($MCH_PRIVATE_KEY);die();
        
        $MCH_PRIVATE_KEY = '-----BEGIN RSA PRIVATE KEY-----
MIICXgIBAAKBgQDx7TVKDrVWnBMDc9pxyCQ4stm3U1RaMwcsBwUn7N0D03B2/RKU
3qFuyn9gVlXSDJWwq3naH6oFPIYeZW7dDu/HteDtwu88QWTMR5oQaBsBtNiq+j0f
vJsdGT/X2jQMWkJvh3N+5nlkO1SGCBUdsBb2HrbCQNmZlm0s9bwuJ//AgwIDAQAB
AoGADMARtOt9hykGn4H1m1WPAyX5732GzpIt6JYeIXKMW21DWiIQXqQ1Id+uQueJ
8l4TbZI8A9DzZv8/mk6CP0hQPr4LZeG+XJJpxjbziph9nQVvy1ODwGJFqKDuvNEn
MKMjAPYPjw97TUKiWZ1IQCDEJ2neMQlQKhXVB8TxAUsuRxECQQD/jpqamkMfn060
UO0nt7/eXb0tKBzP+L9+ewKJIjtUflq1ONPK/n0QCQQ8x2kb9QUu/3s4L3mf92as
aRHdjc5XAkEA8liOXdOKo+UqgrOabeFKzWCijKsuDwV3pmDLPrAlV+oFn1itQPTY
M8XuCDzZtcLC+3SnRj2phioOensdwmXrtQJBAMrcMV+eKsBUXk6GmurXUsg6Uuwg
llaEl8XX8ZhYAw68SlbmqEDQKQhsj9+LT6Vwp0+6X96m2P4hjnA364WahnsCQQCJ
1WgTYS9nC/3jnHbmq845hQ6uZuWpUXi9viuameCDYeyUtoDDgv48ZAR/1uwT/pOb
JLvGrWdvkRfu/Xrth75JAkEAyKI/uFczxG/r6V5Bc7BgJeQ48ixLJty0to/Q+fPz
tKwIhwU5O7MA89Qc17ZO36pgB6/dZa4o+JnYpoAblSSk3w==
-----END RSA PRIVATE KEY-----';

        $data = array(
            'service' => $service,
            'app_id' => $fula_appid,
            'province_name' => $this->urlEncode($province_name),
            'bank_name' => $this->urlEncode($bank_name),
            'charset' => 'UTF-8',
            'sign_type' => 'RSA',
            'nonce_str' => uniqid(),
        );

        if ($city_name) {
            $data['city_name'] = $this->urlEncode($city_name);
        }

        ksort($data);
        $string = $this->makeString($data);
        $sign = $this->makeSign($string, $MCH_PRIVATE_KEY);
        $data['sign'] = $sign;
        $header = array('Content-type: text/html');
        $data = $this->array2xml($data);

        // var_export($data);die();

        $result = $this->http($fula_url, $data, 'POST', $header);
        $result = $this->xml2array($result);

        return $result;

        if ($result['res_code'] == '0000' && $result['result_code'] == 'S') {
           return $result['data'];
        }
        return false;
    }

    private function urlEncode($string)
    {
        return $string;
        // return urlencode(utf8_encode($string));
    }

    private function makeString($data)
    {
        $flag = 1;
        foreach ($data as $k => $v) {
            if ($flag) {
                $string = $k . '=' . $v;
                $flag = 0;
            } else {
                $string .= '&' . $k . '=' . $v;
            }
        }
        return $string;
    }

    private function http($url, $params, $method = 'GET', $httpHeader = '', $ssl = false)
    {
        $opts = array(CURLOPT_TIMEOUT => 2, CURLOPT_RETURNTRANSFER => 1, CURLOPT_SSL_VERIFYPEER => false, CURLOPT_SSL_VERIFYHOST => false);
        /* 根据请求类型设置特定参数 */
        switch (strtoupper($method)) {
            case 'GET':
                $getQuerys = !empty($params) ? '?' . urldecode(http_build_query($params)) : '';
                $opts[CURLOPT_URL] = $url . $getQuerys;
                // Log::record($opts[CURLOPT_URL]);
                break;
            case 'POST':
                $opts[CURLOPT_URL] = $url;
                $opts[CURLOPT_POST] = 1;
                $opts[CURLOPT_POSTFIELDS] = $params;
                break;
        }
        /* 初始化并执行curl请求 */
        $ch = curl_init();
        if (!empty($httpHeader) && is_array($httpHeader)) {
            curl_setopt($ch, CURLOPT_HTTPHEADER, $httpHeader);
        }
        curl_setopt_array($ch, $opts);
        curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_0);
        $data = curl_exec($ch);
        $err = curl_errno($ch);
        $errmsg = curl_error($ch);
        curl_close($ch);
        if ($err > 0) {
            return false;
        } else {
            return $data;
        }
    }

    private function makeSign($string, $priKey)
    {
        $res = openssl_pkey_get_private($priKey);
        $signature = '';
        openssl_sign($string, $signature, $res);
        openssl_free_key($res);
        return base64_encode($signature);
    }

    //*********************签名验证，供notify使用**********
    private function notifySignCheck($result, $pubKey)
    {
        $sign = $result['sign'];
        $sign = base64_decode($sign);
        unset($result['sign']);
        $string = makeString($result);
        //获取付啦的公钥信息
        $res = openssl_pkey_get_public($pubKey);
        //用公钥验证签名
        $check = openssl_verify($string, $sign, $res);
        openssl_free_key($res);
        return $check;
    }

    //**********************xml与array格式转换**********
    private function xml2array($xml)
    {
        $data = (array) simplexml_load_string($xml, 'SimpleXMLElement', LIBXML_NOCDATA);
        return array_change_key_case($data, CASE_LOWER);
    }

    /**
     * 将数组转换成XML string
     *
     * @param  array  $array
     *
     * @return  xml
     */
    private function array2xml($array = [])
    {
        if (!is_array($array) || count($array) <= 0) {
            Log::error("array2xml --> 数组数据异常！");
        }
        $xml = "<xml>";
        foreach ($array as $key => $val) {
            // $xml .= "<" . $key . ">" . $val . "</" . $key . ">";
            if (is_numeric($val)) {
                $xml .= "<" . $key . ">" . $val . "</" . $key . ">";
            } else {
                $xml .= "<" . $key . "><![CDATA[" . $val . "]]></" . $key . ">";
            }
        }
        $xml .= "</xml>";
        $xml = '<?xml version="1.0" encoding="UTF-8"?>' . $xml;
        return $xml;
    }
}
