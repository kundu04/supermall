<?php
	# CLASS #
	include 'includeConfig/session.php';
	include 'includeConfig/credentials.php';
	include 'secure/coreLibrary/view.php';
	include 'secure/coreLibrary/control.php';
	include 'secure/coreLibrary/model.php';
	
	# PROCEDURAL FUNCTION #
	include 'secure/customLibrary/my_control.php';
	include 'secure/customLibrary/my_model.php';
	
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
		if(empty($_SESSION['cust_id']))
		{
			#header("Location: index.php");
		}
	}
	
	# LOGOUT CONTROL #
	if(@$_REQUEST["logout"] == "yes")
	{
		session_destroy();
		header("Location: index.php");
	}
?>
