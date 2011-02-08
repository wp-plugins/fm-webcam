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

    if ($size > 1) { 

     $colBlack = imageColorClosest($img_des, 0,0,0);
     $colWhite = imageColorClosest($img_des, 255,255,255);

     $uhrzeit = date("d").".".date("m").".".date("Y")." ".date("H").":".date("i"); 

     if ($size < 250) {
         $F_fsize   = 40;
         $F_offset  = 1;
         $F_xversatz = 32;

     } else {
         $F_fsize   = 70;
         $F_offset  = 2;
         $F_xversatz = 52;      
     }

/*
     imagefilledrectangle($img_des, $width-155, 8, $width, 21, $colBlack);

     $currpath = getcwd()."/";
     imagettftext($img_des, 10, 0, $width-150, 20, $colWhite, $currpath."fonts/arialbd.ttf", $uhrzeit);
     imagettftext ($img_des, $F_fsize, 0, $width-$F_xversatz-$F_offset, $F_fsize+5-$F_offset, $colBlack, $currpath."fonts/frozen.ttf", "F");
     imagettftext ($img_des, $F_fsize, 0, $width-$F_xversatz-$F_offset, $F_fsize+5+$F_offset, $colBlack, $currpath."fonts/frozen.ttf", "F");
     imagettftext ($img_des, $F_fsize, 0, $width-$F_xversatz+$F_offset, $F_fsize+5-$F_offset, $colBlack, $currpath."fonts/frozen.ttf", "F");
     imagettftext ($img_des, $F_fsize, 0, $width-$F_xversatz+$F_offset, $F_fsize+5+$F_offset, $colBlack, $currpath."fonts/frozen.ttf", "F");
     imagettftext ($img_des, $F_fsize, 0, $width-$F_xversatz,           $F_fsize+5-$F_offset, $colBlack, $currpath."fonts/frozen.ttf", "F");
     imagettftext ($img_des, $F_fsize, 0, $width-$F_xversatz,           $F_fsize+5+$F_offset, $colBlack, $currpath."fonts/frozen.ttf", "F");
     imagettftext ($img_des, $F_fsize, 0, $width-$F_xversatz-$F_offset, $F_fsize+5,           $colBlack, $currpath."fonts/frozen.ttf", "F");
     imagettftext ($img_des, $F_fsize, 0, $width-$F_xversatz+$F_offset, $F_fsize+5,           $colBlack, $currpath."fonts/frozen.ttf", "F");
     imagettftext ($img_des, $F_fsize, 0, $width-$F_xversatz,           $F_fsize+5,           $colWhite, $currpath."fonts/frozen.ttf", "F");        
    
     if ($size > 250) {
              imagefilledrectangle($img_des, 0, $height-22, $width, $height-8, $colBlack);
              imagettftext($img_des, 10, 0, 10, $height-10, $colWhite, $currpath."fonts/arialbd.ttf", $bildname);
              imagettftext($img_des, 10, 0, $width-120, $height-10, $colWhite, $currpath."fonts/arial.ttf", "www.frozen-radio.de");
     }
*/

    }
    return $img_des;
}
?>