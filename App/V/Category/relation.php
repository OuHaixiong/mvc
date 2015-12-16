<br /><br /><br />
<div id="category_relation_property">
 <form action="#" method="post" enctype="multipart/form-data">
  <div id="categories">
     分类：
     <select>
     <?php 
      $optionHtml = '<option data-is_parent="0" value="0">请选择分类</option>';
      foreach ($this->rootCategory as $k=>$v) {
          $optionHtml .= '<option data-is_parent="' . $v->isParent . '" value="' . $v->id . '">' . $v->name . '</option>'; 
      }
      echo $optionHtml;
     ?>
     </select>
  </div>
  <div id="property">
     选择属性：
     <?php 
     $propertyHtml = '';

     if (is_array($this->propertyResult)) {
         foreach ($this->propertyResult['rowset'] as $k=>$row) {
             $propertyHtml .= '<div>
                 <input type="checkbox" name="property_id" value="' . $row->id . '" /> ' . $row->name . ' <br />
                 &nbsp;&nbsp;&nbsp;&nbsp; 属性值： ';
             $row->value = unserialize($row->value);
             foreach ($row->value as $key=>$value) {
                 $propertyHtml .= $key . '=>' . $value . '&nbsp; &nbsp;';
             }
             $propertyHtml .= '<br />';
             $propertyHtml .= '&nbsp;&nbsp;&nbsp;&nbsp; 备注： ' . $row->remark;
             $propertyHtml .= '</div>';
         }    
     }
     echo $propertyHtml;
     ?>
  </div>
  <input id="category_id" type="hidden" value="0" />
  <!-- <div><input id="submit_relation" type="button" value="确定关联" /></div> -->
 </form>
</div>
<script type="text/javascript" src="<?php echo STATIC_URL; ?>/js/product/category.js"></script>