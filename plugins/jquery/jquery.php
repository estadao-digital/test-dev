<?php
class jquery {
	function __construct(){
		page::addJsFile ( '::siteroot::/vendors/jquery/dist/jquery.min.js' );
	}
	
	function loadUI() {
		page::addCssFile( '::siteroot::/vendors/jquery-ui/jquery-ui.min.css' );
		page::addJsFile ( '::siteroot::/vendors/jquery-ui/jquery-ui.js' );
	}
	
}