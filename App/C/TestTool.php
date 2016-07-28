<?php

/**
 * 测试类库中的tool类中的方法
 * @author Bear
 * @version 1.0.0
 * @copyright http://maimengmei.com
 * @created 2016-7-28 16:23
 */
class C_TestTool extends BController
{
    /**
     * 测试组合数
     */
    public function combinatorial() {
        // 测试5的阶乘
        var_dump(Common_Tool::getFactorial(6));
        
        // 测试5个数中任意4个数的组合有多少种
        $total = 5;
        $number = 4;
        var_dump(Common_Tool::getCombinatorialNumber($total, $number));
        // 测试5个数中任意3个数的组合有多少种
        $total = 5;
        $number = 3;
        $sum = Common_Tool::getCombinatorialNumber($total, $number);
        echo "{$total}个数中任意{$number}个数的组合有{$sum}种<br />";
        // 测试5个数中任意2个数的组合有多少种
        $total = 5;
        $number = 2;
        $sum = Common_Tool::getCombinatorialNumber($total, $number);
        echo "{$total}个数中任意{$number}个数的组合有{$sum}种<br />";
        echo '<br />';
        
        // 测试2个数的全组合有多少种
        $number = 2;
        $sum = Common_Tool::getFullCombinatorial($number);
        echo "{$number}个数的全组合有{$sum}种<br />";
        // 测试3个数的全组合有多少种
        $number = 3;
        $sum = Common_Tool::getFullCombinatorial($number);
        echo "{$number}个数的全组合有{$sum}种<br />";
        // 测试4个数的全组合有多少种
        $number = 4;
        $sum = Common_Tool::getFullCombinatorial($number);
        echo "{$number}个数的全组合有{$sum}种<br />";
        // 测试5个数的全组合有多少种
        $number = 5;
        $sum = Common_Tool::getFullCombinatorial($number);
        echo "{$number}个数的全组合有{$sum}种<br />";
        // 测试6个数的全组合有多少种
        $number = 6;
        $sum = Common_Tool::getFullCombinatorial($number);
        echo "{$number}个数的全组合有{$sum}种<br />";
        
        $arr = array('a','b','c','d');
        $result = array();
        $t = $this->getCombinationToString($arr, 4);
        print_r($t);
        
        
        
    }

}