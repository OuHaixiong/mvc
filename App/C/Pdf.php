<?php

/**
 * PDF文件的一些操作
 * @author Bear[258333309@163.com] 
 * @version 1.0.0
 * @date 2019年5月13日
 */
class C_Pdf extends BController
{
    /**
     * 合并pdf文件
     */
    public function merger() {
        $mergerPath = APP_PATH . '/Share/PDFMerger/PDFMerger.php';
        $dataPath = realpath(ROOT_PATH . '/../data');
        include_once $mergerPath;
        $pdfMerger = new PDFMerger();
//         $pdfMerger->addPDF($dataPath . '/22.pdf', '3,1'); // 取某几页
//         $pdfMerger->addPdf($dataPath . '/Modern-PHP.pdf', '179-181'); // 取连续页
//         $pdfMerger->addPdf($dataPath . '/1.6.pdf', 'all'); // 取所有
//         $pdfMerger->merge('file', $dataPath . '/merge_test.pdf'); // 合并成文件，后面的参数为需要保存的绝对路径
        // 如果是：browser 代表在浏览器中直接进行预览查看，后面的参数可以不传，如：$pdfMerger->merge('browser');
        // 如果是：string  代表数据是以二进制字符串进行返回，我们需要用一个变量来接受，如：$s = $pdfMerger->merge('string');
//         $pdfMerger->merge('download', 'abc/bb.pdf'); // 如果选择的是直接下载，后面的参数就是文件名，如果写成路径格式的话，“/”会被去掉
    }
}
