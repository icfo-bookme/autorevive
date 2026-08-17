<?php

namespace App\Http\Helpers;

class UtilityHelper
{
    //image_resize function
    public static function image_resize($target, $image, $w, $h, $ext)
    {
        //ini_set('memory_limit', '-1');
        list($w_orginal, $h_orginal) = getimagesize($target);
        $scale_ratio = $w_orginal / $h_orginal;
        if ($ext == 'png' || $ext == 'PNG') {
            $img = imagecreatefrompng($target);
        } else if ($ext == 'jpeg' || $ext == 'JPEG') {
            $img = imagecreatefromjpeg($target);
        } else if ($ext == 'gif' || $ext == 'GIF') {
            $img = imagecreatefromgif($target);
        } else {
            $img = imagecreatefromjpeg($target);
        }

        if ($w/$h > $scale_ratio) {
            $w = $h*$scale_ratio;
        } else {
            $h = $w/$scale_ratio;
        }

        $tci = imagecreatetruecolor($w, $h);
        //Below two lines are used for making image background transparent
        $white = imagecolorallocate($tci, 255, 255, 255);
        imagefill($tci, 0, 0, $white);
        imagecopyresampled($tci, $img, 0, 0, 0, 0, $w, $h, $w_orginal, $h_orginal);
        if ($ext == 'gif' || $ext == 'GIF') {
            header('Content-Type: image/gif');
            imagegif($tci, $image, 80);
        } else {
            imagejpeg($tci, $image, 80);
        }

        chmod($image, 0777);
        return true;
    }

    public static function getImageDetails($image)
    {
        $imageWithExtension = explode('/', $image)[1];
        $explodedImage = explode('.', $imageWithExtension);
        $image = $explodedImage[0];
        $extension = $explodedImage[1];

        return [
            'imageWithExtension' => $imageWithExtension,
            'image' => $image,
            'extension' => $extension
        ];
    }

    public static function getResizeFilePath($image, $extension)
    {
        return $resize_file = 'itemImage/'.$image.'_small.'.$extension;
    }


//    public static function personalizeReplace($message=null,$firstName=null, $lastName=null, $email=null, $number=null,$orderId=null)
//    {
//        $message = str_replace('[[order_id]]', $orderId ? $orderId : '', $message);
//        $message = str_replace('[[first_name]]', $firstName ? $firstName : '', $message);
//        $message = str_replace('[[last_name]]', $lastName ? $lastName : '', $message);
//        $message = str_replace('[[phone]]', $number ? $number : '', $message);
//        $message = str_replace('[[email]]', $email ? $email : '', $message);
//        $message = str_replace('[[e_invoice]]', $orderId ? env('APP_URL').'/e-Invoice/'.$orderId : '', $message);
//        return $message;
//    }

    public static function personalizeReplace($message, $orderInfo = null, $orderId = null)
    {
        $message = str_replace('[[order_id]]', $orderId ? $orderId : '', $message);
        $message = str_replace('[[first_name]]', isset($orderInfo['first_name']) ? $orderInfo['first_name'] : '', $message);
        $message = str_replace('[[last_name]]', isset($orderInfo['last_name']) ? $orderInfo['last_name'] : '', $message);
        $message = str_replace('[[phone]]', isset($orderInfo['phone_number']) ? $orderInfo['phone_number'] : '', $message);
        $message = str_replace('[[email]]', isset($orderInfo['email']) ? $orderInfo['email'] : '', $message);
        $message = str_replace('[[e_invoice]]', $orderId ? env('APP_URL').'/e-Invoice/'.$orderId : '', $message);
        return $message;
    }
}
