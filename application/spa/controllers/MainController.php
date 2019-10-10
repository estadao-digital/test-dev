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

    // [GET] -> update_form
    public function UpdateForm()
    {
        $a = new Template("estadao");
        $a->loadView("update_form.phtml");
    }

}

?>