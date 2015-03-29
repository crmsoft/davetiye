<?php namespace App\Models\ImgProcessing;

class Crop {

    /********************************************************************************************
     *  @param $file => $_FILES['input_name']['tmp_name']                                       *
     *  @param $filename => path to save new cropped img 'UI/img/thumbs/time().jpg|.png|.gif'   *
     *  @param $w => crop With                                                                  *
     *  @param $h => crop Height                                                                *
     *  @param $x => x coordinate of crop                                                       *
     *  @param $y => y coordinate of crop                                                       *
     *  @param $targ_w => thumb width                                                           *
     *  @param $targ_h => thumb height                                                          *
     *  @param $q => save quality def is 80%                                                    *
     *  @return true on image save success                                                      *
     ********************************************************************************************/

    public function crop_img( $file, $filename, $w, $h, $x, $y, $targ_w = 150, $targ_h = 168, $q = null ){

        $type = exif_imagetype($file); // gif, png, jpg

        switch( $type ){
            case 2 : $image = imagecreatefromjpeg( $file ); if( $q == null ) $q = 80; break;
            case 3 : $image = imagecreatefrompng( $file );  if( $q == null ) $q = 8; break;
            case 1 : $image = imagecreatefromgif( $file );  if( $q == null ) $q = 80; break;
            default : return false;
        }

        $thumb = imagecreatetruecolor( $targ_w, $targ_h );

        // Resize and crop
        imagecopyresampled($thumb, $image, 0, 0, $x, $y, $targ_w, $targ_h, $w, $h);

        switch( $type ){
            case 2 : imagejpeg($thumb, $filename, $q); break;
            case 3 : imagepng($thumb, $filename, $q); break;
            case 1 : imagegif($thumb, $filename, $q); break;
            default : return false;
        }
        return true;
    }

}
