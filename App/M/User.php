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
    const START_NUM = 59999;
    const BATCH_NUM = 20000;
    
    /**
     * 为后台创建一批数字账号，预先存储
     * @return boolean
     */
    public function createBatch() {
        $max = $this->getMaxAccount();
        $start = $max + 1;
        $end = $start + self::BATCH_NUM;
        $account = new M_Row_UserAccount();
        // TODO 利用事务，锁表操作
//         $num = 999888777666;
//         Common_Tool::prePrint($this->_checkThreeSeriesNum($num));
        $checks = array('_checkOneNum', '_checkFourNum', '_checkTwoSeriesNum', '_checkThreeSeriesNum', '_checkSpecialNum');
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
        // 修改表UserAccount中，已经存在表UserMember中的用户为已注册
        $sql = "select `accountNumber` from `UserMember` where `accountNumber`>{$max} and `accountNumber`<{$end}";
        $statement = $this->slave->pdo->query($sql);
        $rowset = $statement->fetchAll(PDO::FETCH_OBJ);
        $ids = array();
        foreach ($rowset as $row) {
            $ids[] = $row->accountNumber;
        }
        if (!empty($ids)) {
            $ids = implode(',', $ids);
            $where = " `accountNumber` in ({$ids})";
            $this->master->update('UserAccount', array('status'=>0), $where);
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
     * 检测是否是单一数字号；如 22222
     * @param integer $num
     * @return boolean
     */
    private function _checkOneNum($num) {
        $num = '' . $num;
        $first = $num[0];
        $sum = strlen($num);
        for ($i=1; $i<$sum; $i++) {
            if ($num[$i] != $first) {
                return false;
            }
        }
        return true;
    }
    
    /**
     * 检测是否是四连号;如 44445(已经包括单一数字号；如：88888)
     * @param integer $num
     * @return boolean true:是四连号; false:不是四连号
     */
    private function _checkFourNum($num) {
        if ($num > 99999999) {
            return false;
        }
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
        $length = strlen($num);
        if (($length%2) == 1) {
            return false;
        }
        $groups = array();
        for ($i=0; $i<$length;) {
            $groups[] = intval(substr($num, $i, 2));
            $i = $i+2;
        }
//         $one = 
//         $two = intval(substr($num, 2, 2));
//         $three = intval(substr($num, 4, 2));
        $eleven = 11;
        $count = count($groups)-1;
        $boolean = true;
        for ($i=0; $i<$count; $i++) {
            if (($groups[$i]+$eleven) != $groups[$i+1]) {
                $boolean = false;
                break;
            }
        }
        if ($boolean) {
            return true;
        }
        for ($i=0; $i<$count; $i++) {
            if (($groups[$i]-$eleven) != $groups[$i+1]) {
                return false;
            }
        }
        return true;        
    }
    
    /**
     * 检测是否是三三连续号(如：333444)
     * @param integer $num
     * @return boolean true:是两两连续号; false:不是
     */
    private function _checkThreeSeriesNum($num) {
        if ($num < 111222) {
            return false;
        }
        $num = '' . $num;
        $length = strlen($num);
        if (($length%3) != 0) {
            return false;
        }
        $groups = array();
        for ($i=0; $i<$length;) {
            $groups[] = intval(substr($num, $i, 3));
            $i = $i+3;
        }
        $hundredEleven = 111;
        $count = count($groups)-1;
        $boolean = true;
        for ($i=0; $i<$count; $i++) {
            if (($groups[$i]+$hundredEleven) != $groups[$i+1]) {
                $boolean = false;
                break;
            }
        }
        if ($boolean) {
            return true;
        }
        for ($i=0; $i<$count; $i++) {
            if (($groups[$i]-$hundredEleven) != $groups[$i+1]) {
                return false;
            }
        }
        return true; 
    }
    
    /**
     * 检测是否在设定的特殊账号中
     * @param integer $num
     * @return boolean true:在特殊账号中; false:不在
     */
    private function _checkSpecialNum($num) {
        $special = array(100000000,1000000000);
        if (in_array($num, $special)) {
            return true;
        } else {
            return false;
        }
    }
    
    /**
     * 注册用户
     * @param array $data
     * @return integer
     */
    public function register($data) {
        $accountNum = $this->getUnusedAccount();
        if ($accountNum < 1) {
            return 0;
        }
        $data['accountNumber'] = $accountNum;
        $entity = $this->getEntity('UserMember');
        $id =  $entity->add($data);
        if ($id > 0) {
            $this->modifyUsed($accountNum);
        }
        return $id;
    }
    
    /**
     * 获取一个未使用的数字账号
     * @return integer
     */
    public function getUnusedAccount() {
        $row = $this->slave->load('UserAccount', array('status'=>1));
        if ($row) {
            return (int) $row->accountNumber;
        } else {
            return 0;
        }
    }
    
    /**
     * 修改为已使用
     * @param integer $accountNumber
     * @return boolean
     */
    public function modifyUsed($accountNumber) {
        $data = array('status'=>0);
        $where = array('accountNumber'=>$accountNumber);
        return $this->master->update('UserAccount', $data, $where);
    }
    
    /**
     * 注册用户
     * @param array $data
     * @return integer
     */
    public function handAdd($data) {
        if (isset($data['number']) && is_numeric($data['number'])) {
            $data['number'] = (int) $data['number'];
            if ($data['number'] < 1) {
                $this->setError('数字账号不能小于1');
                return 0;
            }
        } else {
            $this->setError('数字账号不能为空，且必须为数字');
            return 0;
        }
        $row = $this->getUserByAccountNum($data['number']);
        if ($row) {
            $this->setError('已存在的数字账号');
            return 0;
        }
        // TODO 验证用户名和密码
        $d['accountNumber'] = $data['number'];
        $d['username'] = $data['username'];
        $d['password'] = md5($data['password']);
        $entity = $this->getEntity('UserMember');
        $id =  $entity->add($d);
        if ($id > 0) {// 修改为已使用
            $this->modifyUsed($data['number']);
        }
        return $id;
    }
    
    /**
     * 根据数字账号获取用户信息
     * @param integer $accountNumber
     * @param string $column
     * @return boolean | object 有数据返回对象，无数据返回false  
     */
    public function getUserByAccountNum($accountNumber, $column = '*') {
        $accountNumber = (int) $accountNumber;
        return $this->slave->load('UserMember', array('accountNumber'=>$accountNumber), $column);
    }
    
}
