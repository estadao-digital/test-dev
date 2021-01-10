<?php

spl_autoload_register(function ($class_name) {
    $directorys = [
                    '/src/',
                    '/app/',
                    '/app/Controllers/',
                    '/app/Models/',
                    '/routes/'
                ];
                foreach($directorys as $directory)
                        {
                            //see if the file exsists
                            if(file_exists(__DIR__.$directory.$class_name . '.php'))
                            {
                                require_once(__DIR__.$directory.$class_name . '.php');
                                //only require the class once, so quit after to save effort (if you got more, then name them something else
                                return;
                            }           
                        }
   
});

    ?>