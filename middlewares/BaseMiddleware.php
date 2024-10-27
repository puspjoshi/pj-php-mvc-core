<?php
namespace app\core\middlewares;
/**
 * User: Pusp raj joshi
 * Date: Aug 2024
 * 
 */

 /**
  * Class BaseMiddleware
  * 
  * @author Pusp Joshi <erpushparaj23@gmail.com>
  * @package app\core\middlewares
  *
  */

  abstract class BaseMiddleware
  {
    abstract public function execute();
  }