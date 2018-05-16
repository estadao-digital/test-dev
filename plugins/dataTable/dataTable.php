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
class dataTable extends htmlTable {
	private $buttons = 0;
	private $fixedheader = 0;
	private $keytable = 0;
	private $responsive = 0;
	private $url;
	private $dateUk = 0;
	

	
	function enableDateUk() {
		
		$js = 'jQuery.extend( jQuery.fn.dataTableExt.oSort, {
    "date-uk-pre": function ( a ) {
        if (a == null || a == "") {
            return 0;
        }
        var ukDatea = a.split('/');
        return (ukDatea[2] + ukDatea[1] + ukDatea[0]) * 1;
    },
        		
    "date-uk-asc": function ( a, b ) {
        return ((a < b) ? -1 : ((a > b) ? 1 : 0));
    },
        		
    "date-uk-desc": function ( a, b ) {
        return ((a < b) ? 1 : ((a > b) ? -1 : 0));
    }
} );';
		page::addJsScript($js);
		$this->dateUk = 1;
	}
	
	
	function __construct() {
		$jq = new jquery ();
		page::addCssFile ( config::siteRoot () . '/vendors/datatables.net-bs/css/dataTables.bootstrap.min.css' );
		page::addCssFile ( config::siteRoot () . '/vendors/datatables.net-buttons-bs/css/buttons.bootstrap.min.css' );
		page::addJsFile ( config::siteRoot () . '/vendors/datatables.net/js/jquery.dataTables.js' );
		page::addJsFile ( config::siteRoot () . '/vendors/datatables.net-bs/js/dataTables.bootstrap.min.js' );
		page::addJsFile ( config::siteRoot () . '/vendors/datatables.net-fixedheader/js/dataTables.fixedHeader.min.js' );
	}
	function enableButtons() {
		page::addJsFile ( config::siteRoot () . '/vendors/datatables.net-buttons/js/dataTables.buttons.min.js' );
		page::addJsFile ( config::siteRoot () . '/vendors/datatables.net-buttons-bs/js/buttons.bootstrap.min.js' );
		page::addJsFile ( config::siteRoot () . '/vendors/datatables.net-buttons/js/buttons.print.min.js' );
		page::addJsFile ( config::siteRoot () . '/vendors/datatables.net-buttons/js/buttons.html5.min.js' );
		page::addJsFile ( config::siteRoot () . '/vendors/datatables.net-buttons/js/buttons.flash.min.js' );
		$this->buttons = 1;
	}
	function enableButtonsBs() {
		$this->buttons = 1;
	}
	function enableFixedheader() {
		$this->fixedheader = 1;
	}
	function enableFixedheaderBS() {
		$this->fixedheader = 1;
	}
	function enablekeytable() {
		$this->keytable = 1;
	}
	function enableresponsive() {
		$this->responsive = 1;
	}
	function setajaxUrl($url) {
		$this->url = $url;
	}
	function loadTable($table) {
		$this->settableClass ( 'table table-striped table-bordered' );
		
		$id = rand ( 1000, 9999 );
		$this->id = 'tbl' . $id . '-buttons';
		
		$css = '.boxTable{
				z-index: 0;
				}';
		
		page::addCssScript ( $css );
		
		$tab = '<div class="boxTable">' . parent::loadTable ( $table ) . "</div>";
		
		$this->id = 'tbl' . $id;
		
		$js = '
				//$.noConflict();
				
				function init_DataTables() {
				
				console.log(\'run_datatables\');
				
				var handleDataTableButtons = function() {
				 // if ($("#' . $this->id . '-buttons").length) {
					
					$("#' . $this->id . '-buttons").DataTable({
					  ajax: "' . $this->url . '",
					 ';
		
		if ($this->buttons) {
			$js .= '
					dom: "Bfrtip",
					buttons: [
					{
						  extend: "copy",
						  className: "btn-sm"
						},
						{
						  extend: "csv",
						  className: "btn-sm"
						},
						{
						  extend: "excel",
						  className: "btn-sm"
						},
						{
						  extend: "pdfHtml5",
						  className: "btn-sm"
						},
						{
						  extend: "print",
						  className: "btn-sm"
						},
					  ],';
		} else {
			// $js .= 'dom: "f",';
		}
		
		if ( $this->dateUk ) {
			$js .= "columnDefs: [
			       { type: 'date-uk', targets: 0 }
			     ],";
			
		}
		
		$js .= 'responsive: true
					});
				  }
				//};

				TableManageButtons = function() {
				 
				  return {
					init: function() {
					  handleDataTableButtons();
					}
				  };
				}();

			

			

				TableManageButtons.init();
				
			};
			init_DataTables();
			
			';
		
		$tab .= "<script>$js</script>";
		
		return $tab;
	}
}