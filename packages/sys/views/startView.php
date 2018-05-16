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

class startView {
	function __construct() {
		$menu = new modelMenu ();
		
	}
	
	function show() {
		$out = '
				<center><img src="::siteroot::/media/kolibri.png"></center>
				<p>
				Olá ! <br>
				Bem vindo ao Framework Kolibri, se você esta vendo esta página,
				significa que o sistem esta funcionando sem grandes problemas.
				<br>
				Boa Sorte !
				</p>
				';
			page::addBody($out);
			page::render();
	}
	
	function formulario() {
	
		$opt[0][0] = 1;
		$opt[0][1] = "Sim";
		$opt[1][0] = 2;
		$opt[1][1] = "Nao";
		$opt[2][0] = 3;
		$opt[2][1] = "Talvez";
	
		$optb[0][0] = 1;
		$optb[0][1] = "Masculino";
		$optb[1][0] = 2;
		$optb[1][1] = "Feminino";
	
		$fr = new formEasy();
		$fr->name('sdfsdf')->id('sdfsdf')->openForm();
		//$fr->type('code')->value("sdjfhkjsdhfkjdshf")->done();
		$fr->addRadio("Voc&ecirc; usaria um sistema como este ?", "minhaEscolhaRadio", $opt, "2");
		$fr->addCheckbox("Voc&ecirc; pagaria por uso mensal de um sistema", "minhachk", $optb,  "2");
		$fr->type('text')->label('Seu nome')->value('')->done();
		$fr->addCPF("CPF", 'cpf', '',1);
		$fr->addCNPJ("CNPJ", 'cnpj', '',1);
		$fr->addSelect("Sexo", "Chooser", $optb, 1,1);
		$fr->addData("Data para contato", 'dia', '',1);
		$fr->addHora('Horário para contato', 'hora', '',1);
	
		$fr->addTextArea("Meu Texto", "redacao", '',1);
		$fr->type('submit')->value('OK')->done();
		$fr->closeForm();
	
		page::addBody($fr->printform());
		page::render();
	
	
	}
	
	
	function mapa() {
	
	
		//$out .= '<h1>MAPA</h1><center><iframe src="https://www.google.com/maps/d/embed?mid=z0QuGMnmIJ54.kunTrL4i0394" width="100%" height="480"></iframe></center>';
		
		$gm = new googleMaps();
		$gm2 = new googleMaps();
		page::addBody("<h2>Mapa</h2>");
		$gm->setLatitude('-23.5190768');
		$gm->setLongitude('-46.7568477');
		//page::addBody($gm->genMap());
		page::addBody($gm2->genMap());
		page::render();
		
		
	}
	
	
	function video() {
	
		$out .= '<h1>Video</h1><center><video width="90%" controls autoplay>
			  <source src="http://www.litrixlinux.org/projetoKolibri/media/mmd_perfume.mp4" type="video/mp4">
			  Your browser does not support HTML5 video.
			</video></center>';
	
		page::addBody($out);
		page::render();
	}
	
	
	function tabela() {
		$table['coluna A'][0] = rand(1000,9000);
		$table['coluna B'][0] = rand(1000,9000);
		$table['coluna C'][0] = rand(1000,9000);
		$table['coluna A'][1] = rand(1000,9000);
		$table['coluna B'][1] = rand(1000,9000);
		$table['coluna C'][1] = rand(1000,9000);
		$table['coluna A'][2] = rand(1000,9000);
		$table['coluna B'][2] = rand(1000,9000);
		$table['coluna C'][2] = rand(1000,9000);
	
		$tb = new htmlTable();
                                        
		page::addBody($tb->loadTable($table));
		page::render();
	
	}
	
	function shed(){
		
		$s = new webCalendar();
		$s->setdefaultDate('2015-02-12');
		
		$calendario[0]['title'] = "Evento do dia";
		$calendario[0]['start'] = '2015-02-01';
		$calendario[1]['title'] = "Evento Longo";
		$calendario[1]['start'] = '2015-02-01';
		$calendario[1]['end'] = '2015-02-10';
		$calendario[2]['title'] = "Outro Evento Longo";
		$calendario[2]['start'] = '2015-02-01';
		$calendario[2]['end'] = '2015-02-10';
		$calendario[3]['title'] = "Reunião";
		$calendario[3]['start'] = '2015-02-12T10:30:00';
		$calendario[3]['end'] = '2015-02-12T12:30:00';
		$calendario[4]['title'] = "Jantar";
		$calendario[4]['start'] = '2015-02-12T20:00:00';
		$calendario[3]['title'] = "Chamar o Google";
		$calendario[3]['url'] = 'http://google.com/';
		$calendario[3]['start'] = '2015-02-28';
		
		$s->loadPreviews($calendario);
		page::addBody($s->run());
		page::render();
		
	}
	
	function chart() {
		
		page::addBody("<h2>Graficos</h2>");
		page::addBody("De reload nesta pagina para alternar entre os 2 tipos<br>");
		
		$escolha = rand(0,1);
		
		for ( $x=1; $x<13 ; $x++ ) {
			$tb['Mes'][$x] = $x;
			$tb['Vendas'][$x] = rand(10,99);
			$tb['Visitas'][$x] = rand(10,100);
		}
		$tb2['Acoes'] = 'Resultados';
		$tb2['visitas'] = 60;
		$tb2['Vendas'] = 40;
		
		if ( $escolha ) {
		$graf = new googleChart();
		$graf->setTitle("Vendas");
		$graf->setSubTitle("Por mes");
		$graf->setGraphType('line');
		$graf->loadMatrixData($tb);
		page::addBody($graf->genChart());
		page::render();
		}else{
		$graf = new googleChart();
		$graf->setTitle("Vendas");
		$graf->setSubTitle("Por mes");
		$graf->setGraphType('pie');
		$graf->loadMatrixData($tb2);
		page::addBody($graf->genChart());
		page::render();
		}
	}
	
}