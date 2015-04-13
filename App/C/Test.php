<?php

/**
 * 测试
 * @author bear
 *
 */
class C_Test extends C_Abstract
{
	public function init() {
		
	}
	
	public function index() {
		$this->_view->a = 'a';
		$this->_view->b = 88;
		$this->_view->title = '这个是标题';
		var_dump($this->getParams());
		//$this->_view->setIsLayout();
		$this->_view->setIsView();
	}
	
	/**
	 * 测试用 
	 */
	public function test() {
	    $this->_view->setIsView();
	    $this->_view->setIsLayout();
		//测试100只猴子 出局报数5 算出猴王的编号为47
		var_dump($this->monkeyKing(9, 5));
	}
	
	/**
	 * 猴子选大王
	 * @param int $m 猴子总数
	 * @param int $n 出局报数
	 */
	private function monkeyKing($m, $n) {
	    for ($i=1; $i<=$m; $i++) {
	        $arr[] = $i; // 把所有的猴子存在一个数组
 	    }
 	    
 	    $i = 0; // 数组指针
 	    while(count($arr)>1) {
 	        if (($i+1)%$n == 0) { // 出局了,直接删除
 	            unset($arr[$i]);
 	        } else { // 未出局的放在数组的后面组成新的数组进行下次循环
 	            array_push($arr, $arr[$i]);
 	            unset($arr[$i]);
 	        }
 	        $i++;
 	    }
 	    return $arr;
	}
	
}
