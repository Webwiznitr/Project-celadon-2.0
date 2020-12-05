
<?php
session_start();
echo isset($_FILES['file']['name']);
if (isset($_POST['name']) && isset($_POST['event']) && isset($_POST['date']) &&isset($_POST['template'])) {
    // echo 'yes';
    $font_1 = realpath('../Sanchez.otf');
    $font_2 = realpath('../constantia.ttf');
    $font_3 = realpath('../Gabriola.ttf');
    $template = $_POST['template'];
    $image = imagecreatefromjpeg("../template/".$template);
    $color_1 = imagecolorallocate($image, 51, 213, 172);
    $color_2 = imagecolorallocate($image, 0, 51, 102);
    $color_3 = imagecolorallocate($image, 102, 0, 51);
    $srcImage = $_POST['sign'];
    //signature resizing
    $signature=imagecreatefromjpeg("../uploads/".$srcImage);  
    $width = imagesx($signature);  
    $height = imagesy($signature);
    $targetHeight = 80;
    $targetWidth = 200;
    $targetImage = imagecreatetruecolor($targetWidth, $targetHeight);
    imagecopyresampled($targetImage, $signature, 0, 0, 0, 0, $targetWidth, $targetHeight, $width, $height);
    $size = getimagesize("../template/".$template);  
    //position in template to place sign
    $dest_x =round($size[0]) - 300;
    $dest_y =round($size[1]) - 250;
    imagettftext($image, 48, 0, 350, 325, $color_1, $font_1, $_POST['name']);
    imagettftext($image, 32, 0, 350, 450, $color_2, $font_2, $_POST['event']);
    imagettftext($image, 25, 0, 115, 640, $color_3, $font_3, $_POST['date']);
    //merge signature
    imagecopy($image, $targetImage, $dest_x , $dest_y, 0, 0, $targetWidth, $targetHeight);
    $file = $_POST['name']."_".$_POST['event']."_".$_POST['date'];
    imagejpeg($image, "../certificates/" . $file . ".jpg");
    imagedestroy($image);
    $_SESSION['certificate'] = "../certificates/" . $file . ".jpg";
    if(isset($_SESSION['certificate'])){
        echo(json_encode(array('status'=>'success','message' => $file)));
    }
}
 


?> 