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
    		// 如果不等于0，还需要从数据库把末级分类对应的所有属性列出来 
    		if (category_id > 0) {
//    			$.ajax({
//    				type     : 'GET',
//    				url      : '/category/getPropertyIds',
//    				dataType : 'json',
//    				data     : {'category_id':category_id},
//    				success  : checkedProperty
//    			});
    		}
    	}
//        console.log($select.index());
    });
    


    
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
    // 
    $('#submit_save').click(function (e) {
        e.preventDefault();
        
        var name = $('#name').val();
        var description = $('#description').val();
        var price = $('#price').val();
        var category_id = $('#category_id').val();
     // TODO 验证通过
        
        $.ajax({
			type     : 'POST',
			url      : window.location.href,
			dataType : 'json',
			data     : {'category_id':category_id, 'name':name, 'description':description, 'price':price},
			success  : function (response) {
				alert(response.message);
			}
		});
    });
    
});
