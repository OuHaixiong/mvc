<?php

/**
 * 世界实体类
 * @author Bear
 * @version 1.0.0
 * @copyright http://maimengmei.com
 * @property PDO $pdo pdo对象
 * @created 2015-5-7 11:37
 * @example
 */
class Backend_M_Row_World extends Db_Entity
{
    protected $tableName = 'tb_world';
    protected $primaryKey = 'id';
}
