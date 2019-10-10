<?php

class MainController
{

    public function Page()
    {
        $a = new Template("estadao");
        $a->title = "Index";
        $a->display();
    }
    
    // [GET] -> home
    public function Home()
    {
        $a = new Template("estadao");
        $a->loadView("home.phtml");
    }

    // [GET] -> form
    public function Form()
    {
        $a = new Template("estadao");
        $a->loadView("form.phtml");
    }

}

?>