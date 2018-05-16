<?php
class setupView {
	function index($msg='') {


		$js = 'window.onload = function () {
				$( "select" ).change(function() {
				 var str = "";
			  $( "select option:selected" ).each(function() {
     			 str += $( this ).val() + " ";
   				 });
				if ( str  == 1) {
					$( "#database" ).show("slow");
				}else{
					$( "#database" ).hide("slow");
				}

			});}';

		page::addJsScript($js);
		page::addCssScript('#database { display: none;}');

		$opt[0][0] = '0';
		$opt[0][1] = 'Open';

		$opt[1][0] = '1';
		$opt[1][1] = 'Login';

		page::addBody ( "<h3>Kolibri setup</h3>" );

		if ( strlen($msg) > 0 ) {
			page::addBody('<hr><font color="red">' . $msg . "</font><hr>");
		}

		$form = new formEasy ();

		$url = str_replace ( $_SERVER ['PATH_INFO'], '', $_SERVER ['HTTP_HOST'] . $_SERVER ['REQUEST_URI'] );

		$form->action( 'http://' . $url . "/setup/save/")->method('post')->openForm();
		$url = str_replace('index.php', '', $url);
		$form->addText ( "Site Name", 'siteName', 'Kolibri Framework');
		$form->addText ( "Site URL", 'siteUrl', 'http://' . $url );
		
		$form->addSelect ( "Security Mode", 'secMode', $opt, '0' );
		$form->addhtml('<div id="database">');
		$form->addPasswordCad ( 'Admin Password', 'adminPass', '' );
		$form->addhtml('<hr>');
		$form->addText("KolibriDB Server Database", 'kdbServerData', 'kolibri');
		$form->addText("KolibriDB Server type", 'kdbServerType', 'mysql');
		$form->addText("KolibriDB Server", 'kdbServerHost', '127.0.0.1');
		$form->addText("KolibriDB Server Port", 'kdbServerPort', '3306');
		$form->addText("KolibriDB Server User", 'kdbServerUser', '');
		$form->addText("KolibriDB Server Pass", 'kdbServerPass', '');
		$form->addText ( "Google capcha Key", 'googleCaptiveKey', '' );
		$form->addText ( "Google capcha Secret", 'googleCaptiveSecret', '' );
		
		$form->addhtml("</div>");
		
		$form->type ( 'submit' )->class('btn btn-primary')->value ( 'Salvar' )->done ();


		$form->closeForm ();
		page::addBody ( $form->printform () );
		page::render ();
	}
}