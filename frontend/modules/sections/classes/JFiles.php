<?php

namespace frontend\modules\sections\classes;

class JFiles {

    public static function getTypeFile() {
        $type = \common\models\FileType::find()->all();
        if ($type) {
            return $type;
        }
    }

    /* function:  generates thumbnail */

    public static function make_thumb($src, $dest, $desired_width) {
        /* read the source image */
        $source_image = imagecreatefromjpeg($src);
        $width = imagesx($source_image);
        $height = imagesy($source_image);
        /* find the "desired height" of this thumbnail, relative to the desired width  */
        $desired_height = floor($height * ($desired_width / $width));
        /* create a new, "virtual" image */
        $virtual_image = imagecreatetruecolor($desired_width, $desired_height);
        /* copy source image at a resized size */
        imagecopyresized($virtual_image, $source_image, 0, 0, 0, 0, $desired_width, $desired_height, $width, $height);
        /* create the physical thumbnail image to its destination */
        imagejpeg($virtual_image, $dest);
    }

    /* function:  returns files from dir */

    public static function get_files($images_dir, $exts = array('jpg')) {
        $files = array();
        if ($handle = opendir($images_dir)) {
            while (false !== ($file = readdir($handle))) {
                $extension = strtolower(self::get_file_extension($file));
                if ($extension && in_array($extension, $exts)) {
                    $files[] = $file;
                }
            }
            closedir($handle);
        }
        return $files;
    }

    /* function:  returns a file's extension */

    public static function get_file_extension($file_name) {
        return substr(strrchr($file_name, '.'), 1);
    }

}
