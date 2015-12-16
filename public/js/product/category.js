$(document).ready(function () {	
    $('#categories').delegate('select', 'change', function (e) { // 使用.live()具备动态绑定功能，jQuery1.3 使用，jQuery1.7 之后废弃，jQuery1.9 删除
    	var $select = $(this);
    	var is_parent = $select.find('option:selected').data('is_parent');
    	var current_index = $select.index();
    	$('#categories select').each(function (index) { // 删除当前select之后的所有select
//    		console.log(index);
    		if (index > current_index) {
    			$(this).remove();
    		}
    	});
    	uncheckedProperty();
    	if (is_parent == '1') { // 是父级分类，需要加载子集分类
    		$('#category_id').val(0);
    		$.ajax({
    	        type     : 'POST',
    	        url      : '/category/findChildren',
    	        dataType : 'json',
    	        data     : {'parent_id':$select.val()},
    	        success  : show_children_select
    	    });
    	} else { // 非父级分类，需要把选中的值填入指定的位置
    		var category_id = $select.val();
    		$('#category_id').val(category_id);
    		// 如果不等于0，还需要从数据库把末级分类对应的所有属性id列出来 
    		if (category_id > 0) {
    			$.ajax({
    				type     : 'GET',
    				url      : '/category/getPropertyIds',
    				dataType : 'json',
    				data     : {'category_id':category_id},
    				success  : checkedProperty
    			});
    		}
    	}
//        console.log($select.index());
    });
    
    // 根据属性id，对所列的属性进行选中
    var checkedProperty = function (response) {
//        console.log(response);
        if (response.data.length > 0) {
        	$('#property input[name="property_id"]').each(function (index) {
//        	console.log($(this).val());
//        	console.log($.inArray($(this).val(), response.data));
                if ($.inArray($(this).val(), response.data) != -1) {
                	$(this)[0].checked = true; // 特别注意这里的写法，后面的这种不行attr('checked', 'checked');
                } 
        	});
        }
    };
    // 不选中属性
    var uncheckedProperty = function () {
    	$('#property input[name="property_id"]').each(function () {
    		$(this).attr('checked', false);
    	});
    };
    
    // 渲染子级分类
    var show_children_select = function (response) {
    	if (response.status) {
    		var selectHtml = ' <select><option data-is_parent="0" value="0">请选择分类</option>'; 
    		for(var i=0; i<response.data.length; i++) {
    			selectHtml += '<option data-is_parent="' + response.data[i].isParent + '" value="' + response.data[i].id + '">' + response.data[i].name + '</option>';
    		}
    		selectHtml += '</select> ';
    		$('#categories').append(selectHtml);  // 添加一项select
    	} else {
    		alert(response.message);
    	}
//    	console.log(response);
    };
    
    /*$('#submit_relation').click(function() {
        var categoryId = $('#category_id').val();
        if (categoryId < 1) {
        	alert('请选择分类');
        	return;
        }
        var propertyId = [];
        $('#property input[name="property_id"]:checked').each(function () {
            propertyId.push($(this).val());
        });
//        console.log(propertyId);
        if (propertyId.length < 1) {
        	alert('请选择属性');
        	return;
        }
        $.ajax({
	        type     : 'POST',
	        url      : window.location.href,
	        dataType : 'json',
	        data     : {'category_id':categoryId, 'property_id':propertyId},
	        success  : function (response) {
	        }
	    });
    });*/
    
    $('#property input[name="property_id"]').click(function () {
    	var categoryId = $('#category_id').val();
        if (categoryId < 1) {
        	// 多选框复原（选中状态恢复）
//        	console.log($(this));
        	if ($(this).is(':checked')) { // 已选中
        		$(this).attr('checked', false);
        	} else { // 未选中
        		$(this).attr('checked', true);
        	}
//        	$(this).attr("checked", !$(this).attr("checked"));
        	alert('请选择分类');
        	return;
        }
        $.ajax({
	        type     : 'POST',
	        url      : window.location.href,
	        dataType : 'json',
	        data     : {'category_id':categoryId, 'property_id':$(this).val(), 'is_checked':$(this).is(':checked')},
	        success  : function (response) {
//	        	console.log(response);
	        	if (response.status == 1) {
	        		if (response.data.status == 1) {
	        			alert('关联成功');
	        		} else {
	        			alert('取消关联成功');
	        		}
	        	} else {
	        		alert(response.message);
	        	}
	        }
	    });
    });
    
});
