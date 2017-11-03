<?php

	$this->load->view('templates/header', array('title' => $title));
	$this->load->view($content);
	$this->load->view('templates/footer');
?>
