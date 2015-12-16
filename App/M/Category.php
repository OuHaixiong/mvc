<?php

/**
 * 分类业务模块
 * @author Bear
 * @version 1.0.0
 * @copyright http://maimengmei.com
 * @created 2015-11-30 17:37
 */
class M_Category extends BModel
{
    /**
     * 保存一个分类
     * @param array $data 分类数据
     * @param integer $id 分类id
     * @return boolean true:保存成功; false:保存失败
     */
    public function save($data, $id = null) {
        $categoryEntity = $this->getEntity('category');
        if (empty($id)) { // 新增分类
            // TODO 验证数据
            $d = array();
            $d['name'] = $data['name'];
            $isUpdateParent = false;
            if (isset($data['parentId'])) {
                $d['parentId'] = $data['parentId'];
                $isUpdateParent = true;
            }
            $d['createdTime'] = date('Y-m-d H:i:s');
            $id = $categoryEntity->add($d);
            if ($id > 0) {
                if ($isUpdateParent) { // 修改父类分类为是父级分类
                    $categoryEntity->modify(array('isParent'=>1), $d['parentId']);
                }
                return true;
            } else {
                $this->setError('新增分类失败！');
                return false;
            }
        } else { // 修改分类
            $id = (int) $id;
            $row = $categoryEntity->load($id);
            if (!$row) {
                $this->setError('不存在的分类！');
                return false;
            }
            // TODO 验证数据
            $boolean = $categoryEntity->modify($data, $id);
            if (!$boolean) {
                $this->setError('修改失败！');
                return false;
            }
            return $boolean;
        }
    }
    
    /**
     * 获取所有的根级分类
     * @return array
     */
    public function root() {
        $entity = $this->getEntity('category');
        $slave = $this->getSlave();
        $where = array('parentId'=>0);
        $result = $slave->select($entity->tableName, $where, null, null, 'sort', 'asc');
        return $result['rowset'];
    }
    
    /**
     * 通过父级分类的id查找所有的子级分类
     * @param integer $parentId
     * @return array
     */
    public function findChildren($parentId) {
        $entity = $this->getEntity('category');
        $slave = $this->getSlave();
        $where = array('parentId'=>$parentId);
        $result = $slave->select($entity->tableName, $where, null, null, 'sort', 'asc');
        return $result['rowset'];
    }
    
    // 添加子分类，需要把父级分类所关联的所有属性删除掉（或不删也可以，貌似不受影响）
    // 删除子分类（末级分类），需要把此分类所关联的所有属性删除掉（或不删也可以，貌似不受影响）
    
}
