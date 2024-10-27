<?php
namespace eork\phpmvc;

use eork\phpmvc\middlewares\BaseMiddleware;

/**
 * User: Pusp raj joshi
 * Date: Aug 2024
 * 
 */

 /**
  * Class Controller
  * 
  * @author Pusp Joshi <erpushparaj23@gmail.com>
  * @package eork\phpmvc
  *
  */
  

  class Controller
  {
    public string $layout = 'main';

    public string $action = '';
    /**
     * @var \eork\phpmvc\middlewares\BaseMiddleware[]
     */
    protected array $middlewares = [];
    
    public function setLayout($layout)
    {
      $this->layout = $layout;
    }
    
    public function render($view, $params = [])
    {
        return Application::$app->view->renderView($view,$params);
    }

    public function registerMiddleware(BaseMiddleware $middleware)
    {
      $this->middlewares[] = $middleware;
    }

    public function getMiddlewares(): array
    {
      return $this->middlewares;
    }
  }