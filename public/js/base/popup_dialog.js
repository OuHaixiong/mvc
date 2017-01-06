
/**
 * 弹窗类
 * @author Bear
 * @created 2016-09-29
 * 
 */
function popupDialog(id, opacity) {
	// TODO 加入ajax请求一个url，获取内容后进行弹窗
	// TODO 是否需要加入弹框的宽度和高度控制
	// TODO 是否根据滚动条的运动而运动（永久居于屏幕中心）
    this.opacity = opacity || '0.5'; // 遮罩层的透明度
    this.id = id; // 需要弹窗的块id
    
    /**
     * 显示弹窗
     */
    popupDialog.prototype.show = function () {
        var maskDiv = document.createElement('div');  // 创建遮罩层
        maskDiv.setAttribute('id', 'popup_mask_gray'); // 添加id属性：popup_mask_gray
        // 添加css样式
        maskDiv.style.position = 'fixed';
        maskDiv.style.left = '0';
        maskDiv.style.top = '0';
        maskDiv.style.width = '100%';
        maskDiv.style.height = '100%';
        maskDiv.style.opacity = this.opacity;
        maskDiv.style.zIndex = 8888;
        maskDiv.style.backgroundColor = '#000';
        document.body.appendChild(maskDiv);
        
        var popupLayer = document.getElementById(this.id);
        popupLayer.style.zIndex = '9999';
        popupLayer.style.position = 'absolute';
        var scrollTop = window.pageYOffset || document.documentElement.scrollTop || document.body.scrollTop; // 获取当前窗口距离页面顶部高度
        var windowWidth = 1024; // 获取当前窗口的宽度
        if (window.innerWidth) {
            windowWidth = window.innerWidth;
        } else if ((document.body) && (document.body.clientWidth)) {
            windowWidth = document.body.clientWidth;
        }
        var windowHeight = 768; // 获取当前窗口的高度
        if (window.innerHeight) {
        	windowHeight = window.innerHeight;
        } else if ((document.body) && (document.body.clientHeight)) {
        	windowHeight = docuemnt.body.clientHeight;
        }
        popupLayer.style.display = 'block';
        var popupLayerHeight = popupLayer.offsetHeight; // 弹窗层的高度
        var top = 0;
        if (popupLayerHeight > windowHeight) {
            top = scrollTop;
        } else {
        	top = scrollTop+(windowHeight-popupLayerHeight)/2;
        }
        var left = (windowWidth-popupLayer.offsetWidth)/2;
        popupLayer.style.left = left + 'px';
        popupLayer.style.top = top + 'px';  
    };
    
    /**
     * 关闭弹窗
     */
    popupDialog.prototype.close = function () {
        var maskDiv = document.getElementById('popup_mask_gray');
        maskDiv.parentNode.removeChild(maskDiv);
        var popupLayer = document.getElementById(this.id);
        popupLayer.style.display = 'none';
    };
    
}

//(function () {
//	alert('OK'); // 这里是会运行的（会弹框）
//	var ab = function() {alert('dsad');};
//})(); // 这就是一个闭包的写法。闭包说白了就是一个对象，一个闭包说白了是调用了一次的一个函数

// 下面是闭包的第一种写法（最基础的）：
/* function Circle(r) {
    this.r = r;
}
Circle.PI = 3.14159;
Circle.prototype.area = function () {
    return Circle.PI * this.r * this.r;
};

var c = new Circle(1.0);
//alert(c.area); // 这里返回的是函数本身
alert(c.area()); // 这里返回的才是数据 */

//下面是闭包的第二种写法：
/* var Circle = function () {
	var obj = new Object();
	obj.PI = 3.14159;
	obj.area = function (r) {
		return this.PI*r*r;
	};
	return obj;
};
var c = new Circle();
alert(c.area(2.0));
//alert(Circle.area(2.8)); // 这种写法是错误的 */

//下面是闭包的第三种写法：
/* var Circle = new Object();
Circle.PI = 3.14159;
Circle.area = function (r) {
	return this.PI*r*r;
};
alert(Circle.area(3.3)); */

//下面是闭包的第四种写法：
/* var Circle={
    'PI' : 3.14159,
    'area': function (r) {
    	return this.PI*r*r;
    }
};
alert(Circle.area(1.1)); */

// 下面是闭包的第五种写法：
/* var Circle = new Function('this.PI=3.14159;this.area=function(r){return this.PI*r*r;}');
var c = new Circle();
alert(c.area(1.0)); */

// 下面是函数和对象的区别
/* var dom = function () {};
dom.Show = function () {
	alert('Show Message');
};
dom.prototype.Display = function () {
	alert('prototype message');
};

// dom.Display(); // 这个报错
dom.Show(); // 这个可以
var d = new dom();
d.Display(); // 这个可以
//d.Show(); // 这个报错
// 1、不使用prototype属性定义的对象方法，是静态方法，只能直接用类名进行调用！另外，此静态方法中无法使用this变量来调用对象其他的属性！
// 2、使用prototype属性定义的对象方法，是非静态方法，只有在实例化后才能使用！其方法内部可以this来引用对象自身中的其他属性！*/

/* var dom = function () {
	var Name ='Default';
	this.Sex = 'Boy';
	this.success = function () {
		alert('Success');
	};
};
alert(dom.Name); // 这里返回undefined
alert(dom.Sex);  // 这里也返回undefined。因为在函数（不是对象）里面是有作用域的。
var d = new dom(); // 对象（如：{}）不能实例化，函数可以实例化
alert(d.Sex); // 这里返回Boy，相当于public变量
alert(d.Name); // 这里返回undefined,因为这个变量是局部变量 */

(function () { // 闭包内的所有变量和函数，只能在该闭包内使用
    function abc() {
	var self = this;
	var wokao = '我靠'; // var定义的是局部变量，外面是无法访问的，无论new还是直接函数名.变量名
	this.name = 'OuHaixiong'; // this定义的是对象公共属性，只能通过new出的对象来访问
	this.wori = 'wo ri ---';
	
	this.dahao = function () { // 使用this声明的函数和prototype是一样的
	    alert('this -- dahao');
	    alert(this.name);
	};
	
    }
    abc.prototype.nihao = function () { // 用prototype声明的函数是非静态函数，需要通过new对象，才能调用，且函数内部可以使用this对象
	alert('prototype -- nihao');
	alert(this.name);
    };
    abc.haha = function () { // 直接用.声明的函数是静态函数，外部直接用类名[函数名]进行调用
	alert('abc.haha');
//	alert(this.name); // 返回函数名:abc
//	alert(this.wori); // 返回undefined
	alert(this.wokao); // 返回undefined
    }
//    abc.dahao(); // 报错，提示：TypeError: abc.dahao is not a function
//    abc.nihao(); // 报错，提示：TypeError: abc.nihao is not a function
    var abcObj = new abc();
//    abcObj.nihao();
//    abcObj.dahao();
//    alert(abcObj.wokao); // 返回：undefined 
//    alert(abcObj.name); // 返回：OuHaixiong
//    alert(abc.wori); // undefined 
//    alert(abc.wokao); // undefined
//    abc.haha();
})();



