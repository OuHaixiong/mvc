<?php

/**
 * (普通)属性的操作
 * @author Bear
 * @version 2.0.0
 * @copyright http://maimengmei.com
 * @created 2015-12-1 10:35
 */
class C_Property extends BController
{
    public function init() {}
    
    /**
     * 添加一个属性
     */
    public function add() {
        $data = array();
        $data['name'] = '价格区间';
        $data['remark'] = '手机类的价格区间属性';
        $data['value'] = array(
            '1' => '500以下',
            '2' => '501~1000',
            '3' => '1001~5000',
            '4' => '5000以上',
        );
        $property = new M_Property();
        $boolean = $property->save($data);
        Common_Tool::prePrint($boolean);
    }
    
}
