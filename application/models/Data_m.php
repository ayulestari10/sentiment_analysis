<?php

class Data_m extends MY_Model
{
	public function __construct()
	{
		parent::__construct();

		$this->data['table_name']	= 'data';
		$this->data['primary_key']	= 'id_kata';
	}
}
