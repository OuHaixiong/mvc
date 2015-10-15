<?php

/**
 * 对图片的操作
 * @author Bear
 * @version 2.0.0
 * @copyright xiqiyanyan.com
 * @created 2012-12-21 19:35
 */
class C_Image extends BController
{
	public function init() {
		$this->_view->setIsView();
		$this->_view->setIsLayout();
	}
	
	/**
	 * ImageMagick 原生态调用 ( ImageMagick操作 )
	 */
	public function imageMagick() {
		$this->_view->title = '测试原生态的ImageMagick';
		
		Lib_Tool::executeStartTime();
		
		
		// 非图片文件，抛出异常
		/* $path = ROOT_PATH . '/img/bb';
		try {
			$imageMagick = new Imagick($path); // 如果不是图片文件，直接发生错误
		} catch (Exception $e) {
			if ($e->getCode() == 1) {
				var_dump('不是图片文件');
			}
			var_dump($e->getMessage());
			var_dump($e->getTrace());
		} */
		

        // 分解gif
        /* $im = new Imagick(ROOT_PATH . '/img/gif.gif');
		$i = 0;
		foreach ($im as $image) {
			$image->writeImage(ROOT_PATH . '/img/font/' . $i . '.gif');
			$i++;
		} */
		
        
        // 生成缩略图
        /* $imagick = new Imagick();
		$filename = ROOT_PATH . '/img/jpg.jpg';
		$imagick->readimage($filename);
		$columns = 200;
		$rows = 200;
 		//$boolean = $imagick->thumbnailimage($columns, $rows); // 成功返回true； 失败返回false
		// 不能处理gif动画，处理gif很慢
		// 最后一个参数，默认null：将进行变形缩略，true：等比例缩略
		// 如果图片小于给定值，将进行拉伸
		$boolean = $imagick->thumbnailimage($columns, $rows, true);
		$targetPath = ROOT_PATH . '/img/abc.png';
		$boolean = $imagick->writeimage($targetPath);
		var_dump($boolean); */
		
		
        // 等比例放大图片,也可以等比例缩小图片. thumbnailimage 和 adaptiveResizeImage 一个意思
        // 如果作为缩略图的话，adaptiveResizeImage 没有 thumbnailimage 的效果好
        /* $sourcePath = ROOT_PATH . '/img/bmp.bmp';
        $destinationPath = ROOT_PATH . '/img/abc.png';
        $imagick = new Imagick($sourcePath);
        $width = 600;
        $height = 600;
        //$imagick->adaptiveResizeImage($width, null); // 如果源图片的宽和高都大于目标图片的宽和高，只传入了一个参数就是按一边来等比例缩略
        //$imagick->adaptiveResizeImage(null, $height); // 等比例拉伸图片
        //$imagick->adaptiveResizeImage($width, $height); // 变形拉伸图片
        $imagick->adaptiveresizeimage($width, $height, true); // 后面这个参数是设置是否等比例拉伸；true：等比例拉伸图片（按小比例拉伸，即拉伸最小算）； false：变形拉伸
        // 这个函数也可以用来缩略 TODO 这里按大比例还是小比例来缩率就不知道
        $boolean = $imagick->writeImage($destinationPath);
        var_dump($boolean); */
		
		
		// 原生态的， 裁剪图片 （不是很慢，不能生成动画，动画只能截取第一帧） (注意了：Imagick的cropimage也无法裁剪gif动画图片)
        /* $path = ROOT_PATH . '/img/gif.gif.jpeg';
        $width = 100;
        $height = 100;
        $x = 119;
        $y = 110;
        $imageMagick = new Imagick($path);
        $boolean = $imageMagick->cropImage($width, $height, $x, $y);
        $destinationPath = ROOT_PATH . '/img/abc.gif';
        $imageMagick->writeimages($destinationPath, true);
        var_dump($boolean); */
		
		
        // 原生态，压缩后裁剪
        /* $sourcePath = ROOT_PATH . '/img/gif.gif.jpeg';
        $destinationPath = ROOT_PATH . '/img/new.gif';
        $width = 200;
        $height = 200;
        $imageMagick = new Imagick();
        $imageMagick->readimage($sourcePath);
        $imageMagick->coalesceImages();
        $boolean = $imageMagick->cropthumbnailimage($width, $height);
        // 等比例缩放后进行裁剪，即会生成给定宽和高到图片，（后证实这个函数也不慢，可以用，只不过这里只能居中裁剪）
        $imageMagick->writeImages($destinationPath, true); // 如果是gif图片的话，后面为false时，会分解每一帧图片
        // cropthumbnailimage gif可以生成动画，但是不是想要的效果，有问题,不建议使用 */
        
        
        // 原生态，运动模糊
        /* $sourcePath = ROOT_PATH . '/img/png.png';
        $imageMagick = new Imagick($sourcePath);
        //$imageMagick->motionBlurImage(2.8, 2.5, 1.0); // 运动模糊
        $imageMagick->blurImage(2.5, 2.5); // blurImage（模糊）
        $targetPath = ROOT_PATH . '/img/abc.gif';
        $imageMagick->writeimage($targetPath);
        // 类似的函数还有：gaussianBlurImage（高斯模糊） radialBlurImage($radius);} // 径向模糊 */
        
        /* $imageMagick = new Imagick();
        $sourcePath = ROOT_PATH . '/img/jpg.jpg';
        $targetPath = ROOT_PATH . '/img/abc.jpg';
        $imageMagick->readimage($sourcePath);
        //$boolean = $imageMagick->oilPaintImage(1.0); // 油画效果
        //$boolean = $imageMagick->charcoalImage(1.0, 2.0); // 素描
        //$boolean = $imageMagick->addNoiseImage(Imagick::NOISE_IMPULSE); // 添加噪点
        //$boolean = $imageMagick->levelImage(0.5,5.5,7.5); // 调整色阶
        $boolean = $imageMagick->modulateImage(89,2.3,3.0); // 调整亮度、饱和度、色调
        $imageMagick->writeimage($targetPath); */




        
		
		
		
		
		//压缩比率和性能测试
		// 		$imagick = new Common_ImageMagick();
		// 		$sourcePath = ROOT_PATH . '/img/meinv.JPG';
		// 		$destinationPath = ROOT_PATH . '/img/mm01.jpg';
		// 		$width = 600;
		// 		$height = 680;
		// 		$isCrop = true;
		// 		$num = 10;
		// 		$quality = 88;
		
		//         Common_Tool::executeStartTime();
						//         for ($i=0; $i<$num; $i++) {
								//         	$boolean = $imagick->resize01($sourcePath, $destinationPath, $width, $height, $isCrop);
								//         }
								//         Zend_Debug::dump($boolean);
								//         Zend_Debug::dump(Common_Tool::executeEndTime()); // 1.632 11.75
		
								// 		$destinationPath = ROOT_PATH . '/img/new88.jpg';
								// 		Common_Tool::executeStartTime();
								// 		for ($i=0; $i<$num; $i++) {
								// 			$boolean = $imagick->resize02($sourcePath, $width, $height, $destinationPath, $isCrop, $quality);
										// 		}
										// 		Zend_Debug::dump($boolean);
										// 		Zend_Debug::dump(Common_Tool::executeEndTime()); // 0.894 8.72
		
												//         $destinationPath = ROOT_PATH . '/img/mm03.jpg';
												//         Common_Tool::executeStartTime();
												//         for ($i=0; $i<$num; $i++) {
												//         	$boolean = $imagick->resize03($sourcePath, $destinationPath, $width, $height, $isCrop);
												//         }
												//         Zend_Debug::dump($boolean);
												//         Zend_Debug::dump(Common_Tool::executeEndTime()); // 1.290 12.49
		
												//         $destinationPath = ROOT_PATH . '/img/mm04.jpg';
												//         Common_Tool::executeStartTime();
												//         for ($i=0; $i<$num; $i++) {
												//         	$boolean = $imagick->resize04($sourcePath, $destinationPath, $width, $height, $isCrop);
												//         }
												//         Zend_Debug::dump($boolean);
												//         Zend_Debug::dump(Common_Tool::executeEndTime()); // 1.311 12.83
		
												//         $destinationPath = ROOT_PATH . '/img/mm05.jpg';
												//         Common_Tool::executeStartTime();
												//         for ($i=0; $i<$num; $i++) {
												//         	$boolean = $imagick->resize($sourcePath, $destinationPath, $width, $height, $isCrop);
												//         }
												//         Zend_Debug::dump($boolean);
												//         Zend_Debug::dump(Common_Tool::executeEndTime()); // 1.98 11.91
		
        var_dump($boolean);				
        var_dump(Lib_Tool::executeEndTime());
        $this->_view->setIsView(true);
	}

	/**
	 * Lib_Imagick （对ImageMagick的扩展）调用
	 */
	public function imagick() {
		Lib_Tool::executeStartTime();
		
        // 分解gif图片
        /* $imagick = new Lib_Imagick();
        $path = ROOT_PATH . '/img/gif.gif.jpeg';
        $boolean = $imagick->read($path);
		$targetFolder = ROOT_PATH . '\img/font/';
		$imagick->gifDecay($targetFolder); */
		
		
		// gif 缩略图
		/* $sourcePath = ROOT_PATH . '/img/gif.gif.jpg';
		$targetPath = ROOT_PATH . '/img/new.png';
		$width = 130;
		$height = 280;
		$imagick = new Lib_Imagick();
		//$imagick->setSourcePath($sourcePath);
		$imagick->read($sourcePath);
		$imagick->gifThumbnail($width, $height, false);
		$boolean = $imagick->write($targetPath);
		if (!$boolean) {
		    var_dump($imagick->getError());
		} */
		
		
		// 生成缩略图
		/* $targetPath = ROOT_PATH . '/img\abc.jpeg';
        $srcImage = ROOT_PATH . '/img/gif.gif.jpeg';
        $dstImage = ROOT_PATH . '\img\new.jpg';
        $destinationImage = ROOT_PATH . '/img/new.gif';
		//$imagick = new Lib_Imagick();
		//$imagick->read($srcImage);
		$imagick = new Lib_Imagick($srcImage);
		$width = null;
		$height = 180;
		$quality = 78;
        $imagick->thumbnail($width, $height); // 不变形（默认）
		$imagick->setQuality($quality);
		$boolean = $imagick->write($destinationImage);
		if ($boolean) {
			var_dump('生成图片成功！');
		} else {
		    var_dump('错误：' . $imagick->getError());
		}
        echo '<br />'; */


        // 裁剪图片
        /* $imagick = new Lib_Imagick();
        $sourcePath = ROOT_PATH . '/img/gif.gif.jpeg';
        $imagick->read($sourcePath);
        $width = 300;
        $height = 308;
        $x = -100;
        $y = -100;
        $boolean = $imagick->crop($width, $height, $x, $y);
        var_dump($boolean);
        echo '<br />';
        $targetPath = ROOT_PATH . '/img/abc.jpeg';
        $boolean = $imagick->write($targetPath);
        if (!$boolean) {
            var_dump('错误： ' . $imagick->getError());
        }
        echo '<br />'; */
		
		
        // 文字水印
        /* $imagick = new Lib_Imagick();
        $sourcePath = ROOT_PATH . '/img/gif.gif.jpeg';
        $text = '123456789acThe虚 晕dog好.@#';
        $text = 'ABCD123456789acThe@#';
        $imagick->read($sourcePath);
        $style = array();
        $style['fontFile'] = ROOT_PATH . '/fonts/simsun.ttc';
        $style['fontSize'] = 19;
        $style['fillColor'] = '#f00';
        $style['fillOpacity'] = 0.41;
        $style['underColor'] = '#FF0000';
        $x = 10;
        $y = -9;
        $angle = 45;
        $place = Lib_Imagick::PLACE_NORTHWEST;
        $imagick->setSourcePath($sourcePath);
        $boolean = $imagick->watermarkText ( $text, $place, $x, $y, $angle, $style );
        var_dump($boolean);
        echo '<br />';
        $targetPath = ROOT_PATH . '/img/abc.gif';
        $targetPath = $imagick->setTargetPath($targetPath);
        $boolean = $imagick->write();
        if (!$boolean) {
            var_dump('错误： ' . $imagick->getError());
        } */
        
		
        // 水平和垂直翻转
        /* $sourcePath = ROOT_PATH . '/img/gif02.gif';
        $destinationPath = ROOT_PATH . '/img/new.jpeg';
        $imagick = new Lib_Imagick($sourcePath);
        $boolean = $imagick->rotateHV(Lib_Imagick::ROTATE_H);
        if (!$boolean) {
            die('翻转图片失败');
        }
        $boolean = $imagick->write($destinationPath);
        if ($boolean) {
            var_dump('翻转图片成功');
        } else {
            var_dump('失败：' . $imagick->getError());
        } */


        // 等比例缩放图片后进行裁剪
        /* $sourcePath = ROOT_PATH . '/img/gif.gif.jpeg';
        $targetPath = ROOT_PATH . '/img/new.gif';
        $width = 200;
        $height = 200;
        $place = 'center';
        $tooWideCutPosition = Lib_Imagick::PLACE_CENTER;
        $tooHighCutPosition = Lib_Imagick::PLACE_NORTH; 
        $imagick = new Lib_Imagick();
        $imagick->read($sourcePath);
        $imagick->resize($width, $height, $tooWideCutPosition, $tooHighCutPosition);
        $boolean = $imagick->write($targetPath);
        if ($boolean) {
            var_dump('生成等比例缩略图并裁剪成功！');
        } else {
            var_dump('失败：' . $imagick->getError());
        } */

		
        // 打图片水印 (貌似不给力，有些图片打出来不漂亮)
        /* $imagick = new Lib_Imagick();
        $sourcePath = ROOT_PATH . '/img/png.png';
        $watermarkPath = ROOT_PATH . '/img/Avatar.png';
        $targetPath = ROOT_PATH . '/img/abc.jpeg';
        $x = 58;
        $y = 58;
        $alpha = 80; 
        $position = Lib_Imagick::PLACE_SOUTHWEST;
        $imagick->read($sourcePath);
        $boolean = $imagick->watermarkImage($watermarkPath, $position, $x, $y, $alpha);
        $imagick->write($targetPath);
        if ($boolean) {
            var_dump('添加图片水印成功！');
        } else {
            var_dump('打图片水印失败：' . $imagick->getError());
        } */
		
		
		// 添加边框
        /* $sourcePath = ROOT_PATH . '/img/png.png';
        $imagick = new Lib_Imagick($sourcePath);
        $leftRight = 22;
        $topBottom = 12;
        $color = 'rgba(255,255,0,70)';
        $color = 'white';
        $boolean = $imagick->border($leftRight, $topBottom, $color);
        if ($boolean) {
            var_dump($boolean);
        } else {
            var_dump('添加边框失败：' . $imagick->getError());
        }
        $targetPath = ROOT_PATH . '/img/abc.png';
        $imagick->write($targetPath); */
        

        // 旋转图片
        /* $sourcePath = ROOT_PATH . '/img/bmp.bmp';
        $destinationPath = ROOT_PATH . '/img/abc.jpeg';
        $angle = -45;
        $color = 'transparent';
        //$color = 'white';
        //$color = '#FFF000';
        $imagick = new Lib_Imagick($sourcePath);
        $imagick->rotate($angle, $color);
        $boolean = $imagick->write($destinationPath);
        if ($boolean) {
            var_dump($boolean);
        } else {
            var_dump('添加边框失败：' . $imagick->getError());
        } */

		
        // 压缩jpg图片
        /* $imagick = new Lib_Imagick();
        $sourcePath = ROOT_PATH . '/img/bmp.bmp';
        $destinationPath = ROOT_PATH . '/img/abc.png';
        $quality = 2;
        $imagick->zip($sourcePath, $destinationPath, $quality); */


        // 等比例缩略图，留空的地方用其他颜色填充(这个函数貌似运行很慢)
        /* $width = 500;
        $height = 500;
        $sourcePath = ROOT_PATH . '/img/201331881747.gif';
        $targetPath = ROOT_PATH . '/img/abc.gif';
        $imagick = new Lib_Imagick ($sourcePath);
        //$boolean = $imageMagick->thumbnailAndStuffColour ( $sourcePath, $targetPath, $width, $height, '#FF0088' );
        $color = 'rgba(255,255,255,8)';
        $color = '#FF0088';
        $color = '#0f0';
        $boolean = $imagick->thumbnailAndStuffColour ($width, $height, $color);
        var_dump($boolean);		
        $boolean = $imagick->write($targetPath);
        if ($boolean) {
            var_dump($boolean);
        } else {
            var_dump('缩略图片失败：' . $imagick->getError());
        } */


		// 合并两张图片
		/* $onePath = ROOT_PATH . '/img/png.png';
		$twoPath = ROOT_PATH . '/img/Avatar.png';
		$destinationPath = ROOT_PATH . '/img/new.jpg';
		$x = 10;
		$y = 20;
		$imagick = new Lib_Imagick();
		$boolean = $imagick->join($onePath, $twoPath, $destinationPath, $x, $y);
		var_dump($boolean); */		
		
        // 字符串生成图片
        /* $imagick = new Lib_Imagick();
        $text = '123456789I love you!你爱我吗？yun！@#￥%……';
        $destinationPath = ROOT_PATH . '/img/abc.png';
        $size = 24;
        $font = ROOT_PATH . '/fonts/simsun.ttc';
        $color = 'rgba(255,255,255,88)'; // 这里的透明度没有用
        $color = 'cmyk(79,74,71,45)'; // #333
        $color = 'black'; // 黑色 ； red 红色
        $color = '#F0f';
        $opacity = 0.41;
        $underColor = 'white';
        $background = 'gray';
        $boolean = $imagick->text($text, $color, $size, $font, $opacity, $underColor, $background);
        var_dump($boolean);
        $boolean = $imagick->write($destinationPath);
        if ($boolean) {
            var_dump($boolean);
        } else {
            var_dump('字符串生成图片失败：' . $imagick->getError());
        } */
		
		
		// 对比度的调整(暂没有用)
		/* $imagick = new Common_ImageMagick();
		$sourcePath = APPLICATION_PATH . '/../public/img/abcd.bmp';
		$destinationPath = APPLICATION_PATH . '/../public/img/abb.bmp';
		$apply = true;
		$sharpen = false;
		$width = 300;
		$height = 200;
		$x = 180;
		$y = 160;
		//$imagick->contrast($sourcePath, $destinationPath, $sharpen, $apply, $width, $height, $x, $y);
		$path = APPLICATION_PATH . '/../public/img/ab.gif';
		$imagick->contrast($path, $path, $sharpen, $apply, $width, $height, $x, $y); */
		
		
        // 批量生成缩略图
        /* $imagick = new Lib_Imagick();
        $width = 100;
        $height = 100;
        $sourcePath = ROOT_PATH . '/img';
        $targetPath = ROOT_PATH . '/img/font';
        $type = 'jpg';
        $imagick->batchThumbnail($sourcePath, $targetPath, $width, $height, $type, true); */
		

        var_dump(Lib_Tool::executeEndTime());
    }
	
	/**
	 * Lib_image （gd库）调用
	 */
	public function image() {
		Lib_Tool::executeStartTime();
		
		
		// 生成缩略图
		/* $sourcePath = ROOT_PATH . '/img/jpeg.jpeg';
		//$sourcePath = ROOT_PATH . '/img/png8.png';
        $targetPath = ROOT_PATH . '\img\new/';
        $image = new Lib_Image(); // 创建对象
        $image->read($sourcePath);
        $width = 400;
        $height = 200;
        $bestfit = true;
        $boolean = $image->thumbnail($width, $height, $bestfit);
        $targetPath .= $image->getFileName() . '.' . $image->getSourceType();
        $flag = true;
        $image->setQuality(90);
        $boolean = $image->write($targetPath, $flag);
        if (!$boolean) {
        	var_dump($image->getError());
        } */

		
		// 裁剪图片
		/* $image = new Lib_Image();
		$sourcePath = ROOT_PATH . '/img/png8.png';
		$image->read($sourcePath);
		$width = 280;
		$height = 288;
		$x = -80;
		$y = -88;
		$boolean = $image->crop($width, $height, $x, $y);
		var_dump($boolean);
		echo '<br />';
		$targetPath = ROOT_PATH . '/img/abc.jpeg';
		$boolean = $image->write($targetPath);
		if (!$boolean) {
		    var_dump('错误： ' . $image->getError());
		}
		echo '<br />'; */
		

        // 打文字水印
        /* $text = '晕……^w￥爸爸的不甜';
        $sourcePath = ROOT_PATH . '/img/bmp.bmp';
        $targetPath = ROOT_PATH . '/img/abc.jpg';
        $place = Lib_Image::PLACE_NORTHWEST;        
        $x = 10;
        $y = 23;
        $angle = 0;
        $style['fontSize'] = 15;
        $style['fontFile'] = ROOT_PATH . '/fonts/simsun.ttc';
        $style['fillColor'] = '#0000FF';
        $style['fillOpacity'] = 50;
        $image = new Lib_Image();
        $image->read($sourcePath);
        $boolean = $image->watermarkText($text, $place, $x, $y, $angle, $style);
        $image->setTargetPath($targetPath);
        $boolean = $image->write();
		if ($boolean) {
		    var_dump($boolean);
		} else {
            var_dump('错误：' . $image->getError());
        } */
		
		
        // 水平或垂直翻转图片
        /* $sourcePath = ROOT_PATH . '/img/jpeg.jpeg';
        $image = new Lib_Image();
        $image->read($sourcePath);
        $image->rotateHV(Lib_Image::ROTATE_H);
        $destinationPath = ROOT_PATH . '/img/new.jpg';
        $boolean = $image->write($destinationPath);
        if ($boolean) {
            var_dump('翻转图片成功');
        } else {
            var_dump('失败：' . $image->getError());
        } */
        

        // 等比例缩放后，进行裁剪
        /* $sourcePath = ROOT_PATH . '/img/jpg.jpg';
        $targetPath = ROOT_PATH . '/img/abc.png';
        $width = 150;
        $height = 150;
        $place = 'center';
        $widthFlag = Lib_Image_Abstract::PLACE_EAST;
        $heightFlag = Lib_Image_Abstract::PLACE_NORTH;
        $image = new Lib_Image($sourcePath);
        $boolean = $image->resize($width, $height, $widthFlag, $heightFlag);
        $boolean = $image->write($targetPath,true);
        if ($boolean) {
            var_dump('等比例缩略后并进行裁剪成功');
        } else {
            die('生成缩略图失败：' . $image->getError());
        } */
		
		
		// 打图片水印
        /* $watermarkPath = ROOT_PATH . '/img/xiqiyanyan.gif';
        $sourcePath = ROOT_PATH . '/img/1645144841.gif';
        $targetPath = ROOT_PATH . '/img/abc.gif';
        $place = Lib_Image::PLACE_SOUTHEAST;
        $x = 15;
        $y = 14;
        $alpha = 48;
        $image = new Lib_Image();
        $image->read($sourcePath);
        $boolean = $image->watermarkImage($watermarkPath, $place, $x, $y, $alpha);
        var_dump($boolean);
        $boolean = $image->write($targetPath, true);
        if ($boolean) {
            var_dump('给源图片打上图片水印成功');
        } else {
            die('打图片水印失败：' . $image->getError());
        } */


        // 旋转图片
        /* $sourcePath = ROOT_PATH . '/img/jpg.jpg';
        $image = new Lib_Image($sourcePath);
        $angle = 60;
        //$color = array('red'=>0, 'green'=>0, 'blue'=>0, 'alpha'=>68);
        $color = 'transparent';
        //$color = '#00F';
        $boolean = $image->rotate($angle, $color);
        var_dump($boolean);
        $quality = 48;
        $image->setQuality($quality);
		$destinationPath = ROOT_PATH . '/img/abc.gif';
		$boolean = $image->write($destinationPath);
		if ($boolean) {
		    var_dump($boolean);
		} else {
		    var_dump('旋转图片失败：' . $image->getError());
		} */
		
		
        var_dump(Lib_Tool::executeEndTime());        
	}

	/**
	 * 生成缩略图
	 */
	public function thumbnailAction() {
		Common_Tool::executeStartTime();
		 
		/* $width = 800;
		 $height = 500;
		$type = 'gif';
		$rate = 10;
		$sourcePath = ROOT_PATH . '/img/1Z2391F2-0.jpg';
		$targetPath = ROOT_PATH . '/img\small/';
		$fileName = 'bbbbb';
		$image = new Common_Image();
		$image->setSourcePath($sourcePath);
		$image->setTargetPath($targetPath);
		//$image->setFileName($fileName);
		$fileName = $image->buildThumbnail($width, $height, $type, $rate);
		if ($fileName) {
		Zend_Debug::dump($fileName);
		} else {
		Zend_Debug::dump($image->getError());
		} */
		 
		 
		//     	$width = 50;
		//     	$height = 50;
		//     	$type = 'jpg';
		//     	$quality = 80;
		//     	$sourcePath = ROOT_PATH . '/img/jpg02.jpg';
		//     	$targetPath = ROOT_PATH . '/img/';
		//     	$fileName = 'small';
		//     	$image = new Common_Image($sourcePath, $targetPath, $fileName);
		//     	//$image->setSourcePath($sourcePath);
		//     	//$image->setTargetPath($targetPath);
		//     	//$image->setFileName($fileName);
		//     	//$fileName = $image->bindThumbnail($width, $height, $quality, false, $type);
		//     	$fileName = $image->bindThumbnail($width, $height);
		//     	if ($fileName) {
		//     		Zend_Debug::dump($fileName);
		//     	} else {
		//     		Zend_Debug::dump($image->getError());
		//     	}
			 
	

		 
		   
		/*
		 //     	$img1 = new Image('example_1.jpg');
		$img2 = new Common_Im(ROOT_PATH . '/img/gif.gif');
		 
		//调整图片大小
		//$img1->resize(700, 300, Image::DRAWTYPE_SCALE_FILL, Image::FITPOS_RIGHT_BOTTOM, array(255, 0, 0, 0));
		//$img1->save('a_111.jpg', true);
		//$img1->output();
		 
		//裁减图片
		$img2->crop(118, 80,250,230);
		//     	$img2->output();
		$img2->save(ROOT_PATH. '/img/abc.gif');
		*/
	
		$im = new Common_ImageMagick();
		$sourcePath = ROOT_PATH . '/img/gif.gif';
		$width = 200;
		$height = 200;
		$targetPath = ROOT_PATH . '/img/abc.gif';
		$boolean = $im->resizeToCrop($sourcePath, $width, $height, $targetPath);
		var_dump($boolean);
		 
		 
		Zend_Debug::dump(Common_Tool::executeEndTime());
		$this->_helper->viewRenderer->setNoRender();
		$this->_helper->layout()->disableLayout();
	}
	
// 	/**
// 	 * 通过url生成缩略图片
// 	 * url的图片也是可以生成的
// 	 */
// 	public function url2imgAction() {
// 	    $sourcePath = 'http://static.zlxpush.com/file/news_sohuphoto/9_4.jpg';
// 	    $dstImage = ROOT_PATH . '/img/new.jpg';
// 	    //$dstImage = 'http://study.com/img/new008.jpg'; // url是无法写的
// 	    $width = 330;
// 	    //$height = 450;
	
// 	    $imageMagick = new Common_ImageMagick();
// 	    $boolean = $imageMagick->thumbnail($sourcePath, $dstImage, $width);
// 	    var_dump($boolean);exit;
// 	    $this->_helper->viewRenderer->setNoRender();
// 	    $this->_helper->layout()->disableLayout();
// 	}
	
    /**
     * 测试表单上传图片
     */
    public function formPost() {
        var_dump($_SERVER['SERVER_PORT']);
        var_dump($_SERVER['SERVER_ADDR']);
        
//         $filePath = '/user_pic/15_10_15/fBjmVpy4151015101330.jpeg';
//         $imgUrl = Share_Img::formatImgPath($filePath, 100, 100, 'w', 's');
//         Common_Tool::prePrint($imgUrl);
        
        if (Common_Tool::isPost()) {
            if ($_FILES['file_data']['size'] > 0) {
                $img = new Share_Img();
                $filePath = $img->saveOriginByGd($_FILES['file_data']['tmp_name'], '/user_pic/');
                if ($filePath) {
                    $targetPath = IMG_PATH . $filePath;
                    echo '上传图片成功，源图上传的绝对路径是：' . $filePath;
                    echo '<br />';
                    echo '<img src="' . IMG_URL . $filePath . '" />';
                    echo '<br /><br />';
                } else {
                    Common_Tool::prePrint($img->getError());
                    die();
                }
                $width = 80;
                $height = 80;
                $filePath = $img->scaleByGd($targetPath, 'user_pic', $width, $height);
                if ($filePath) {
                    echo '等比例缩略图的相对路径是：' . $filePath;
                    echo '<br />';
                    echo '<img src="' . $img->formatImgPath($filePath, $width, $height) . '" />';
                    echo '<br /><br />';
                } else {
                    Common_Tool::prePrint($img->getError());
                    die();
                }
                $width = 100;
                $height = 100;
                $tooWidthCut = 'e';
                $tooHeightCut = 'n';
                $filePath = $img->scaleByGd($targetPath, 'user_pic', $width, $height, $tooWidthCut, $tooHeightCut);
                if ($filePath) {
                    echo '等比例缩放后，进行居中裁剪后的图的相对路径是：' . $filePath;
                    echo '<br />';
                    echo '<img src="' . $img->formatImgPath($filePath, $width, $height, $tooWidthCut, $tooHeightCut) . '" />';
                    echo '<br /><br />';
                } else {
                    Common_Tool::prePrint($img->getError());
                    die();
                }
            }
        }
        $this->_view->setIsView(true);
        $this->render();
    }
	
}







// class ImageController
// {
//  /**
// 		        * gd库操作， 图片类操作
// 		        */
// public function imageAction() {
// 		        if (Common_Tool::isPost()) {
// 		        $sourcePath = $_FILES['image']['tmp_name']; // 这个是个绝对路径
// 		        $targetPath = ROOT_PATH . '\img/';
// 		        $width = 330;
// 		        $height = 450;
// 		        $quality = 98;


// 		                // 裁剪图片
// 		                $fileName = 'abc';
// 		                $cutX = 466;
// 		                $cutY = 966;
// 		                $width = 500;
// 		                $height = 500;
// 		                $isCover = false;
// 		                $type = 'jpg';
//             $quality = 68;
//             $flag = true;
//             $image = new Common_Image();
//             $sourcePath = ROOT_PATH . '/img/ab.JPG';
//             $image->setSourcePath($sourcePath);
//             $image->setTargetPath($targetPath);
//             $image->setFileName($fileName);
//             $fileName = $image->cut($cutX, $cutY, $width, $height, $isCover, $type, $quality, $flag);

//     		if ($fileName) {
//     			var_dump($fileName);
//     		} else {
//     			print($image->getError());
//     		}

//     		$this->_helper->viewRenderer->setNoRender();
//     		$this->_helper->layout()->disableLayout();
//     	}
//     }

// }
