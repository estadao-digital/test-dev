<?php
  

  //return var_dump(json_decode(file_get_contents('php://input')));
  //var_dump(getallheaders());

  $request_url = $_GET['uri'];

  if(!$request_url)
  {
    header("HTTP/1.0 404 Not Found");
  }

  $request_type = $_SERVER['REQUEST_METHOD'];
  $request_parts = explode('/',$request_url);
  $prefix = '/api';

  $routes = [
    ['/carros','GET','CarroController@getCarros'], 
    ['/carros/{$id}','GET','CarroController@getCarro'],
    ['/carros','POST','CarroController@insertCarro'],
    ['/carros/{$id}','PUT','CarroController@updateCarro'],
    ['/carros/{$id}',"DELETE",'CarroController@deleteCarro']
  ];

  $controller_variables = [];
  $vars = [];
  $route_match = [];
  $route_string = "";

  foreach($routes as $route)
  {
      if($request_type == $route[1])
      {
         
          $route_parts = explode('/',$prefix.$route[0]);

          if(count($route_parts) == count($request_parts))
          {
              $index = 0;
              $vars = [];

              if($request_type == "POST" || $request_type == "PUT")
              {

                if($_POST == [])
                {   
                    $_POST  = json_decode(file_get_contents('php://input'));
                }

                  $vars[] = $_POST;
              }


              while($index < count($request_parts))
              {
                    if($route_parts[$index] != $request_parts[$index])
                    {
                        
                        if( substr($route_parts[$index], 0, 1 ) === "{")
                            {
                                $vars[] = ltrim($request_parts[$index],'/');
                            }
                           
                    }
                    else{
                        $route_string  = $route_string . $route_parts[$index].'/';
                    }

                    $index ++;
              }
              $route_match = $route;
          }
      }

      if($route_match != [])
      {
          break;
      }
  }

  
        if($route_match != [])
        {
            $route = explode('@',$route_match[2]);

            require_once('./controllers/'.$route[0].'.php');

            $class_name = $route[0];
            
            $controller = new $class_name();
        
           echo call_user_func_array(array($controller,$route[1]), $vars);
        }
        
?>