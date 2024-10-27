<?php
namespace app\core\middlewares;

use app\core\Application;
use app\core\exception\ForbiddenException;

/**
 * User: Pusp raj joshi
 * Date: Aug 2024
 * 
 */

 /**
  * Class AuthMiddleware
  * 
  * @author Pusp Joshi <erpushparaj23@gmail.com>
  * @package app\core\middlewares
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