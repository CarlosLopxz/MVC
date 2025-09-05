<?php

class TestController extends BaseController 
{
    public function index() 
    {
        $this->loadView('test');
    }
}
