<?php

/**
 * 本站图片业务处理类
 * @author Bear
 * @version 1.0.0
 * @copyright http://maimengmei.com
 * @created 2015-10-14 11:37
 */
class Share_Img
{
    const W_JOIN_H = 'x';
    
    /**
     * 处理图片出错信息
     * @var string
     */
    private $_error;
    
    /**
     * 超过宽度裁剪位置
     * @var array
     */
    private static $_widthPlace = array('c'=>'center', 'w'=>'west', 'e'=>'east');
    
    /**
     * 超过高度裁剪位置
     * @var array
     */
    private static $_heightPlace = array('c'=>'center', 'n'=>'north', 's'=>'south');
    
    /**
     * 保存源图片（用gd库）
     * @param string $originImg 源图片完整路径（完整的绝对路径）
     * @param string $module 图片所属:大模块_小模块；如：用户模块下的用户头像：user_pic
     * @return string | boolean 成功保存，返回源图片存储的相对路径，失败返回false，可掉用getError()方法获取错误信息
     */
    public function saveOriginByGd($originImg, $module) {
        $image = new Common_Image();
        $image->read($originImg);
        $image->thumbnail();
        $fileName = $this->random(8) . date('ymdHis');
        $module = trim($module, '/');
        $filePath = '/' . $module . '/' . date('y') . '_' . date('m') . '_' . date('d') . '/origin/' . $fileName . '.' . $image->getSourceType();
        $targetPath = IMG_PATH . $filePath;
        $boolean = $image->write($targetPath);
        if ($boolean) {
            return $filePath;
        } else {
            $this->_error = $image->getError();
            return false;
        }
    }
    
    /**
     * 缩放图片（用gd库）
     * @param string $originImg 源图片完整路径（完整的绝对路径）
     * @param string $module 图片所属:大模块_小模块；如：用户模块下的用户头像：user_pic
     * @param integer $width 目标图片的宽
     * @param integer $height 目标图片的高 （如果tooWideCutPosition和tooHightCutPosition都为null时不进行缩放后裁剪）
     * @param string $tooWideCutPosition 超过是否进行裁剪，如果宽超过 ； c：居中裁剪，w：居左裁剪，e：居右裁剪
     * @param string $tooHighCutPosition 超过是否进行裁剪，如果高超过 ； c：居中裁剪，n：居上裁剪； s：居下裁剪 
     * @return string | boolean 成功保存，返回缩略图片存储的相对路径，失败返回false，可掉用getError()方法获取错误信息
     */
    public function scaleByGd($originImg, $module, $width, $height, $tooWideCutPosition = null, $tooHighCutPosition = null) {
        $image = new Common_Image($originImg);
        $module = trim($module, '/');
        $fileName = $this->random(8) . date('ymdHis');
        $moduleDate = '/' . $module . '/' . date('y') . '_' . date('m') . '_' . date('d') . '/';
        $filePath = $moduleDate . $fileName . '.' . $image->getSourceType();
        
        if (empty($tooWideCutPosition) && empty($tooHighCutPosition)) { // 只是等比例缩放，不进行任何裁剪
            $image->thumbnail($width, $height);
            $targetPath = $moduleDate . $fileName . '_' . $width . self::W_JOIN_H . $height . '.' . $image->getSourceType();
        } else { // 等比例缩放后进行裁剪
            $widthCut = 'c';
            $heightCut = 'c';
            if (array_key_exists($tooWideCutPosition, self::$_widthPlace)) {
                $widthCut = $tooWideCutPosition;
            }
            if (array_key_exists($tooHighCutPosition, self::$_heightPlace)) {
                $heightCut = $tooHighCutPosition;
            }
            $image->resize($width, $height, self::$_widthPlace[$widthCut], self::$_heightPlace[$heightCut]);
            $targetPath = $moduleDate . $fileName . '_' . $width . self::W_JOIN_H . $height . '_' 
                . $widthCut . '_' . $heightCut . '.' . $image->getSourceType();
        }
        $targetPath = IMG_PATH . $targetPath;
        $boolean = $image->write($targetPath);
        if ($boolean) {
            return $filePath;
        } else {
            $this->_error = $image->getError();
            return false;
        }
    }
    
    /**
     * 格式化图片路径（拼接成图片能用是url地址， 如：http://img.mvc.com/user_pic/15_10_15/fBjmVpy4151015101330_100x100_w_s.jpeg）
     * @param string $filePath 数据库中保存的图片路径，如：/user_pic/15_10_15/fBjmVpy4151015101330.jpeg
     * @param integer $width 目标图片的宽
     * @param integer $height 目标图片的高
     * @param string $tooWideCutPosition 如果宽超过是否进行裁剪 ； c：居中裁剪，w：居左裁剪，e：居右裁剪
     * （如果不传$tooWideCutPosition和$tooHighCutPosition参数代表仅缩放，不缩放后裁剪）
     * @param string $tooHighCutPosition 如果高超过是否进行裁剪 ； c：居中裁剪，n：居上裁剪； s：居下裁剪
     * @return string 返回图片的url地址；如：http://img.mvc.com/user_pic/15_10_15/fBjmVpy4151015101330.jpeg
     */
    public static function formatImgPath($filePath, $width = null, $height = null, $tooWideCutPosition = null, $tooHighCutPosition = null) {
        if (empty($width) && empty($height)) {
            return IMG_URL . $filePath;
        }
        $fileName = pathinfo($filePath, PATHINFO_FILENAME); // 文件名，不包括后缀
        $extension = pathinfo($filePath, PATHINFO_EXTENSION); // 后缀，不包括点
        $dirname = pathinfo($filePath, PATHINFO_DIRNAME); // 文件目录，不包括斜杠/
        if (empty($tooWideCutPosition) && empty($tooHighCutPosition)) {
            return IMG_URL . $dirname . '/' . $fileName . '_' . $width . self::W_JOIN_H . $height . '.' . $extension;
        } else {
            $widthCut = 'c';
            $heightCut = 'c';
            if (array_key_exists($tooWideCutPosition, self::$_widthPlace)) {
                $widthCut = $tooWideCutPosition;
            }
            if (array_key_exists($tooHighCutPosition, self::$_heightPlace)) {
                $heightCut = $tooHighCutPosition;
            }
            return IMG_URL . $dirname . '/' . $fileName . '_' . $width . self::W_JOIN_H . $height . '_' 
                . $widthCut . '_' . $heightCut . '.' . $extension;
        }
    }
    
    /**
     * 根据模块，保存缩略图（使用imagick）
     * @param string $originImg 源图片完整路径（完整的绝对路径）
     * @param string $module 图片所属:大模块_小模块；如：用户模块下的用户头像：user_pic
     * @return string 返回保存入数据库的图片路径，不包括格式化图片路径；如：
     */
    public function save($originImg, $module) {
        $module = trim($module, '/');
        // 通过读取配置文件，查看对应的模块生成多个缩略图
        $moduleConfig = BConfig::getImgThumbnail($module);
		if (empty($moduleConfig)) {
		    $this->_error = '不存在此模块的缩略图配置或配置为空';
		    return false;
		}
        // 最先保存原图，返回保存入数据库的图片路径
		$imagick = new Common_Imagick($originImg);
		$imagick->thumbnail();
        $fileName = $this->random(8) . date('ymdHis');
        $moduleDate = '/' . $module . '/' . date('y') . '_' . date('m') . '_' . date('d') . '/';
        $filePath = $moduleDate . $fileName . '.' . $imagick->getSourceType();
        $originPath = IMG_PATH . $moduleDate . 'origin/' . $fileName . '.' . $imagick->getSourceType();
        $boolean = $imagick->write($originPath);
        if (!$boolean) {
            $this->_error = $imagick->getError();
            return false;
        }
        // 批量生成对应的缩略图
        foreach ($moduleConfig as $k=>$v) {
            $targetPath = '';
            $imagick->read($originPath);
            if (is_string($k)) { // 图片需要缩略后进行裁剪
                $k = str_replace('X', self::W_JOIN_H, $k);
                $widthAndHeight = explode(self::W_JOIN_H, $k);
                $widthCut = 'c';
                $heightCut = 'c';
                if (array_key_exists($v['tooWideCutPosition'], self::$_widthPlace)) {
                    $widthCut = $v['tooWideCutPosition'];
                }
                if (array_key_exists($v['tooHighCutPosition'], self::$_heightPlace)) {
                    $heightCut = $v['tooHighCutPosition'];
                }
                $imagick->resize($widthAndHeight[0], $widthAndHeight[1], self::$_widthPlace[$widthCut], self::$_heightPlace[$heightCut]);
                $targetPath = $moduleDate . $fileName . '_' . $widthAndHeight[0] . self::W_JOIN_H . $widthAndHeight[1] . '_'
                    . $widthCut . '_' . $heightCut . '.' . $imagick->getSourceType();
                
            } else { // 直接进行等比例缩放
                $width = null;
                $height = null;
                $v = str_replace('X', self::W_JOIN_H, $v);
                $widthAndHeight = explode(self::W_JOIN_H, $v);
                if (!empty($widthAndHeight[0])) {
                    $width = $widthAndHeight[0];
                }
                if (!empty($widthAndHeight[1])) {
                    $height = $widthAndHeight[1];
                }
                $imagick->thumbnail($width, $height);
                $targetPath = $moduleDate . $fileName . '_' . $width . self::W_JOIN_H . $height . '.' . $imagick->getSourceType();
            }
            $imagick->write(IMG_PATH . $targetPath);
        }
        return $filePath;
    }
    
    
    public function getError() {
        return $this->_error;
    }
    
    /**
     * 生成随机的字符串
     * @param integer $length 需要的字符串长度
     * @return string
     */
    private function random($length = 6) {
        $hash = '';
        $chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789abcdefghijklmnopqrstuvwxyz';
        mt_srand((double)microtime()*1000000); // 播下一个更好的随机数发生器种子
        //自 PHP 4.2.0 起，不再需要用 srand() 或 mt_srand() 给随机数发生器播种 ，因为现在是由系统自动完成的。
        $len = strlen($chars)-1;
        for ($i=0; $i<$length; $i++) {
            $hash .= $chars[mt_rand(0, $len)];
        }
        return $hash;
    }
}
