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
    /**
     * 处理图片出错信息
     * @var string
     */
    private $_error;
    
    const ABC = array('n'=>'no', 'y'=>'yes');
    
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
     * @param string $tooHighCutPosition 超过是否进行裁剪，如果宽超过 ； c：居中裁剪，n：居上裁剪； s：居下裁剪 
     * @return string | boolean 成功保存，返回缩略图片存储的相对路径，失败返回false，可掉用getError()方法获取错误信息
     */
    public function scaleByGd($originImg, $module, $width, $height, $tooWideCutPosition = null, $tooHighCutPosition = null) {
        $image = new Common_Image($originImg);
        if (empty($tooWideCutPosition) && empty($tooHighCutPosition)) { // 只是等比例缩放，不进行任何裁剪
            $image->thumbnail($width, $height);
            $fileName = $this->random(8) . date('ymdHis');
            $module = trim($module, '/');
            $filePath = '/' . $module . '/' . date('y') . '_' . date('m') . '_' . date('d') . '/' . $fileName . '.' . $image->getSourceType();
            $targetPath = $filePath;
        } else { // 等比例缩放后进行裁剪
            
            $image->resize($width, $height);
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
    
    public function save() {
        
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
