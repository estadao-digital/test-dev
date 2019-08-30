<?php
namespace Controllers;

use \Core\Controller;
use \Models\Carros;

class HomeController extends Controller {

	public function index() {
		

		$this->render('home');

	}


}