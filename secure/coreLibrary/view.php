<?php
/*
	Model Name: View
	Developed By: Nova Framework Developer
	Dated: 17/02/2014
	For: All the PHP Lovers
*/

class View
{
	/* ---------- ---------- ---------- VARIABLE DECLARATION // Config ---------- ---------- ---------- */
	
	// Variable //
	public $variable = 0;
	
	/* ---------- ---------- ---------- CONSTRUCTOR FUNCTION // Default ---------- ---------- ---------- */
	
	public function __construct()
	{
	}
	
	/* ---------- ---------- ---------- VIEW FUNCTIONS // Framework Views ---------- ---------- ---------- */
	
	public function call($page_name)
	{
		include "includeFile/" . $page_name . ".php";
	}

	public function call2($page_name)
	{
		include "includes/" . $page_name . ".php";
	    
	}
}