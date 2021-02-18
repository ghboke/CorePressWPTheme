<?php
session_start();
$image = imagecreatetruecolor(100, 30);//imagecreatetruecolor函数建一个真彩色图像
//生成彩色像素
$bgcolor = imagecolorallocate($image, 255, 255, 255);//白色背景     imagecolorallocate函数为一幅图像分配颜色
$textcolor = imagecolorallocate($image, 0, 0, 255);//蓝色文本
//填充函数，xy确定坐标，color颜色执行区域填充颜色
imagefill($image, 0, 0, $bgcolor);
$captch_code = "";//初始空值
//该循环,循环取数
for ($i = 0; $i < 4; $i++) {
    $fontsize = 8;
    $x = ($i * 25) + rand(5, 10);
    $y = rand(5, 10);//位置随机
    $data = strtoupper('abcdefghijkmnpqrstuvwxyz3456789');
    $fontcontent = substr($data, rand(0, strlen($data) - 1), 1);//strlen仅仅是一个计数器的工作  含数字和字母的验证码
    //可以理解为数组长度0到30

    $fontcolor = imagecolorallocate($image, rand(0, 100), rand(0, 100), rand(0, 100));//随机的rgb()值可以自己定

    imagestring($image, $fontsize, $x, $y, $fontcontent, $fontcolor); //水平地画一行字符串
    $captch_code .= $fontcontent;
}
$_SESSION['authcode'] = $captch_code;//将变量保存再session的authcode变量中
//该循环,循环画背景干扰的点
/*for($m=0;$m<=600;$m++){

    $x2=rand(1,99);
    $y2=rand(1,99);
    $pointcolor=imagecolorallocate($image,rand(0,255),rand(0,255),rand(0,255));
    imagesetpixel($image,$x2,$y2,$pointcolor);// 水平地画一串像素点
}*/

//该循环,循环画干扰直线
/*for ($i=0;$i<=10;$i++){
    $x1=rand(0,99);
    $y1=rand(0,99);
    $x2=rand(0,99);
    $y2=rand(0,99);
    $linecolor=imagecolorallocate($image,rand(0,255),rand(0,255),rand(0,255));
    imageline($image,$x1,$y1,$x2,$y2,$linecolor);//画一条线段

}*/
header('content-type:image/png');
imagepng($image);
//销毁
imagedestroy($image);
?>