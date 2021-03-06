<?php

/**
 * 测试数据库操作
 * @author Bear
 *
 */
class Backend_C_Db extends Backend_C_Controller
{
    public function init() {}
    
    /**
     * 查询
     */
    public function load() {
        $primaryKey = 2;
        $backendUser = new Backend_M_User();
        $row = $backendUser->getDefaultRow()->load($primaryKey, '`id`,`username`,`password`,`realname`,`email`');
        Common_Tool::prePrint($row);
    }

    /**
     * 增加
     */
    public function add() {
        $data = array();
        $data['username'] = 'bearddd';
        $data['password'] = '12345dsfs6';
        $data['realname'] = '欧海雄';
        $data['group_id'] = 1;
        $data['email'] = '258333309@qq.com';
        $data['mobile'] = '15019261350';
        $data['telephone'] = '';
        $data['create_time'] = time();
        $backendUser = new Backend_M_User();
        $insertId = $backendUser->getDefaultRow()->add($data);
        Common_Tool::prePrint($insertId);
    }

    /**
     * 删除
     */
    public function del() {
        $id = 2;
        $backendUser = new Backend_M_User();
        $num = $backendUser->getDefaultRow()->del($id);
        Common_Tool::prePrint($num);
    }
    
    /**
     * 修改
     */
    public function modify() {
        $id = $this->getParam('id', 0);
        $data = array(
            'username' => 'Bear1',
            'realname' => '欧阳海雄1',
            'mobile' => '1501926135',
            'telephone' => '0755-999',
            'create_time' => time()
        );
        $backendUser = new Backend_M_User();
        $boolean = $backendUser->getDefaultRow()->modify($data, $id);
        Common_Tool::prePrint($boolean);
    }
    
    /**
     * 批量增加
     */
    public function batchAdd() {
        $datas = array(
            array(
                'username' => 'Bear1',
                'password' => 'dd',
                'realname' => '欧阳海雄1',
                'group_id' => 1,
                'email' => '258333309@maimeng.com',
                'mobile' => '150000000',
                'telephone' => '0755-9dddd99',
                'create_time' => time()
            ),
            array(
                'username' => 'bb',
                'password' => 'bbbbbbb',
//                 'realname' => 'bbbbbbb',
                'group_id' => 1,
                'email' => 'bb@maimeng.com',
                'mobile' => '15bbbbbb',
                'telephone' => '0755-bbbb',
                'create_time' => time()
            )
        );
        $backendUser = new Backend_M_User();
        $boolean = $backendUser->getDefaultRow()->batchAdd($datas);
        Common_Tool::prePrint($boolean);
    }
    
    /**
     * 批量删除
     */
    public function batchDel() {
        $ids = $this->getParam('ids', array(16,17,18,19,20,21,22,23));
        $backendUser = new Backend_M_User();
        $boolean = $backendUser->getDefaultRow()->batchDel($ids);
        Common_Tool::prePrint($boolean);
    }
    
    /**
     * 批量查询
     */
    public function batchLoad() {
        $ids = array(7,8,9,20);
        $column = '*';
        $column = '`id`,`username`,`realname`,`create_time`';
        $backendUser = new Backend_M_User();
        $rowset = $backendUser->getDefaultRow()->batchLoad($ids, $column);
        Common_Tool::prePrint($rowset, false);
        Common_Tool::prePrint($backendUser->pdo->info());
    }
    
    /**
     * 插入
     */
    public function insert() {
        $data = array();
        $data['world_name'] = '第六世界';
        $data['world_id'] = '12';
        $data['builds_to_one_world'] = 5;
        $entity = new Backend_M_Row_World();
        $insertId = $entity->add($data);
        Common_Tool::prePrint($insertId, false);
        Common_Tool::prePrint($entity->master->getError());
    }
    
    /**
     * 删除
     */
    public function delete() {
        $id = 11;
        $entity = new Backend_M_Row_World();
        $number = $entity->del($id);
        Common_Tool::prePrint($number);
    }
    
    /**
     * 更新
     */
    public function update() {
       $id = '12';
       $data = array('world_name'=>'六感肉', 'builds_to_one_world'=>'1');
       $entity = new Backend_M_Row_World();
       $boolean = $entity->modify($data, $id);
       Common_Tool::prePrint($boolean);
    }
    
    /**
     * 查询
     */
    public function select() {
        $id = 5;
        $entity = new Backend_M_Row_World();
        $row = $entity->load($id, '`world_id`,`world_name`');
        Common_Tool::prePrint($row, false);
        Common_Tool::prePrint($slave, false);
        
        $id = '12';
        $row = $entity->loadByMaster($id);
        Common_Tool::prePrint($row, false);
        Common_Tool::prePrint($entity->master);
    }
    
    /**
     * 测试从库删除
     */
    public function slaveDelete() {
        $id = 12;
        $slave = new Db_Slave();
        $pdo = $slave->pdo;
        Common_Tool::prePrint($pdo, false);
        $sql = "DELETE FROM `tb_world` WHERE `id`={$id}";
        $num = $pdo->exec($sql); // 此处返回false（因为出错了），如果没有出错：返回受修改或删除 SQL 语句影响的行数(integer)
        Common_Tool::prePrint($num, false);
        Common_Tool::prePrint($pdo->errorInfo()); // 0:sql状态错误码; 1:pdo_mysql错误码; 2：pdo_mysql错误信息
    }
    
    /**
     * 批量插入
     */
    public function batchInsert() {
        $d1 = array();
        $d1['world_name'] = '第六';
        $d1['world_id'] = '22';
        $d1['builds_to_one_world'] = 25;
        
        $data = array(
            array(
                'world_name' => 'i日内',
                'world_id' => '18',
                'builds_to_one_world' => '22',
            ),
            array(
                'world_name' => '第三栋',
                'world_id' => '17',
                'builds_to_one_world' => '3',
            ),
            $d1
        );
        
        $entity = new Backend_M_Row_World();
        $boolean = $entity->batchAdd($data);
        Common_Tool::prePrint($boolean, false);
        Common_Tool::prePrint($entity->master->getError());
    }
    
    /**
     * 批量删除
     */
    public function batchDelete() {
        $primaryKeys = array(26,27,28,12,24,25);
        $entity = new Backend_M_Row_World();
        $num = $entity->batchDel($primaryKeys);
        Common_Tool::prePrint($num);
    }
    
    /**
     * 批量更新
     */
    public function batchUpdate() {
        $primaryKeys = array(12, 24, 13, 25);
        $data = array('world_name'=>'第六感');
        $entity = new Backend_M_Row_World();
        $boolean = $entity->batchModify($data, $primaryKeys);
        Common_Tool::prePrint($boolean);
    }
    
    /**
     * 批量查询
     */
    public function batchSelect() {
        $tableName = 'tb_world';
        $column = '`id`,`world_name`,`world_id`';
        $entity = new Backend_M_Row_World();
        $result = $entity->slave->select($tableName, null, null, null, null, null, $column);
        Common_Tool::prePrint($result, false);

        $primaryKeys = array(12, 24, 13, 25, 1, 2, 3);
        $rowset = $entity->batchLoad($primaryKeys, $column);
        Common_Tool::prePrint($rowset);
    }
    
    /**
     * 主从同步测试
     */
    public function masterSlave() {
        // 主写，主读
        $backendUser = new Backend_M_User();
        $masterDb = $backendUser->getMaster();
        $tableName = 't';
        $data = array('a'=>88, 'b'=>88);
        $id = $masterDb->insert($tableName, $data);
        if ($id > 0) {
            $where = array('id'=>$id);
//             $row = $masterDb->load($tableName, $where);
//             Common_Tool::prePrint($row, false);
        } else {
            die('插入数据失败');
        }
        // 主写，从读
        $slaveDb = $backendUser->getSlave();
        $row = $slaveDb->load($tableName, $where);
        Common_Tool::prePrint($row, false);
        // 主写，从删
        $data = array('a'=>99, 'b'=>99);
        $id2 = $masterDb->insert($tableName, $data);
        $pdo = $slaveDb->getPdo();
        $where = array('id'=>$id2);
        
        if (is_array($where)) {
            if (empty($where)) {
                return 0;
            } else {
                foreach ($where as $k=>$v) {
                    $where[$k] = "`{$k}`={$pdo->quote($v)}";
                }
                $where = implode(' AND ', $where);
            }
        }
        $sql = "DELETE FROM `{$tableName}` WHERE {$where}";
        Common_Tool::prePrint($sql);
        var_dump($pdo->exec($sql)); // 这里执行失败了，不返回任何值，连null都没有
        // 从局域网的测试来看，没有看到延迟的现象，也就是说，插入进去了就能直接读取出来
    }
    
    /**
     * postgreSql 原生操作
     */
    public function pgSql() {
        $host = '172.17.6.140';
        $port = '5432';
        $dbName = 'ybapi';
        $user = 'ybapi';
        $password = '123456';
        $db = pg_connect("host=$host port=$port dbname=$dbName user=$user password=$password");
        if (!$db) {
            die("Error:Unable to open PostgreSql database\n");
        }

        $sql = <<<EOF
        select * from product LIMIT 10 OFFSET 0;
EOF;
        $result = pg_query($db, $sql);
        if (!$result) {
            die("Query error". pg_last_error($db));
        }
        $rowset = pg_fetch_all($result);
        $html = '';
        foreach ($rowset as $row) {
            $html .= "id=>{$row['id']} name={$row['title']} info={$row['info']} <br />";
        }
        echo $html;
        pg_close($db);
    }
    
    /**
     * PostgreSQL PDO 操作 
     */
    public function pgPdo() {
        $dbName = 'ybapi';
        $host = '172.17.6.140';
        $port = '5432';
        $user = 'ybapi';
        $password = '123456';
        $pdo = new PDO("pgsql:dbname={$dbName};host={$host};port={$port}", $user, $password);
        $statement = $pdo->prepare('select * from product LIMIT 10 OFFSET 0');
        if (!$statement) {
            die($statement->errorInfo());
        }
//         $statement->bindParam(":id",$id);
        $statement->execute();
        $rowset = $statement->fetchAll();
        $html = '';
        foreach ($rowset as $row) {
            $html .= "id=>{$row['id']} name={$row['title']} info={$row['info']} <br />";
        }
        echo $html;
    }
    
    /**
     * 测试事务
     */
    public function transaction() {
//         $userAccount = new Backend_M_UserAccount();
//         $userAccount->testTransaction();
        $userAccount = new Backend_M_UserAccount();
        $userAccount->multipleTransactionCommit();
    }

}
