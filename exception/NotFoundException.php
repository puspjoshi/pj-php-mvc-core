<?php
namespace eork\phpmvc\exception;


/**
 * User: Pusp raj joshi
 * Date: Aug 2024
 * 
 */

 /**
  * Class ForbiddenException
  * 
  * @author Pusp Joshi <erpushparaj23@gmail.com>
  * @package eork\phpmvc\exception
  *
  */

  class NotFoundException extends \Exception
  {
    protected $message = 'Page not Found';

    protected $code = 404;
  }