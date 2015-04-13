<?php

class Backend_C_Test extends C_Abstract
{
    public function init() {
        
    }
    
    public function index() {
        $this->_view->love = 'a';
        $this->me = 88;
        $this->a = $this->getParam('a');
        $this->_view->b = $this->getParam('b');
        $this->wokao = $this->getParam('wok', 'ni吗');
        $this->c = $this->getParam('c', '');
        $this->ri = $this->getParam('ri');
        $this->render();
    }
    
}