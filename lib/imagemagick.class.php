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

    static function getPreviewName($name)
    {
        $brName = explode('/', $name);
        $filename = $brName[count($brName) - 1];
        $brFilename = explode('.', $filename);
        $newName = 'preview_' . $brFilename[0] . '_' . time() . '.' . $brFilename[1];
        $newName = clearName($newName);

        return $newName;
    }

    static function createText($options)
    {

        $font = $options['font'];
        $text = $options['text'];
        $size = $options['size'];
        $color1 = $options['colors']['color1'];
        $color2 = $options['colors']['color2'];
        $rotate = $options['rotate'];

        $imageName = md5($text . $color1 . $color2 . $font . $size . $rotate . time()) . '.png';
        $imagePath = TEXT_TOOL_TEXT_PATH . $imageName;
        $textPath = TEXT_TOOL_TEXT_PATH;
        $exec_str = "cd $textPath;" . TEXT_TOOL_TEXTEFFECT_PATH . " -t '$text' -r $rotate -f $font -b none -p $size -c '$color1'-'$color2' -A 0 '$imagePath' ";
        //print_r($exec_str);exit;
        exec($exec_str, $output, $ret);
        self::trim($imagePath);
        return $imageName;

    }

    static function addPlus($imageName)
    {
        $imagePath = TEXT_TOOL_TEXT_PATH . $imageName;
        self::addBorder($imagePath, "3x0");
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
        self::addBorder($imagePath, "3x0");
        self::glue2ImagesHor($starPath, $imagePath);
    }

    static function glue2ImagesHor($path1, $path2)
    {
        //$exec_str = "convert $path1 $path2 -transpose miff:- | montage - -geometry +3+3 -tile 1x2 miff:- | convert - -transpose $path2 2>&1";
        $exec_str = "convert $path1 $path2 +append $path2 2>&1";
        exec($exec_str, $output, $ret);
    }

    static function disableTr($path)
    {
        $exec_str = "convert -flatten $path $path 2>&1";
        exec($exec_str, $output, $ret);
        self::trim($path);
    }

    static function glue3ImagesVer($path1, $path2, $path3, $ret)
    {
        //$exec_str = "convert $path1 $path2 $path3 -transpose miff:- | montage - -geometry +2+2 -tile 3x1 miff:- | convert - -transpose $ret 2>&1";
        $exec_str = "convert $path1 $path2 $path3 -append $ret 2>&1";
        exec($exec_str, $output, $ret);
        unlink($path1);
        unlink($path2);
        unlink($path3);
    }

    static function glue5ImagesVer($path1, $path2, $path3, $path4, $path5, $ret)
    {
        //$exec_str = "convert $path1 $path2 $path3 -transpose miff:- | montage - -geometry +2+2 -tile 3x1 miff:- | convert - -transpose $ret 2>&1";
        $exec_str = "convert $path1 $path2 $path3 $path4 $path5 -append $ret 2>&1";
        exec($exec_str, $output, $ret);
        unlink($path1);
        unlink($path2);
        unlink($path3);
        unlink($path4);
        unlink($path5);
    }

    static function trim($path)
    {
        $exec_str = "convert $path -trim $path";
        exec($exec_str, $output, $ret);
    }

    static function mergeImages($mainPath, $imagePath, $targetPath, $position)
    {

        $mainPath = explode('?', $mainPath);
        $mainPath = $mainPath[0];

        $imagePath = explode('?', $imagePath);
        $imagePath = $imagePath[0];

        $targetPath = explode('?', $targetPath);
        $targetPath = $targetPath[0];

        $geometry = "+" . round($position['left']) . "+" . round($position['top']);

        $exec_str = "convert '$mainPath' '$imagePath'  -geometry $geometry -composite '$targetPath' 2>&1";
        //print($exec_str);exit;
        exec($exec_str, $output, $ret);
        //print_r($output);exit;
    }


    static function addBubble($imageName, $options)
    {
        $imagePath = TEXT_TOOL_TEXT_PATH . $imageName;
        $bubbleId = $options['id'];
        $bubbleSide = $options['side'];
        $bubbleColor = isset($options['color']) && $options['color'] ? $options['color'] : "#000000";
        $opac = isset($options['opac']) ? $options['opac'] : 0;

        $bubbleName = $bubbleSide . '_b' . $bubbleId . '.png';
        $bubblePath = BUBBLES_PATH . $bubbleName;

        $imageSize = getimagesize($imagePath);

        $bubbleSize = explode('x', INIT_BUBBLE_SIZE);
        $innerSize = explode('x', INIT_BUBBLE_INNER_SIZE);
        $offset = explode('x', INIT_BUBBLE_OFFSET);

        $ratio = array($innerSize[0] / $imageSize[0], $innerSize[1] / $imageSize[1]);
        $newBubbleSize = array($bubbleSize[0] / $ratio[0], $bubbleSize[1] / $ratio[1]);
        $newOffset = array($offset[0] / $ratio[0], $offset[1] / $ratio[1]);

        $resizedBubblePath = TEXT_TOOL_TMP_PATH . time() . '_' . $bubbleName;

        self::resizeBig($bubblePath, $resizedBubblePath, implode('x', $newBubbleSize));

        $colorPath = TEXT_TOOL_TMP_PATH . time() . '_' . $bubbleColor . '_' . $bubbleName;
        self::getGradient($bubbleColor, $colorPath);
        self::getColoredBubble($colorPath, $resizedBubblePath, $resizedBubblePath, $opac);

        self::mergeImages($resizedBubblePath, $imagePath, $imagePath, array('left' => $newOffset[0], 'top' => $newOffset[1]));

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

    static function getGradient($color1, $filepath, $color2 = "#FFFFFF", $size = "10x100")
    {
        $str = "convert  -quality 100% -size $size  gradient:'" . $color1 . "'-'" . $color2 . "' $filepath";
        //print_r($str);
        exec($str, $out, $ret);
        if (!$ret) {
            return true;
        }
        return false;
    }

    static function getColoredBubble($colorPath, $arrowPath, $filePath, $opac)
    {

        $opacPar = self::getOpac($opac);

        $str = "convert -quality 100% $arrowPath $colorPath -clut $opacPar $filePath";
        //print_r($str);
        exec($str, $out, $ret);
        if (!$ret) {
            return true;
        }
        return false;
    }

    static function getOpac($level = 0)
    {
        $level = (int)$level;
        if ($level <= 0) $level = 0;
        if (100 < $level) $level = 100;

        $level = $level / 100;

        $opacity_par = " -alpha Set -fill none -channel Alpha -fx  'u * $level' ";

        return $opacity_par;
    }

    static function addBorder($path, $width)
    {
        $exec_str = "convert $path -bordercolor white -border $width $path 2>&1";
        exec($exec_str, $output, $ret);
    }


}

?>