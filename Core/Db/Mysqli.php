<?php

/**
 * 数据库操作类，封装了mysqli的一些函数; 数据库操作层（数据持久层）
 * TODO 多主键的考虑
 * @author Bear
 * @version 1.0.0
 * @copyright http://maimengmei.com
 * @created 2015-4-15 17:37
 * @example 
 */
class Db_Mysqli
{
    /**
     * 数据库连接资源 the database connection
     * @var mysqli
     * @access private
     */
    private $_link;
    
    /**
     * 最后一次操作数据库的sql语句
     * @var string
     */
    private $_sql;
    
    /**
     * 链接mysql数据库
     * @param string $host 主机
     * @param string $username 用户名
     * @param string $password 密码
     * @param string $database 数据库
     * @param string $charset 数据库编码
     * @throws Excetion
     */
    public function __construct($host = null, $username = null, $password = null, $database = null, $charset = 'utf8') {
        if (empty($host) && empty($username) && empty($password)) {
            $mysqliDb = CConfig::getConfig('mysqli_db');
            $host = $mysqliDb['host'];
            $username = $mysqliDb['username'];
            $password = $mysqliDb['password'];
            $database = $mysqliDb['database'];
            $charset = $mysqliDb['charset'];
        }

        $this->_link = new mysqli($host, $username, $password, $database);
        if ($this->_link->connect_error) {
            throw new Exception('Database connect Error(' . $this->_link->connect_errno . '):' . $this->_link->connect_error);
        }
        $this->_link->set_charset($charset); // $mysqli->character_set_name()
        //  $this->_link->query('set names utf8');  mysqli_query($this->_link, 'set names utf8');
        // $this->_link->host_info  // 127.0.0.1 via TCP/IP 
    }
    
    /**
     * query sql string 执行一条sql语句
     * @access public
     * @param string $sql
     * @param string $message 出错信息提示 Query failed message
     * @return mysqli_result
     */
    public function query($sql = null, $message = null) {
        if ($sql !== null) {
            $this->_sql = $sql;
        }

        $result = $this->_link->query($this->_sql) or die($message . $this->_link->error);
        return $result;
    }
    
    /**
     * mysqli_num_rows 返回结果集中的总行数
     * @access public
     * @param resource $result
     * @return integer
     */
    public function num($result) {
        return @mysqli_num_rows($result);
    }
    
    
    /**
     * 获取最后一次操作数据库的sql语句
     * @return string
     */
    public function getSql() {
        return $this->_sql;
    }
    
    /**
     * 获取最后一次操作数据库的sql语句
     * @return string
     */
    public function getLastSql() {
        return $this->_sql;
    }
    
    /**
     * 设置sql语句
     * @param string $sql
     */
    public function setSql($sql) {
        $this->_sql = $sql;
    }
    
    /**
     * 获取数据库连接资源
     * @return resource
     */
    public function getLink() {
        return $this->_link;
    }
    
    /**
     * 析构函数
     */
    public function __destruct() {
        if ($this->_link instanceof mysqli) {
            $this->_link->close();
        }
    }
}
  




//     /**
//      * mysqli_fetch_array
//      * @access public
//      * @param resource $result
//      * @return array
//      */
//     public function fetchArray($result) {
//         return @mysqli_fetch_array($result);
//     }

//     /**
//      * mysqli_insert_id
//      * @access public
//      * @param resource $result
//      * @return integer
//      */
//     public function lastId() {
//         return @mysqli_insert_id($this->_link);
//     }

//     /**
//      * 获取mysql前一次操作（select，delete）所影响的行数
//      * mysqli_affected_rows
//      * @return integer
//      */
//     public function affectedRows() {
//         return mysqli_affected_rows($this->_link);
//     }

//     /**
//      * close the datebase connection
//      * @access public
//      * @return null
//      */
//     public function close() {
//         @mysqli_close($this->_link);
//         //		unset(self::$_instance); // 特别注意了：unset 是能够释放静态变量的（将销毁此变量及其所有的引用），但在这里貌似这样用是错误的，因为对象本身不能释放本身
//         self::$_instance = null;
//     }

//     /**
//      * fetch once result from the specific sql query
//      * 获取一行数据
//      * @access public
//      * @param string $sql
//      * @param string $message
//      * @return array | null 一维数组或null
//      */
//     public function fetchArrayOnce($sql = null, $message = null) {
//         if ($sql !== null) {
//             $this->_sql = $sql;
//         }
//         $result = $this->query($this->_sql, $message);
//         $row = $this->fetchArray($result);//return mysqli_fetch_assoc($result);// yes return mysqli_fetch_object($result); // yes
//         return $row;
//     }

//     /**
//      * fetch all result from the specific sql query
//      * @access public
//      * @param string $sql
//      * @param string $message
//      * @return array
//      */
//     public function fetchArrayMore($sql = null, $message=null) {
//         if ($sql !== null) {
//             $this->_sql = $sql;
//         }
//         $result = $this->query($this->_sql, $message);
//         $moreRow = array();
//         while (($row = $this->fetchArray($result)) == true) {
//             $moreRow[] = $row;
//         }
//         return $moreRow;
//     }

//     /**
//      * fetch the number of results from the specific sql query  返回sql语句的总行数
//      * @access public
//      * @param string $sql
//      * @param string $message
//      * @return integer
//      */
//     public function fetchNum($sql = null, $message = null) {
//         if ($sql !== null) {
//             $this->_sql = $sql;
//         }
//         $result = $this->query($this->_sql, $message);
//         return $this->num($result);
//     }

//     /**
//      * mysqli_prepare 获取sql语句信息
//      * @access public
//      * @param string $sql
//      * @return object mysqli_stmt
//      */
//     public function prepare($sql = null) {
//         if ($sql !== null) {
//             $this->_sql = $sql;
//         }
//         return @mysqli_prepare($this->_link, $this->_sql);
//     }

//     /**
//      * mysqli_stmt_execute
//      * @access public
//      * @param object $stmt
//      * @param string $message
//      * @return boolean
//      */
//     public function stmtExecute($stmt, $message = null) {
//         @mysqli_stmt_execute($stmt) or die($message . mysqli_error($this->_link));
//     }



//     /**
//      * 选择数据库（换个数据库）
//      * @param string $databaseName 新的数据库名,如果为null就是说恢复默认选择的数据库
//      */
//     public function setDatabase($databaseName = null) {
//         if ($databaseName === null) {
//             $databaseName = self::__DATABASE__;
//         }
//         mysqli_select_db($this->_link, $databaseName);
//     }


