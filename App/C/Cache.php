<?php

/**
 * 缓存练习
 * @author Bear
 * @version 1.0.0
 * @copyright http://maimengmei.com
 * @created 2015-6-9 16:37
 */
class C_Cache extends BController
{
    public function init() {
        
    }
    
    /**
     * redis练习
     */
    public function redis() {
        /* $redis = new Redis();  // 原生态
        $redis->connect('120.24.72.101', 6379, 0);
        $key = 'key-test';
        $redis->set($key, '文档收代理费dsf');
        $value = $redis->get($key);
        Common_Tool::prePrint($value, false);
        $redis->delete($key);
        $value= $redis->get($key);
        Common_Tool::prePrint($value, false); */ 
    	
    	$redis = new Common_Redis();
    	Common_Tool::prePrint($redis, false);
    	$key = 'key-test';
    	$redis->set($key, 'wo日文1123档收代理费dsf88'); // 字符串型（string）
    	$value = $redis->get($key);
    	Common_Tool::prePrint($value, false);
    	Common_Tool::prePrint('string 的长度是：'. $redis->strlen($key), false);
    	$redis->delete($key);
    	$value= $redis->get($key);
    	Common_Tool::prePrint($value, false);
    	
    	Common_Tool::prePrint($redis->exists($key), false);
    	
    	echo '<br />----------list操作-----------<br />';
    	
    	$listKey = 'key-list-test';
    	$redis->lPush($listKey, 'one'); // 下标从0开始。list很适合用来做队列
        $size = $redis->rPushx($listKey, 'value'); // 在名称为key-list-test的list左边(头)/右边（尾）添加一个值为value的元素,如果value已经存在，则不添加
        // 特别注意了：rPushx 操作list时，list必须有数据，不然无法操作成功。成功返回list的大小，失败返回0
        var_dump($size);
        Common_Tool::prePrint('list的大小：' . $redis->lSize($listKey), false);
        Common_Tool::prePrint($redis->lGet($listKey, 0), false);
    	$redis->lSet($listKey, 0, 'abc'); // List类型，给名称为key-list-test的list中首位置的元素赋值为abc
    	$redis->lPush($listKey, 'left'); // 在名称为key-list-test的list左边（头）添加一个值为left的 元素
    	$redis->rPush($listKey, 'right'); // 在名称为key-list-test的list右边（尾）添加一个值为right的 元素
    	Common_Tool::prePrint('list的大小：' . $redis->lSize($listKey), false); // 返回名称为key-list-test的list有多少个元素
    	$allValue = $redis->lRange($listKey, 0, -1); // 返回名称为key的list中start至end之间的元素（end为 -1 ，返回所有）
    	Common_Tool::prePrint($allValue, false);
        Common_Tool::prePrint($redis->lIndex($listKey, 2), false); // 和lGet一样的功能；返回名称为key的list中index位置的元素
        $rightValue = $redis->rPop($listKey); // 输出名称为key的list左(头)起/右（尾）起的第一个元素，删除该元素
        Common_Tool::prePrint('list的大小：' . $redis->lSize($listKey), false);
        $num = $redis->del($listKey);
    	Common_Tool::prePrint('删除个数：' . $num, false);
    	Common_Tool::prePrint($redis->exists($listKey), false); // 判断key是否存在。存在 true ; 不存在 false
    	Common_Tool::prePrint($redis->lSize($listKey), false);
    	
    	echo '<br />----------set（集合）操作-----------<br />';
    	
    	$key = 'key';
    	$redis->sAdd($key, 1); // 向名称为key的set中添加元素value,如果value存在，不写入，return false ； 成功返回1
    	$redis->sAdd($key, 2);
    	$boolean = $redis->sAdd($key, 3);
        echo '添加元素到set（集合）中的返回值：';
        var_dump($boolean);
        echo '<br />';
        $members = $redis->sMembers($key);// 返回名称为key的set的所有元素。同名函数sGetMembers
        Common_Tool::prePrint($members, false);
        Common_Tool::prePrint($redis->sRandMember($key), false); // sRandMember 随机返回名称为key的set中一个元素，不删除
        
        $key2 = 'key2';
        $redis->sAdd($key2, 'set1');
        $redis->sAdd($key2, 2);
        $redis->sAdd($key2, '3');
        $redis->sAdd($key2, '6');
        $redis->sAdd($key2, 5);
        $redis->sAdd($key2, 'abc');
        $inter = $redis->sInter($key, $key2); // 求多个集合的交集。$redis->sInterStore('output', 'key1', 'key2', 'key3')求交集并将交集保存到output的集合
        echo('两个集合(set)的交集是：');
        var_dump($inter);
        echo '<br />';
        $redis->sUnionStore('output', $key, $key2); // 求多个集合（set）的并集并将并集保存到output的集合
        echo('两个集合(set)的并集是：');
        $output = $redis->sMembers('output');
        var_dump($output);
        echo '<br />';
        $diff = $redis->sDiff($key2, $key); // 求多个集合的差集。sDiffStore求差集并将差集保存到output的集合
        echo('两个集合(set)的差集是：'); // 特别注意：差集是把第一个集合中有在第二个集合中的元素去掉，最终返回第一个集合剩下的元素
        var_dump($diff);
        echo '<br />';

        $boolean = $redis->sIsMember($key, 2); // 名称为key的集合中查找是否有value元素，有ture 没有 false
        echo('是否存在2这个元素：');
        var_dump($boolean);
        echo '<br />';
        $boolean = $redis->sRemove($key, 2);// 删除名称为key的set中的元素value，如果存在并删除成功返回1，失败返回0
        echo ('成功删除返回值：');
        var_dump($boolean); 
        echo '<br />';
        $boolean = $redis->sRem($key, 2); // 和sRemove是同名函数
        echo('不存在的值删除后返回值：');
        var_dump($boolean);
        echo '<br />';
        $boolean = $redis->sContains($key, 2); // 和 sIsMember是同名函数，判断是否存在此元素
        echo ('是否存在2这个元素：');
        var_dump($boolean);
        echo '<br />';
        Common_Tool::prePrint($redis->sGetMembers($key), false);
        $redis->delete($key);
        $redis->del($key2);
        Common_Tool::prePrint($redis->exists($key), false);
        
        echo '<br />----------zset(有序集合)操作-----------<br />';
        $key = 'key';
        $redis->zAdd($key, 1, 'val1'); // 向名称为key的zset中添加元素member，score用于排序。如果该元素已经存在，则根据score更新该元素的顺序。
        $redis->zAdd($key, 0, 'val0');
        $redis->zAdd($key, 5, 'val5');
        $zmember = $redis->zRange($key, 0, -1); // 正序获取zset所有元素
        echo '添加元素到zset（有序集合）中后，所有元素的返回值：';
        var_dump($zmember);
        echo '<br />';
        $redis->zDelete($key, 'val1'); // 删除名称为key的zset中的元素member.zRem为同名函数
        $zmember = $redis->zRange($key, 0, -1, true); // 最后的参数默认false：只返回值，如果为true：返回值作为key，排序作为值的数组
        echo '删除元素后zset（有序集合）所有元素的返回值：'; 
        var_dump($zmember);
        echo '<br />';
        $zmember = $redis->zRevRange($key, 0, -1, true); // 倒序获取元素，从大到小。最后参数：是否输出socre（排序）的值，默认false，不输出
        echo '倒序后的zset（有序集合）所有元素为：';
        var_dump($zmember);
        echo '<br />';
        $zmember = $redis->zRangeByScore($key, 0, 3); // 返回名称为key的zset中score >= star且score <= end的所有元素
        echo '根据排序（score）获取区间值，zset（有序集合）所有排序大于-1且小于4的元素为：'; 
        var_dump($zmember);
        echo '<br />';
        $delNum = $redis->zRemRangeByScore($key, 0, 1); // 删除名称为key的zset中score >= star且score <= end的所有元素，返回删除个数
        echo '删除score区间内的值，并返回删除个数为：';
        var_dump($delNum);
        echo '<br />';
        $zmember = $redis->zRange($key, 0, -1, true);
        echo '删除score区间内的值后zset（有序集合）所有元素的返回值：';
        var_dump($zmember);
        echo '<br />';
        Common_Tool::prePrint('现在zset元素个数是：' . $redis->zCard($key), false); // 返回名称为key的zset的所有元素的个数。同名函数zSize
        $redis->delete($key);
        Common_Tool::prePrint($redis->exists($key), false);
        
        echo '<br />-----------hash操作-----------<br />';
        
        $key = 'hash';
        $redis->hSet($key, 'h', 'hello'); // 向名称为key的hash中添加元素h—>hello
        $hello = $redis->hGet($key, 'h'); // 返回名称为key的hash中h对应的value（hello）
        echo 'hash中的h值为：';
        var_dump($hello);
        echo '<br />';
        $len = $redis->hLen($key); //返回名称为key的hash中元素个数
        echo 'hash中的元素个数为：';
        var_dump($len);
        echo '<br />';
        $redis->hDel($key, 'h'); // 删除名称为h的hash中键为key1的域
        $hello = $redis->hGet($key, 'h'); // 返回名称为key的hash中h对应的value（hello）
        echo '删除hash中的h后是否还能找到，值为：';
        var_dump($hello);
        echo '<br />';
        $redis->hSet($key, 'b', 'Bye');
        $redis->hSet($key, 'l', 'love');
        $redis->hSet($key, 'o', 1);
        $redis->hSet($key, 'and', '&');
        $hKeys = $redis->hKeys($key); // 返回名称为key的hash中所有键
        echo 'hash中的所有键为：';
        var_dump($hKeys);
        echo '<br />';
        $hValues = $redis->hVals($key); // 返回名称为key的hash中所有键对应的value（非键值对）
        echo 'hash中所有值为：';
        var_dump($hValues);
        echo '<br />';
        $hValues = $redis->hGetAll($key); // 返回名称为key的hash中所有的键（field）及其对应的value, 为键值对
        echo 'hash中所有键值为：';
        var_dump($hValues);
        echo '<br />';
        $boolean = $redis->hExists($key, 'o'); // 名称为key的hash中是否存在键名字为o的域
        echo 'hash中是否有o键的元素：'; 
        var_dump($boolean);
        echo '<br />';
        $redis->hIncrBy($key, 'o', 2); // 将名称为key的hash中o的value增加2
        $o = $redis->hGet($key, 'o');
        echo 'hash中o键的元素+2后的值为：'; 
        var_dump($o);
        echo '<br />';
        $redis->hMset($key, array('name'=>'欧海雄', 'salary'=>200000));
        $hValues = $redis->hGetAll($key); // 返回名称为key的hash中所有的键（field）及其对应的value, 为键值对
        echo 'hash中所有键值为：';
        var_dump($hValues);
        echo '<br />';
        $fieldValue = $redis->hMget($key, array('name', 'l')); // 返回名称为key的hash中field1,field2对应的value.返回值会按对应的键
        echo 'hash中批量获取健对应的值为：';
        var_dump($fieldValue);
        echo '<br />';
        echo 'redis的版本信息:';
        var_dump($redis->info());
        echo '<br />';
        $redis->del($key);
        Common_Tool::prePrint($redis->exists($key));
    }
    
    /**
     * memcache练习
     */
    public function memcache() {
        
    }
    
    /**
     * 文件缓存练习
     */
    public function file() {
        
    }
    
    /**
     * redis主从练习
     */
    public function masterSlave() {
        var_dump($_SERVER['SERVER_PORT']);
        var_dump($_SERVER['SERVER_ADDR']);
        echo '<br />';
        // 主写，主读
        $key = 'test_key';
        $masterRedis = BRedis::getMaster();
//         $masterRedis->set($key, '你好我也hao!');
        Common_Tool::prePrint($masterRedis->get($key), false);
        Common_Tool::executeStartTime();
        // 主写，从读
        $key2 = 'mWrite_sRead';
//         $masterRedis->set($key2, '主写进去的数据，从能马上读出来吗?');
        $slaveRedis = BRedis::getSlave();
        Common_Tool::prePrint($slaveRedis->get($key2), false); // redis中如果键不存在，返回false
        
        $key3 = 'yc';
        $masterRedis->set($key3, '难道真的一点延迟都没有吗');
        $slaveRedis = BRedis::getSlave();
        Common_Tool::prePrint($slaveRedis->get($key3), false);
        echo '<br />';
        echo '页面总共运行： ' . Common_Tool::executeEndTime() . ' 秒';
    }
    
}
