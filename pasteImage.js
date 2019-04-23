//检测粘贴，得到图片后将图片的Base64编码上传到后端的函数
document.getElementById('ImagePaste').addEventListener('paste',function(e){

    if (e.clipboardData && e.clipboardData.items[0].type.indexOf('image') > -1)
    {
        var reader = new FileReader(), file = e.clipboardData.items[0].getAsFile();

        reader.onload = function( e )
        {
            var imageBase64 = e.target.result;

            document.getElementById('PasteImage').src=imageBase64;

            //将图片的Base64编码传送到后端进行ocr请求
            var xmlhttp;
            //为了解决浏览器兼容问题
            if (window.XMLHttpRequest)
                xmlhttp=new XMLHttpRequest();
            else
                xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");

            xmlhttp.onreadystatechange=function()
            {
                if (xmlhttp.readyState==4 && xmlhttp.status==200)
                {
                    var ocr_result=xmlhttp.responseText;
                    //将文字识别结果显示到textarea中
                    document.getElementById('OCRResult').innerText=ocr_result;
                }
            }

            xmlhttp.open("POST","get_ocr_result.php",true);
            xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
            xmlhttp.send("image="+imageBase64);

            document.getElementById("CopyButton").removeAttribute("disabled");
        };

        reader.readAsDataURL(file);
    }

});


//一键复制识别结果的函数
function CopyContent()
{
    var OCRResult = document.getElementById('OCRResult');
    OCRResult.select();
    document.execCommand("copy");
}