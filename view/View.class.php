<?php

/**
* 
*/
class View
{
	
	static function get_view($view, $dados)
	{
		require "tpl/$view.tpl.php";
	}
}