<?php
class ImageMagick
{

    static function resize($image_path, $target_path, $size)
    {
        $exec_str = "convert '$image_path' -resize $size '$target_path' 2>&1";
        exec($exec_str, $output, $ret);
        return $ret;
    }

    static function resizeBig($image_path, $target_path, $size)
    {
        $exec_str = "convert '$image_path' -resize $size! '$target_path' 2>&1";
        //print_r($exec_str);
        exec($exec_str, $output, $ret);
        return $ret;
    }

    static function createText($options)
    {

        $font = $options['font'];
        $text = $options['text'];
        $size = $options['size'];
        $color = $options['color'];
        $rotate = $options['rotate'];

        $imageName = md5($text . $color . $font . $size . $rotate . time()) . '.png';
        $imagePath = TEXT_TOOL_TEXT_PATH . $imageName;
        $textPath = TEXT_TOOL_TEXT_PATH;
        $exec_str = "cd $textPath;" . TEXT_TOOL_TEXTEFFECT_PATH . " -t '$text' -r $rotate -f $font -b none -p $size -c '$color' -A 0 '$imagePath' ";
        //print_r($exec_str);exit;
        exec($exec_str, $output, $ret);
        self::trim($imagePath);
        return $imageName;

    }

    static function addPlus($imageName)
    {
        $imagePath = TEXT_TOOL_TEXT_PATH . $imageName;
        self::addBorder($imagePath, "5x0");
        $starPath = EBAY_IMAGES_PATH . "iconPos_16x16.gif";
        self::glue2ImagesHor($starPath, $imagePath);
    }

    static function addStar($imageName, $rate)
    {
        $imagePath = TEXT_TOOL_TEXT_PATH . $imageName;
        $star = 'iconYellowStar_25x25.gif';
        if ($rate > 49) {
            $star = 'iconBlueStar_25x25.gif';
        }
        if ($rate > 99) {
            $star = 'iconTealStar_25x25.gif';
        }
        if ($rate > 499) {
            $star = 'iconPurpleStar_25x25.gif';
        }
        if ($rate > 999) {
            $star = 'iconRedStar_25x25.gif';
        }
        if ($rate > 4999) {
            $star = 'iconGreenStar_25x25.gif';
        }

        $starPath = EBAY_IMAGES_PATH . $star;
        self::addBorder($imagePath, "5x0");
        self::glue2ImagesHor($starPath, $imagePath);
    }

    static function glue2ImagesHor($path1, $path2)
    {
        $exec_str = "convert -background white $path1 $path2 +append $path2 2>&1";
        exec($exec_str, $output, $ret);
    }

    static function disableTr($path)
    {
        $exec_str = "convert $path -background white -flatten  $path 2>&1";
        exec($exec_str, $output, $ret);
        self::trim($path);
    }

    static function glueImagesVer($paths, $ret)
    {
        $images = implode(' ', $paths);
        //$exec_str = "convert $path1 $path2 $path3 -transpose miff:- | montage - -geometry +2+2 -tile 3x1 miff:- | convert - -transpose $ret 2>&1";
        $exec_str = "convert -background white $images -append $ret 2>&1";
        exec($exec_str, $output, $ret);
        foreach ($paths as $path) {
            @unlink($path);
        }
    }

    static function trim($path)
    {
        $exec_str = "convert $path -trim $path";
        exec($exec_str, $output, $ret);
    }

    static function deleteOldFiles($path = TEXT_TOOL_TMP_PATH)
    {
        $files = scandir($path);

        foreach ($files as $file) {
            if (is_file($path . $file) && filemtime($path . $file) < time() - 1000) {
                unlink($path . $file);
            }
        }
    }


    static function addBorder($path, $width)
    {
        $exec_str = "convert $path -bordercolor white -border $width $path 2>&1";
        exec($exec_str, $output, $ret);
    }


}

?>