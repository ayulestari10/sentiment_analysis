<?php

class Home extends MY_Controller
{
	public function __construct()
	{
		parent::__construct();
	}

	public function index()
	{
		$this->data['title']	= 'Welcome to Dazzle';
		$this->data['content']  = 'home/home';
        $this->template($this->data,'home');
    }
}
