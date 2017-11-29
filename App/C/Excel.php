<?php

/**
 * 测试PHPExcel类库的使用
 * @author bear
 * @copyright http://maimengmei.com
 * @created 2017-11-29
 */
class C_Excel extends BController
{
	public function init() {
//         parent::init();
        
	}
	
	/**
	 * 读取excel
	 */
	public function index() {
	    $path = ROOT_PATH . '/data/abc.xlsx';
	    $type = 'Excel2007';
	    $xlsxReader = PHPExcel_IOFactory::createReader($type);
	    $xlsxReader->setReadDataOnly(true);
	    $xlsxReader->setLoadSheetsOnly(true);
	    $sheets = $xlsxReader->load($path);
	    $dataArray = $sheets->getSheet(0)->toArray();
// 	    $dataArray = $sheets->getSheet(0);
	    var_dump($dataArray);
	    
// 	    $excel = new \PHPExcel();
// 	    $props = $excel->getProperties(); // 设置文档基本属性
// 	    $props->setCreator('欧阳海雄'); // 设置作者
// 	    $activeSheet = $excel->getActiveSheet();
// 	    $activeSheet->mergeCells('A1:C1'); // 合并单元格
// 	    //         $activeSheet->unmergeCells('A1:C1'); // 分离单元格
// 	    $activeSheet->getColumnDimension('B')->setAutoSize(true); // 设置单元格样式；设置为自动宽高
	    //         $activeSheet->getColumnDimension('A')->setWidth(30); // //设置宽度
	}

    /**
     * 写入Excel
     */
    public function writer() { // createWriter(PHPExcel $phpExcel, $writerType = '')
        $PHPExcel = new PHPExcel();
        $properties = $PHPExcel->getProperties();
        $properties->setCreator('Bear')->setLastModifiedBy('欧阳海雄')->setTitle('测试文档')->setSubject('班级列表'); // 设置文档的基本信息
        $properties->setDescription('这是一个测试excel')->setKeywords('班名册')->setCategory('');
        
        $PHPExcel->setActiveSheetIndex(0); // 设置当前工作表
        $activeSheet = $PHPExcel->getActiveSheet();
        $activeSheet->setTitle('班级名单'); // 设置工作表标题
        $activeSheet->setCellValue('A1', '班名册'); // 填入主标题
        // 填入表头
        $activeSheet->setCellValue('A2', '学号');
        $activeSheet->setCellValue('B2', '姓名');
        $activeSheet->setCellValue('C2', '年龄');
        // 填入数据
        $data = array(
                array(1001, '张三', 18),
                array(1002, '李四', 25),
                array(1008, '欧阳海雄，就是你了！！！！', 34)
        );
        $num = 1;
        foreach ($data as $key=>$value ) {
            $activeSheet->setCellValue('A' . ($key+3), $value[0]);
            $activeSheet->setCellValue('B' . ($key+3), $value[1]);
            $activeSheet->setCellValue('C' . ($key+3), $value[2]);

            $activeSheet->getRowDimension($key+3)->setRowHeight(20); // 设置每一行行高. $activeSheet->getRowDimension('1')->setRowHeight(30);设置第几行的行高
            $num++;
        }
        
        $activeSheet->mergeCells('A1:C1'); // 合并单元格(unmergeCells分离单元格)
        $activeSheet->getColumnDimension('A')->setWidth(10); // 设置单元格宽度
        $activeSheet->freezePane('A2'); // 冻结窗口
        // 设置字体样式  
        $styleA1 = $activeSheet->getStyle('A1'); // 获取样式
        $styleA1->getFont()->setName('黑体');
        $styleA1->getFont()->setSize(20);
        $styleA1->getFont()->setBold(true);
        
        $activeSheet->getStyle('A2:C2')->getFont()->setBold(true); // 选中多个单元格，进行样式设置
        $activeSheet->getStyle('A2:C2')->getFont()->setName('宋体');
        $activeSheet->getStyle('A2:C2')->getFont()->setSize(16);
        
//         $styleA1->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); // 设置水平居中【这个在这里不生效】 (特别注意了，如果合并了单元格，设置居中也是需要全选中的)
        $activeSheet->getStyle('A1:C1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); // 设置水平居中
        $activeSheet->getStyle('A3:C' . ($num+1))->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER); // 设置垂直居中
//         $activeSheet->getStyle('A1:C' . ($num+1))->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN); // 设置单元格边框（只有内垂直的边框，这里是实线细的）
        $activeSheet->getStyle('A1:C' . ($num+1))->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_HAIR); // 设置单元格边框（只有内垂直的边框，这里是虚线细的）
        $activeSheet->getStyle('A3:C5')->getAlignment()->setWrapText(true); // 设置自动换行
        $activeSheet->getColumnDimension('B')->setAutoSize(true); // 设置为自动宽高【如果没有设置行高的话，宽和高度都是自动适应的】

//         $writerType = 'Excel2007';
//         $filePath = ROOT_PATH . '/data/excelTest_' . date('Ymd') . '.xlsx';
//         $xlsxWriter = PHPExcel_IOFactory::createWriter($PHPExcel, $writerType);
//         $xlsxWriter->save($filePath); // 保存入文件
//         echo '保存文件成功！';

        // 保存为2003格式
        $xlsWriter = new PHPExcel_Writer_Excel5($PHPExcel);
        header('Pragma:public');
        header('Expires:0');
        header('Cache-Control:must-revalidate,post-check=0,pre-check=0');

        // 多浏览器下兼容中文标题
        $fileName = '导出班级名单_' . date('Y-m-d');
        $encodeFileName = urlencode($fileName);
        $userAgent = $_SERVER['HTTP_USER_AGENT'];
        if (preg_match('/MSIE/', $userAgent)) { // IE
            header('Content-Disposition:attachment;filename=' . $encodeFileName . '.xls');
        } else if (preg_match('/Firefox/', $userAgent)) { // Firefox
            header('Content-Disposition:attachment;filename*="utf8\'\'' . $fileName . '.xls"');
        } else {
            header('Content-Disposition:attachment;filename="' . $fileName . '.xls"');
        }
//         header("Content-Type:application/force-download"); // 貌似只要一个Content-Type就可以
//         header("Content-Type:application/vnd.ms-excel");
//         header("Content-Type:application/octet-stream");
        header('Content-Type:application/download');
        header('Content-Transfer-Encoding:binary');
        $xlsWriter->save('php://output'); // 在浏览器中直接输出
    }
	

}
