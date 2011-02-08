<?
$picture_location=$_GET["pic"];
$size = $_GET["size"];
$bildname = "";


$img_des=resize_img($picture_location,$size,$bildname);
imagejpeg($img_des);


/* FUNTIONS ##################################################################################### */

function resize_img($imgname,$size,$bildname)
{
    Header("Content-Type: image/jpeg");
    $img_src = ImageCreateFromjpeg ($imgname);

    $true_width = imagesx($img_src);
    $true_height = imagesy($img_src);


    $width=$size;
    $height = ($width/$true_width)*$true_height;

    $img_des = imagecreatetruecolor($width,$height);

    imagecopyresized ($img_des, $img_src, 0, 0, 0, 0, $width, $height, $true_width, $true_height);


    return $img_des;
}
?>