<?php
session_start();

if (isset($_POST["image"])){
    $image=$_POST["image"];
    //一定要去掉Base64编码的头部部分，由于截屏图片都是png格式，所以直接去掉png的头部
    $image=str_replace("data:image/png;base64,","",$_POST["image"]);
    //AJAX传送的值会将‘+’转换成空格，在进行文字识别之前一定要将空格转回‘+’
    $image=str_replace(" ","+",$image);

    $access_token=$_SESSION["access_token"];

    $url = 'https://aip.baidubce.com/rest/2.0/ocr/v1/general_basic';

    $post_data['access_token'] = $access_token;
    $post_data['image'] = $image;
    $post_data['detect_direction'] = 'true';

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
    $ocr_result = curl_exec($curl);   //运行curl
    curl_close($curl);

    $ocr_json=json_decode($ocr_result,true);

    $result="";

    //将返回结果拼合成一个字符串
    foreach ($ocr_json["words_result"] as $word){
        $result=$result.$word["words"];
    }

    echo $result;
}