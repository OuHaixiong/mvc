<?php
header('Access-Control-Allow-Origin: http://res.mvc.com');
//设置http://www.baidu.com允许跨域访问，这里是写post上来图片的来源域名；多个域名之间用逗号分隔
// header('Access-Control-Allow-Origin: *'); // 允许任意域名发起的跨域请求
header('Access-Control-Allow-Headers: X-Requested-With,X_Requested_With'); // 设置允许的跨域header
//Access-Control-Allow-Headers: Content-Type, Authorization, Accept, Range, Origin
// 解决上传图片跨域问题，上两句对单图上传没有影响。解决火狐谷歌跨域上传图片问题
// header('Access-Control-Request-Method: GET, POST');
/**
 * 百度的Ueditor练习
 * @author Bear
 * @copyright http://maimengmei.com
 * @version 1.0.0
 * @created 2015-6-15
 */
class C_Ueditor extends BController
{
    /**
     * 初始化控制器（复写父类方法）
     * @see BController::init()
     */
    public function init() {
        parent::init();
    }
    
    /**
     * 编辑器上传图片
     */
    public function upload() {
        if ((!empty($_FILES)) && isset($_FILES['Filedata'])) {
            //var_dump($_FILES['Filedata']);
            $img = new Common_Image();
            $img->read($_FILES['Filedata']['tmp_name']);
            $fileName = $img->getFileName() . '.' . $img->getSourceType();
            $filePath = '/upload/image/' . date('Ym') . '/' . $fileName;
            $targetPath = ROOT_PATH . $filePath;
            $boolean = $img->write($targetPath);
            if ($boolean) {
                echo '上传成功;图片：'. STATIC_URL . $filePath;
            } else {
                var_dump($img->getError());
            }
        } else {
            
        }
    }
    
    /**
     * 编辑器上传上来的参数
     */
    public function post() {
        Common_Tool::prePrint($this->getParams(), false);
        Common_Tool::prePrint($_POST);
    }
    
    public function ueditor1_4_3() {
        $this->_view->setIsLayout();
        $this->render();
    }

}
