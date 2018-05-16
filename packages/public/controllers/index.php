<?php 
/*
 *  Copyright (C) 2016 vagner    
 * 
 *    This file is part of Kolibri.
 *
 *    Kolibri is free software: you can redistribute it and/or modify
 *    it under the terms of the GNU General Public License as published by
 *    the Free Software Foundation, either version 3 of the License, or
 *    (at your option) any later version.
 *
 *    Kolibri is distributed in the hope that it will be useful,
 *    but WITHOUT ANY WARRANTY; without even the implied warranty of
 *    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *    GNU General Public License for more details.
 *
 *    You should have received a copy of the GNU General Public License
 *    along with Kolibri.  If not, see <http://www.gnu.org/licenses/>. 
 */

class index extends controller {
	function example() {
        
				
		$v = new indexView();
		$v->init();
	}
	
	function graf() {
		$v = new indexView();
		$v->chartData();
	}
	
	
	
	function tableData() {
		
		$tbl['nome'][1] = "Vagner";
		$tbl['Data'][1] = "08/06/1979";
		$tbl['Valor'][1] = "100";
		
		$tbl['nome'][2] = "Selma";
		$tbl['Data'][2] = "08/06/1978";
		$tbl['Valor'][2] = "200";
		
		$tbl['nome'][3] = "Laris";
		$tbl['Data'][3] = "08/06/2013";
		$tbl['Valor'][4] = "300";
		
		$i=1;
		foreach ($tbl as $k => $v) {
			$out[$i][$k] = $tbl[$k][$i];
		}
		
		
		
		$json = json_encode($out);
		
		
		$txt = '{"data": [
    [
      "Tiger Nixon",
      "System Architect",
      "18/06/1979"
      
    ],
    [
      "Garrett Winters",
      "Tokyo",
      "28/06/1978"
      
    ],
    [
      "Ashton Cox",
      "Junior Technical Author",
      "08/06/2013"
      
    ]
]
}
';
		
		page::addBody($txt);
		page::renderAjax();
		
	}
}


