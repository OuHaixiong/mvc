<?php

/**
 * 测试用户账户类
 * @author Bear
 * @copyright http://maimengmei.com
 * @varsion 1.0.0
 * @created 2019-02-28
 */
class Backend_M_UserAccount extends BModel
{
    /**
     * 测试PDO事务处理
     * @throws Exception
     */
    public function testTransaction() {
        $master = $this->master;
        $pdo = $master->pdo;
//         $pdo->beginTransaction(); // 开启事务处理
//         try {
//             $row = $this->getEntity('UserAccount');
//             $data = array(
//                 'accountNumber' => 8888,
//                 'status' => 0,
//             );
//             $id = $row->add($data);
//             if ($id < 1) {
//                 throw new PDOException('insert fail', 400550);
//             }
//             $pdo->commit(); // 提交事务
//         } catch (PDOException $e) {
//             $pdo->rollBack(); // 事务回滚
//         }
//         var_dump($id);
        
        $pdo->beginTransaction();
        $entity = $this->getEntity('userAccount');
        try {
            $row = $entity->load(1);
            print_r($row);
            $data = array('accountNumber'=>$row->accountNumber+1);
            $boolean = $entity->modify($data, 1);
            var_dump($boolean);
            $row2 = $entity->load(1);
            print_r($row2); // 修改数据后，事务还没有提交前进行查询，并不会返回修改后的数据，返回的是之前的数据
            throw new Exception('主动抛错误', 1000001);
            $pdo->commit();
            
        } catch (Exception $e) {
            $pdo->rollBack();
        }
        $row3 = $entity->load(1);
        print_r($row3);

    }
}
