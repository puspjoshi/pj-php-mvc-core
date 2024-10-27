<?php
namespace app\core\exception;


/**
 * User: Pusp raj joshi
 * Date: Aug 2024
 * 
 */

 /**
  * Class ForbiddenException
  * 
  * @author Pusp Joshi <erpushparaj23@gmail.com>
  * @package app\core\exception
  *
  */

  class ForbiddenException extends \Exception
  {
    protected $message = 'You don\'t have permision to access this page';

    protected $code = 403;
  }