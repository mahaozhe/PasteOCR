<?php
include "get_access_token.php";
getAccessToken();
?>

<!DOCTYPE html>
<html lang="zh-cn">

<head>
    <meta charset="utf-8">
    <title>Paste OCR</title>
</head>

<body>
    <h1>获取截图的文字识别结果</h1>
    <input type="text" autofocus id="ImagePaste" placeholder="截屏后直接将图片粘贴到此输入框中"/><br>
    <img id="PasteImage" src=""><br>
    <label for="OCRResult">识别结果</label>
    <textarea id="OCRResult" ows="3"></textarea><br>
    <button disabled id="CopyButton" onclick="CopyContent()" type="button">复制内容</button>

    <script src="pasteImage.js"></script>
</body>
</html>