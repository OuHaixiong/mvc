<?php

if ((strtoupper($_SERVER['REQUEST_METHOD']) != 'POST') || empty($_POST)) {
    header('Location:/exportIndex.html');
    exit;
}
if ((!isset($_POST['exportCode'])) || ($_POST['exportCode'] != 'Bear.Makeblock')) {
    header('Location:/exportIndex.html');
    exit;
}

/**
 * 导出数据为csv格式的文件
 * @param string $filename 保存文件名
 * @param string $string 数据【字符串】
 */
function exportCsv($filename, $string) {
    header('Content-Type: text/csv'); //  header('Content-Type: application/octet-stream');
    header('Content-Disposition:attachment;filename=' . $filename . '.csv');
    header('Expires:0');
    header('Cache-Control:must-revalidate,post-check=0,pre-check=0');
    header('Pragma:public');
    // header('Content-Length:' . strlen($string));
    // header('Content-Description:File Transfer'); header('Content-Transfer-Encoding: binary');
    echo $string;
//     exit(); 
}

$type = $_POST['type'];
if ($type == 'en-US') {
    $type = 'en-US';
} else {
    $type = 'zh-CN';
}
$filename = 'mEos_' . $type; // 设置文件名
$filePath = realpath(__DIR__ . '/../data/' . $filename . '.csv');
$outputString = '';
//$outputString = '邮箱,姓名,年龄' . "\n";
if (is_file($filePath)) {
    // file($xxx); 把整个文件读入一个数组中. 数组中的每个单元都是文件中相应的一行，包括换行符在内。如果失败返回 FALSE。 
    $outputString .= file_get_contents($filePath);
}
$outputString = iconv('utf-8', 'gbk//ignore', $outputString); // 中文转码  iconv('utf-8', 'gb2312//ignore', $str)
exportCsv($filename, $outputString);// 导出
