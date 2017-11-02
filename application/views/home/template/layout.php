<?php

	$this->load->view('home/template/header', array('title' => $title));
	$this->load->view('home/template/navbar');
	$this->load->view($content);
	$this->load->view('home/template/footer');
?>
