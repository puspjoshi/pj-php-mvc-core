<?php
namespace eork\phpmvc;

use eork\phpmvc\exception\NotFoundException;

/**
 * User: Pusp raj joshi
 * Date: Aug 2024
 * 
 */

 /**
  * Class Router
  * 
  * @author Pusp Joshi <erpushparaj23@gmail.com>
  * @package eork\phpmvc
  *
  */

  class Router
  {
    public Request $request;
    public Response $response;
    
    protected array $routes = [];

    /**
    * Router constructor
    * 
    * @param \eork\phpmvc\Request $request
    * @param \eork\phpmvc\Response $response
    *
    */
    public function __construct(Request $request, Response $response){
      $this->request = $request;
      $this->response = $response;
    }
    
    public function get($path, $callback)
    {
         $this->routes['get'][$path] = $callback;  
    }

    public function post($path, $callback)
    {
         $this->routes['post'][$path] = $callback;  
    }

    public function resolve(){
        $path = $this->request->getPath();

        $method = $this->request->method();

        $callback = $this->routes[$method][$path] ?? false;
        
        if($callback === false){
          $this->response->setStatusCode(404);
          throw new NotFoundException();
        }
        
        if(is_string($callback)){
          return Application::$app->view->renderView($callback);
        }
        if(is_array($callback)){
          /**
           * @var \eork\phpmvc\Controller $controller
           */
          $controller = new $callback[0]();
          Application::$app->controller = $controller;
          
          $controller->action = $callback[1];
          $callback[0] = $controller;

          foreach($controller->getMiddlewares() as $middleware)
          {
            $middleware->execute();
          }

        }

        return call_user_func($callback, $this->request, $this->response);
    }


  }