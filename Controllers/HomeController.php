<?php
/**
 * @author Werberson <werberson@gmail.com>
 * @package Controllers
 */
namespace Controllers;

use \Core\Controller;

class HomeController extends Controller 
{

	public function index() 
	{
		
		$this->render('home');

	}


}