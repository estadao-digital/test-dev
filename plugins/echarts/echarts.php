<?php
/*
 * Copyright (C) 2016 vagner
 *
 * This file is part of Kolibri.
 *
 * Kolibri is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * Kolibri is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with Kolibri. If not, see <http://www.gnu.org/licenses/>.
 */

class echarts extends chart {
	
	private $grafName;
	private $height = 280;
	
	function __construct() {
		/*
		 * <script src="../vendors/echarts/dist/echarts.min.js"></script>
		 * <script src="../vendors/echarts/map/js/world.js"></script>
		 */
		parent::__construct();
		page::addJsFile( config::siteRoot () . "/vendors/echarts/dist/echarts.min.js" );
		page::addJsFile( config::siteRoot() . "/vendors/echarts/map/js/world.js" );
	}
	
	
	function setgrafName($name){
		$this->grafName = $name;
	}
	
	function setheigh($height) {
		$this->height = $height;
	}
	
	function ajaxRender($url,$params = array()) {
		
		if ( ! $this->grafName ) {
			$this->grafName = 'graf' . rand(1000,9999);
		}
		
		if ( is_array($params)) {
			foreach ( $params as $k => $v ) {
				$tmpObj->{$k} = $v;
			}
			$dataParam = json_encode($tmpObj);
		}
		
		
		
		
		$code = "
				<div id=\"DV$this->grafName\" style=\"height:" . $this->height . "px;\">..</div>
				<script type=\"text/javascript\">
				$.ajax({
				  method: \"POST\",
				   dataType: 'json',
				  url: \"$url\",
				  data: $dataParam
				})
				  .done(function( dataReceived ) {
					var $this->grafName = echarts.init(document.getElementById('DV$this->grafName'), \"default\");
					$this->grafName.setOption(dataReceived);
					
				  });
		</script>";
		
		return $code;			
		
	}
	
	
}