<?php
namespace eork\phpmvc\middlewares;

use eork\phpmvc\Application;
use eork\phpmvc\exception\ForbiddenException;

/**
 * User: Pusp raj joshi
 * Date: Aug 2024
 * 
 */

 /**
  * Class AuthMiddleware
  * 
  * @author Pusp Joshi <erpushparaj23@gmail.com>
  * @package eork\phpmvc\middlewares
  *
  */

  class AuthMiddleware extends BaseMiddleware
  {
    public array $actions = [];

    /**
     * AuthMiddleware Constructor
     * 
     * @param array $actions
     */
    public function __construct(array $actions = [])
    {
        $this->actions = $actions;
    }
    public function execute()
    {
        if(Application::isGuest())
        {
            if(empty($this->actions) || in_array(Application::$app->controller->action, $this->actions))
            {
                throw new ForbiddenException();
            }
        }
    }
  }