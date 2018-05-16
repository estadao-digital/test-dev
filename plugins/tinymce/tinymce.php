<?php
class tinymce {
	
	
	private $config = array('selector' => 'h2.editable', 'inline' => true,  'toolbar' => 'undo redo', 'menubar' => false, 'height' => 500);
	
	function __construct() {
		page::addJsFile(config::siteRoot() . "/vendors/tinymce/js/tinymce/tinymce.min.js");
		//page::addJsFile(config::siteRoot() . "/vendors/tinymce/js/tinymce/jquery.tinymce.min.js");
		#page::addJsFile('https://cloud.tinymce.com/stable/tinymce.min.js');
	}
	
	function setConfig($key,$value) {
		$this->config[$key] = $value;
	}
	
	function apply($object) {
		page::addJsScript('$(document).ready(function() {
		
		tinymce.init(' . json_encode($this->config) . ');});');
		
		
		
	$js = "$(document).ready(function() {tinymce.init({
  mode : \"textareas\",
  selector: '$object',  // change this value according to your HTML
  plugins : 'advlist autolink link image lists charmap print preview'
});});";
		
	page::addJsScript($js);	
		
	}
	
}