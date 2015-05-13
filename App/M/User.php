<?php

/**
 * 用户账号表类
 * @author Bear
 * @version 1.0.0
 * @copyright http://maimengmei.com
 * @created 2015-5-13 11:37
 */
class M_User extends CModel
{
    const START_NUM = 60000;
    const BATCH_NUM = 10000;
    
    /**
     * 为后台创建一批数字账号，预先存储
     * @return boolean
     */
    public function createBatch() {
        $start = $this->getMaxAccount();
        $end = $start + self::BATCH_NUM;
        $account = new M_Row_UserAccount();
//         $num = 11223345;
//         Common_Tool::prePrint($this->_checkTwoSeriesNum($num));
        $checks = array('_checkFourNum', '_checkTwoSeriesNum');
        for ($i = $start; $i < $end; $i++) {
            foreach ($checks as $k=>$v) {
                if ($this->$v($i)) {
                    continue 2;//break;
                }
            }
            $data = array();
            $data['accountNumber'] = $i;
            $account->add($data);
        }
        return true;
    }
    
    /**
     * 获取预存用户账号表中最大的账号
     */
    public function getMaxAccount() {
        $sql = 'select max(accountNumber) from `UserAccount`';
        $statement = $this->slave->pdo->query($sql);
        $max = $statement->fetchColumn(0);
        if (empty($max)) {
            return self::START_NUM;
        } else {
            return $max;
        }
    }
    
    /**
     * 检测是否是四连号(已经包括单一数字号；如：88888)
     * @param integer $num
     * @return boolean true:是四连号; false:不是四连号
     */
    private function _checkFourNum($num) {
        $num = '' . $num;
        $sum = strlen($num);
        for($i=0; $i<$sum; $i++) {
            $pattern = '/(' . $num[$i] . '){4}/';
            $boolean = preg_match($pattern, $num, $matches);
            if ($boolean) {
                return true;
            }
        }
        return false;
    }
    
    /**
     * 检测是否是两两连续号(如：112233)
     * TODO 多于6位考虑
     * @param integer $num
     * @return boolean true:是两两连续号; false:不是
     */
    private function _checkTwoSeriesNum($num) {
        if ($num < 112233) {
            return false;
        }
        $num = '' . $num;
        $one = intval(substr($num, 0, 2));
        $two = intval(substr($num, 2, 2));
        $three = intval(substr($num, 4, 2));
        $eleven = 11;
        if ((($one+$eleven) == $two) && ($two+$eleven) == $three) {
            return true;
        }
        if ((($one-$eleven) == $two) && ($two-$eleven) == $three) {
            return true;
        }
        return false;
    }
    
    /**
     * 检测是否是三三连续号(如：333444)
     * TODO 多于6位考虑
     * @param integer $num
     * @return boolean true:是两两连续号; false:不是
     */
    private function _checkThreeSeriesNum($num) {
        if ($num < 111222) {
            return false;
        }
        $num = '' . $num;
        $length = strlen($num);
        
        $one = intval(substr($num, 0, 2));
        $two = intval(substr($num, 2, 2));
        $three = intval(substr($num, 4, 2));
        $eleven = 11;
        if ((($one+$eleven) == $two) && ($two+$eleven) == $three) {
            return true;
        }
        if ((($one-$eleven) == $two) && ($two-$eleven) == $three) {
            return true;
        }
        return false;
    }
}
