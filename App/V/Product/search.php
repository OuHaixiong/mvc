<br /><br /><br />
<div>
 <form id="" action="#" method="get">
  <div>
  关键词： <input name="keyword" id="name" type="text" value="<?php echo $this->keyword; ?>" /> <input id="" type="submit" value="搜索" />
  </div>
 </form>
 
 <?php 
 $keywordHtml = '';
 if (isset($this->keyword) && !empty($this->keyword)) {
     $keywordHtml .= '<div>';
     $keywordHtml .= '搜索和“' . $this->keyword . '”相关的结果：';
     $keywordHtml .= '</div>';
 }
 echo $keywordHtml;
 ?>
 
 <?php if (isset($this->properties) && !empty($this->properties)) { ?>
 <div>
  结果筛选：
 </div>
 <div id="properties">
 <?php
 $propertiesHtml = '';
 $fieldName = BConfig::getFieldName($this->propertyEntity->tableName, 'name');
 $fieldValue = BConfig::getFieldName($this->propertyEntity->tableName, 'value');
 $fieldId = BConfig::getFieldName('id');
 $route = '/' . BApp::getModule() . '/' . BApp::getController() . '/' . BApp::getAction();
 
 foreach ($this->properties as $property) {
     $propertyParamsKey = 'properties[' . $property->$fieldId . ']';
     $parameter = $this->params;
     unset($parameter['properties'][$property->$fieldId]);
     $propertiesHtml .= '<div data-value="">&nbsp;&nbsp;&nbsp;&nbsp; 
  ' . $property->$fieldName . '： &nbsp;&nbsp;&nbsp; 
   <a href="' . $this->createUrl($route, $parameter) . '">全部</a> &nbsp;&nbsp;&nbsp; ';
     foreach ($property->$fieldValue as $key=>$value) {
         $parameter = $this->params;
         $parameter['properties'][$property->$fieldId] = $key;
         $propertiesHtml .= '<a href="' . $this->createUrl($route, $parameter) . '">' . $value . '</a> &nbsp;&nbsp;&nbsp; ';
     }
     $propertiesHtml .= '</div>';
 }
 echo $propertiesHtml;
 ?>
 </div>
 <?php } ?>
 
 <p>&nbsp;</p>
 
 <div id="list_product">
 <?php 
 if (isset($this->productResult['sum']) && ($this->productResult['sum'] > 0)) {
     $listProductHtml = '';
     $fieldName = BConfig::getFieldName($this->productEntity->tableName, 'name');
     $fieldPrice = BConfig::getFieldName($this->productEntity->tableName, 'price');
     $fieldDescription = BConfig::getFieldName($this->productEntity->tableName, 'description');
     
     $fieldId = BConfig::getFieldName('id');
     foreach ($this->productResult['rowset'] as $row) {
         $listProductHtml .= '<p class="list_row">
  <div>ID:' . $row->$fieldId . ' &nbsp; ' . $row->$fieldName . '  价格：￥' . $row->$fieldPrice . '</div>
  <div>产品描述：' . $row->$fieldDescription . '</div>
  <div>
      产品属性：<br />';
         if (empty($row->properties)) {
             $listProductHtml .= '&nbsp;&nbsp;&nbsp;&nbsp; 无任何产品属性<br />';
         } else {
             foreach ($row->properties as $v) {
                  $listProductHtml .= '&nbsp;&nbsp;&nbsp;&nbsp; ' . $v->propertyName . '：' . $v->valueName . '<br />';
  
             }
         }
         $listProductHtml .= '</div></p>';
     }
     echo $listProductHtml;
 }
 ?>
 </div>
 
</div>