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
class indexView {
	function chartData() {
		$graf = new echarts ();
		$graf->settooltip ( array (
				'trigger' => 'axis' 
		) );
		// $graf->setlegend(array( 'data' => array('leg1','leg2','leg3','leg4','leg5')));
		$graf->setcalculable ( true );
		$graf->setxAxis ( array (
				array (
						'type' => 'category',
						'boundaryGap' => false,
						'data' => array (
								'jan',
								'fev',
								'mar',
								'abr',
								'mai',
								'jun',
								'jul' 
						) 
				) 
		) );
		$graf->setyAxis ( array (
				array (
						'type' => 'value' 
				) 
		) );
		$graf->setseries ( array (
				array (
						'name' => 'o nome',
						'type' => 'line',
						'stack' => 'stack',
						'data' => array (
								120,
								132,
								101,
								134,
								90,
								230,
								210 
						) 
				) 
		) );
		$json = $graf->getJson ();
		page::addBody ( $json );
		page::renderAjax ();
	}
	function init() {
		$graf = new echarts ();
		
		$form = new formEasy ();
		$tiny = new tinymce ();
		$tiny->apply ( '#idtxt2' );
		$form->method ( 'post' )->openform ();
		$form->addTextArea ( 'Texto 1', 'txt1', 'foca' );
		$form->addTextArea ( 'Texto 2', 'txt2', '' );
		$form->addText ( 'sdfsdfsd', 'dddd', date ( 'H:i:s' ) . 'eeeeeeeeee' );
		$form->closeForm ();
		
		page::addBody ( $form->printform () );
		
		// page::addBody("sasf<div class='box'>Minha Caixas <br></div>");
		
		page::addBody ( $graf->ajaxRender ( config::siteRoot () . '/index.php/index/graf/' ) );
		
		$tbl ['nome'] [1] = ".";
		$tbl ['Data'] [1] = ".";
		$tbl ['Valor'] [1] = ".";
		
		$tb = new dataTable ();
		//$tb->enableDateUk();
		//$tb->enableButtons();
		$tb->setajaxUrl ( config::siteRoot () . '/index.php/index/tableData/' );
		page::addBody ( $tb->loadTable ( $tbl ) );
		
		page::render ();
	}
}