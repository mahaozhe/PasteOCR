<?php
session_start();

function getAccessToken(){
    // 由于access_token是定期更新的，但同时为了不每次请求OCR接口都请求一次access_token
    // 所以在界面加载后先请求一次access_token并将其保存在session中
    // 这段代码是对百度OCR示例的一些修改
    if (!isset($_SESSION["access_token"]) || $_SESSION["access_token"]=="")
    {
        $url = 'https://aip.baidubce.com/oauth/2.0/token';

        $post_data['grant_type'] = 'client_credentials';
        $post_data['client_id'] = '你的 Api Key';   //这里是你的API Key
        $post_data['client_secret'] = '你的 Secret Key';    //这里是你的Secret Key
        $o = "";
        foreach ($post_data as $k => $v) {
            $o .= "$k=" . urlencode($v) . "&";
        }
        $post_data = substr($o, 0, -1);

        $curl = curl_init();    //初始化curl
        curl_setopt($curl, CURLOPT_URL, $url);   //抓取指定网页
        curl_setopt($curl, CURLOPT_HEADER, 0);  //设置header
        curl_setopt($curl, CURLOPT_POST, 1);    //post提交方式
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);  //设置返回结果不打印到页面
        curl_setopt($curl, CURLOPT_POSTFIELDS, $post_data);  //设置传递参数
        $access_token_result = curl_exec($curl);   //运行curl
        curl_close($curl);

        $access_token_json=json_decode($access_token_result,true);
        $access_token=$access_token_json["access_token"];
        $_SESSION["access_token"]=$access_token;
    }
}