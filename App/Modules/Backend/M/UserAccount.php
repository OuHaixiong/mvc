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
     * 测试PDO事务处理；未提交直接进行查询
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
    
    /**
     * 测试多重事务提交（特别注意了：事务是不允许嵌套的）
     */
    public function multipleTransactionCommit() {
        $pdo = $this->master->pdo;
        $pdo->beginTransaction();
        try {
            // 插入一条数据
            $data = array(
                'accountNumber' => 87654321,
                'status' => 1,
            );
            $entity = $this->getEntity('UserAccount');
            $number = $entity->add($data);
            var_dump('插入：' . $number);
            
            // 又开启一个事务
            try {
                $pdo->beginTransaction(); // 这里直接就抛异常了，事务是不允许嵌套的：There is already an active transaction
                $data = array(
                    'accountNumber' => 999999,
                    'status' => 0,
                );
                $entity = $this->getEntity('UserAccount');
                $number = $entity->add($data);
                var_dump('插入2：' . $number);
                if ($number < 1) {
                    throw new PDOException('无法插入数据', 100444);
                } else {
                    $pdo->commit();
                }
            } catch (Exception $e) { // 
                var_dump($e);
                $pdo->rollBack();
                print_r('内层事务抛异常了。。。');exit;
            }
            
            throw new Exception('主动抛异常，外层事务：不插入数据', 10002);
            $pdo->commit();
        } catch (PDOException $e) {
            var_dump('数据库异常');
            $pdo->rollBack();
        } catch (Exception $e) {
            var_dump($e->getCode() . ' : ' . $e->getMessage());
            $pdo->rollBack();
        }
        print_r('OK');
    } 
}
