<?php
	# CLASS #
	include 'includeConfig/session.php';
	include 'includeConfig/credentials.php';
	include 'coreLibrary/view.php';
	include 'coreLibrary/control.php';
	include 'coreLibrary/model.php';
	
	# PROCEDURAL FUNCTION #
	include 'customLibrary/my_control.php';
	include 'customLibrary/my_model.php';
	
	# OBJECT #
	$coreView = new View;
	$coreControl = new Control;
	$coreModel = new Model;
	$myControl = new My_control;
	$myModel = new My_model;
	
	# ACCESS CONTROL #
	if($coreControl->pageUrl() == "index" || $coreControl->pageUrl() == "index.php")
	{ }
	else 
	{
		if(empty($_SESSION['admin_id']))
		{
			#header("Location: index");
		}
	}
	
	# LOGOUT CONTROL #
	if(@$_REQUEST["logout"] == "yes")
	{
		session_destroy();
		header("Location: index");
	}
?>