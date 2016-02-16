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
        $res = $s->query('人');
        if ($res === false) {
            die ( "Query failed, ERROR: " . $s->GetLastError() . ".\n" );
        } else {
            foreach ($res['matches'] as $key=>$docinfo) {
            
            }
        }
//         var_dump($res);exit;
        var_dump($res['matches']);
        
    }

}