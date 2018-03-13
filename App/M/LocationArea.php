<?php

/**
 * 地区类
 * @author Bear
 * @version 1.0.0
 * @copyright http://maimengmei.com
 * @created 2018-3-13 10:59
 */
class M_LocationArea extends BModel
{
    const ENTITY_NAME_ZHCNLOCATIONAREA = 'ZhCNLocationArea';
    const ENTITY_NAME_ENUSLOCATIONAREA = 'EnUSLocationArea';
    
    /**
     * xml文件转database
     * @return boolean
     */
    public function loadFileToDatabaseForZhCn() {
        $filePath = ROOT_PATH . '/../data/locationListChinese.xml';
        $xmlString = file_get_contents($filePath);
        $xmlObj = new SimpleXMLElement($xmlString);
        
        $entity = $this->getEntity(self::ENTITY_NAME_ZHCNLOCATIONAREA);

        foreach ($xmlObj->CountryRegion as $v) {
            $nowTime = date('Y-m-d H:i:s');
            $attributes = $v->attributes();
            $data = array();
            $data['name'] = $attributes['Name'];
            $data['code'] = $attributes['Code'];
            $data['createdTime'] = $nowTime;
            $countryId = $entity->add($data);
            if ($countryId) {
                $boolean = property_exists($v, 'State');
                if ($boolean) {
                    foreach ($v->State as $state) {
                        $attributes = $state->attributes();
                        $data = array();
                        $data['name'] = trim($attributes['Name']);
                        $data['code'] = $attributes['Code'];
                        $data['createdTime'] = $nowTime;
                        $data['parentId'] = $countryId;
                        if (strlen($data['name']) > 0) {
                            $stateId = $entity->add($data);
                        } else {
                            $stateId = $countryId;
                        }
                        if ($stateId) {
                            $boolean = property_exists($state, 'City');
                            if ($boolean) {
                                foreach ($state->City as $city) {
                                    $attributes = $city->attributes();
                                    $data = array();
                                    $data['name'] = $attributes['Name'];
                                    $data['code'] = $attributes['Code'];
                                    $data['createdTime'] = $nowTime;
                                    $data['parentId'] = $stateId;
                                    $cityId = $entity->add($data);
                                }
                            }
                        } else {
                            var_dump($state);
                            die('插入州/省数据出错了');
                        }
                    }
                }
            } else {
                var_dump($v);
                die('插入数据出错了');
            }
        }
        return true;
    }
    
    /**
     * xml文件转database（英文）
     * @return boolean
     */
    public function loadFileToDatabaseForEnUs() {
        $filePath = ROOT_PATH . '/../data/locationListEnglish.xml';
        $xmlString = file_get_contents($filePath);
        $xmlObj = new SimpleXMLElement($xmlString);
    
        $entity = $this->getEntity(self::ENTITY_NAME_ENUSLOCATIONAREA);
    
        foreach ($xmlObj->CountryRegion as $v) {
            $nowTime = date('Y-m-d H:i:s');
            $attributes = $v->attributes();
            $data = array();
            $data['name'] = $attributes['Name'];
            $data['code'] = $attributes['Code'];
            $data['createdTime'] = $nowTime;
            $countryId = $entity->add($data);
            if ($countryId) {
                $boolean = property_exists($v, 'State');
                if ($boolean) {
                    foreach ($v->State as $state) {
                        $attributes = $state->attributes();
                        $data = array();
                        $data['name'] = trim($attributes['Name']);
                        $data['code'] = $attributes['Code'];
                        $data['createdTime'] = $nowTime;
                        $data['parentId'] = $countryId;
                        if (strlen($data['name']) > 0) {
                            $stateId = $entity->add($data);
                        } else {
                            $stateId = $countryId;
                        }
                        if ($stateId) {
                            $boolean = property_exists($state, 'City');
                            if ($boolean) {
                                foreach ($state->City as $city) {
                                    $attributes = $city->attributes();
                                    $data = array();
                                    $data['name'] = $attributes['Name'];
                                    $data['code'] = $attributes['Code'];
                                    $data['createdTime'] = $nowTime;
                                    $data['parentId'] = $stateId;
                                    $cityId = $entity->add($data);
                                }
                            }
                        } else {
                            var_dump($state);
                            die('插入州/省数据出错了');
                        }
                    }
                }
            } else {
                var_dump($v);
                die('插入数据出错了');
            }
        }
        return true;
    }
    
    
}
