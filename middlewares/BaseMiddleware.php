<?php
namespace eork\phpmvc\middlewares;
/**
 * User: Pusp raj joshi
 * Date: Aug 2024
 * 
 */

 /**
  * Class BaseMiddleware
  * 
  * @author Pusp Joshi <erpushparaj23@gmail.com>
  * @package eork\phpmvc\middlewares
  *
  */

  abstract class BaseMiddleware
  {
    abstract public function execute();
  }