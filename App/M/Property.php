<?php

/**
 * 属性业务模块
 * 产品的普通属性，销售属性不在此
 * @author Bear
 * @version 2.0.0
 * @copyright http://maimengmei.com
 * @created 2015-12-01 10:37
 */
class M_Property extends BModel
{
    /**
     * 保存一个属性
     * @param array $data 属性数据
     * @param integer $id 属性id
     * @return boolean true:保存成功; false:保存失败
     */
    public function save($data, $id = null) {
        $entity = $this->getEntity('property');
        if (empty($id)) { // 新增属性
            // TODO 验证数据
            $d = array();
            $d['name'] = $data['name']; // 属性名称
            $d['value'] = serialize($data['value']); // 属性值 . 数组序列化进去，出来时需要反序列化：unserialize
            $d['remark'] = $data['remark']; // 备注
            $d['createdTime'] = date('Y-m-d H:i:s');
            $id = $entity->add($d);
            if ($id > 0) {
                return true;
            } else {
                $this->setError('新增属性失败！');
                return false;
            }
        } else { // 修改属性
            $id = (int) $id;
            $row = $entity->load($id);
            if (!$row) {
                $this->setError('不存在的属性！');
                return false;
            }
            // TODO 验证数据
            $boolean = $entity->modify($data, $id);
            if (!$boolean) {
                $this->setError('修改失败！');
                return false;
            }
            return $boolean;
        }
    }
}
