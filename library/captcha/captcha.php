<?php
    session_start();
    header("Content-Type:image/jpeg");

    // tao kich thuoc khung cho anh.
    $captcha= resizeImage("background.jpg");

    // tao cac mau co ban.
    $black= imagecolorallocate($captcha,0,0,0);
    $while= imagecolorallocate($captcha,255,255,255);
    $red= imagecolorallocate($captcha,255,0,0);

    // tao mang mau cho chu
    $color=array($black,$while);

    //  tao chuoi chu ngau nhien
    $string=md5(rand(0,9999));
    $text=substr($string,0,5);
    $_SESSION['captcha'] = $text;
    // tao mang font ngau nhien
    $font = array('./CURLZ___.TTF', "./NIRMALA.TTF", "./NIRMALAB.TTF", "./JOKERMAN.TTF");


    imagettftext($captcha,25,5,5,35,$color[array_rand($color)],$font[array_rand($font)],$text);

    imagejpeg($captcha);
    imagedestroy($captcha);

    // ham resize image
    function resizeImage($fileName)
    {
        list($width,$height) = getimagesize($fileName);

        $newWidth=$width * 0.23;
        $newHeight=$height * 0.12;

        // anh dich voi kich thuoc moi
        $thumb = imagecreatetruecolor($newWidth, $newHeight);

        // anh nguon
        $source =imagecreatefromjpeg($fileName);

        //copy anh nguon sang anh dich
        imagecopyresized($thumb,$source,0,0,0,0,$newWidth,$newHeight,$width,$height);

        return $thumb;
    }
?>
