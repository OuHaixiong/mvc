<br /><br /><br />
<div>
 <form id="product_info" action="#" method="post" enctype="multipart/form-data">
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
  <div>
  产品属性：
   <div id="show_property">
     
   </div>
  </div>
  <div>
  产品标题： <input name="name" id="name" type="text" value="" />
  </div>
  <div>
  产品价格： <input name="price" id="price" type="text" value="" />
  </div>
  <div>
  产品描述：<textarea id="description" name="description" rows="5" cols="50"></textarea>
  </div>
  
  <input id="category_id" name="category_id" type="hidden" value="0" />
  <div><input id="submit_save" type="submit" value="确定提交" /></div>
 </form>
</div>
<script type="text/javascript" src="<?php echo STATIC_URL; ?>/js/product/product_save.js"></script>