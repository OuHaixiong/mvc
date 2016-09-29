
<div><a href="javascript:;" id="click_dialog">点击这里弹框</a></div>

<div id="dialog1" style="width: 560px;display:none;background-color:#F00;position:absolute;">
  <p>这里是弹出层</p>
  <p>我的宽度是560px</p>
  <div id="close_dialog" style="position:absolute;right:0px;top:0px;">X</div>
</div>

<script type="text/javascript" src="<?php echo STATIC_URL; ?>/js/base/popup_dialog.js"></script>
<script type="text/javascript">
var popupDialog = new popupDialog('dialog1', '0.3');
$('#click_dialog').click(function () {
	popupDialog.show();
});
$('#close_dialog').click(function () {
	popupDialog.close();
});
</script>