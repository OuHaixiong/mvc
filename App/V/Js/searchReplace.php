<script language="JavaScript">
var oldStr;
var newStr;
function searchText(str){
  // 创建TextRange对象,指定为整个body区域
  var myText = document.body.createTextRange();
  if(myText.findText(str)){
    myText.select();
    // 如果找到目标文本,则将其选中
  }else{
    alert("没有找到匹配的字符!");
  }
}
function getTheText(){
  oldStr = prompt("输入要查找的内容","");
  // 获取用户要查找的内容
  if(oldStr!=null){
  // 如果内容不为空,则执行查找
    searchText(oldStr);
  }
}
function replaceText(){
  if(oldStr==null){
    alert("请先进行查找要替换的内容!");
  }else{
    newStr = prompt("替换为","");
    if(newStr!=null){
    // 新文本内容不为空,则替换选中的文本
      var selectText = document.selection.createRange();
      // 选中的文本
      selectText.text = newStr;
      // 替换选中的文本为新文本
    }else{
      alert("请输入替换的内容!");
    }
  }
}
</script>

<input type="button" value="查找" onclick="getTheText()">
<input type="button" value="替换" onclick="replaceText()">
<pre id="pre">
石壕吏
 
暮投石壕村，有吏夜捉人。
老翁逾墙走，老妇出门看。
吏呼一何怒！妇啼一何苦！
听妇前致词：三男邺城戍（shù）。
一男附书至，二男新战死。
存者且偷生，死者长已矣！
室中更无人，惟有乳下孙。
有孙母未去，出入无完裙。
老妪力虽衰，请从吏夜归。
急应河阳役，犹得备晨炊。
夜久语声绝，如闻泣幽咽（yè）。
天明登前途，独与老翁别。
</pre>