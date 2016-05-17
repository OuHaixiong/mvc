<?php

/**
 * 测试搜索
 * @author Bear
 * @version 2.0.0
 * @copyright http://maimengmei.com
 * @created 2016-01-12 18:35
 */
class C_Search extends BController
{
    public function init() {}
    
    /**
     * sphinx（coreseek）搜索测试
     */
    public function sphinx() {
        include_once ROOT_PATH . '/../../libraries/sphinxapi.php';
        $s = new SphinxClient();
        $s->setServer("192.168.253.10", 9312);
        $s->setMatchMode(SPH_MATCH_PHRASE);
        $s->setMaxQueryTime(30);
//         $res = $s->query('搜索');
//         $res = $s->query('十分之一');
        $res = $s->query('一次');
//         $res = $s->query('人');
        if ($res === false) {
            die ( "Query failed, ERROR: " . $s->GetLastError() . ".\n" );
        } else {
            foreach ($res['matches'] as $key=>$docinfo) {
            
            }
        }
        //var_dump($res);exit;
        var_dump($res['matches']);
        
    }
    
    /**
     * sphinx（coreseek）搜索测试[基于mysql的搜索]
     */
    public function productI() {
        include_once ROOT_PATH . '/../../libraries/sphinxapi.php';
        $s = new SphinxClient();
        $s->SetServer('192.168.253.4', 9312);
        $s->SetConnectTimeout(3); 
        $s->SetArrayResult(true); // 特别注意此参数，默认为false：结果($res['matches'])的key为主键id，如果设置为true：会把主键id放在value中
//         var_dump($s);
//         $s->setMatchMode(SPH_MATCH_PHRASE);
//         $s->setMatchMode(SPH_MATCH_ALL);
        $s->setMatchMode(SPH_MATCH_ANY);
//         $s->setMaxQueryTime(300);
//         $res = $s->query('手机');
//         $res = $s->query('', 'product_i');
//         $res = $s->query('网络搜索', 'mysql'); 
        $res = $s->query('搜索', 'mysql'); 
        print_r($res);
        if ($res === false) {
            die ('Query failed, ERROR: ' . $s->GetLastError() . " \n");
        } else {
            if ($res['total'] == 0) {
                die('没有符合的记录');
            }
            foreach ($res['matches'] as $key=>$doc) {
                var_dump($doc);
            }
        }
        echo '<br />-----------------------------------<br />';
        print_r($s);
    }

}