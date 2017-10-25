<?php

// import email

/**
 * 输出json格式的数据
 * @param integer $status 状态
 * @param string $message 消息
 */
function echoJson($status, $message) {
    $response = array();
    $response['status'] = $status;
    $response['message'] = $message;
    echo json_encode($response);
    exit();
}

/**
 * 判断是否为ajax请求；特别注意了：此函数判断是是jQuery的ajax，无法判断原生态的ajax
 * 准确来说，jquery内部实现ajax的时候，已经加入了标识；jquery源码中是这样的：xhr.setRequestHeader("X-Requested-With", "XMLHttpRequest");所以，在php中可以通过HTTP_X_REQUESTED_WITH来判断，不需要另外实现
 * @return boolean
 */
function isJQueryAjax() {
    if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && ($_SERVER['HTTP_X_REQUESTED_WITH']==='XMLHttpRequest')) {
        return true;
    } else if (isset($_SERVER['HTTP_USER_AGENT']) && (stripos($_SERVER['HTTP_USER_AGENT'],'Shockwave')!==false)) {
        return true;
    } else if ((stripos($_SERVER['HTTP_USER_AGENT'],'Flash')!==false)) {
        return true;
    } else {
        return false;
    }
}

/**
 * 判断是否ajax请求，用于原生态的js(注意了本函数依赖前段js请求时需带上头信息：xmlHttp.setRequestHeader("request_type","ajax");)
 * @return boolean
 */
function isNativeAjax() {
    return isset($_SERVER['HTTP_REQUEST_TYPE']) && ($_SERVER['HTTP_REQUEST_TYPE']=='ajax');
}

/**
 * 判断是否为ajax请求
 * @return boolean true:是； false:否
 */
function isAJAX() {
    return isJQueryAjax() || isNativeAjax();
}

if (strtoupper($_SERVER['REQUEST_METHOD']) != 'POST') {
    echoJson(-1, '请使用post提交');
}
if (empty($_POST)) {
    echoJson(-1, '参数不能为空');
}
$types = array('zh-CN', 'en-US');
if ((!isset($_POST['language'])) && (!in_array($_POST['language'], $types))) {
    echoJson(-1, '语言参数错误');
}
if (isset($_POST['email'])) {
    $email = $_POST['email'];
    $boolean = filter_var($email, FILTER_VALIDATE_EMAIL);
    if ($boolean == false) {
        echoJson(-1, '邮箱格式错误');
    }
} else {
    echoJson(-1, '邮箱不能为空');
}

$type = $_POST['language'];
$filename = 'mEos_' . $type; // 设置文件名
// $filePath = realpath(__DIR__ . '/../data/' . $filename . '.csv');
$filePath = __DIR__ . '/../data/' . $filename . '.csv';
if (is_file($filePath)) {
    // file($xxx); 把整个文件读入一个数组中. 数组中的每个单元都是文件中相应的一行，包括换行符在内。如果失败返回 FALSE。 
    $allEmail = file($filePath);
    if (in_array($email . "\n", $allEmail)) {
        echoJson(1, '提交成功');
    } else {
        $allEmail[] = $email . "\n";
        $allEmail = implode('', $allEmail);
    }
} else {
    $allEmail = $email . "\n";
}
$number = file_put_contents($filePath, $allEmail);
if ($number) {
    echoJson(1, '提交成功');
} else {
    echoJson(-1, '提交失败');
}
