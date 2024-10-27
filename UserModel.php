<?php
namespace eork\phpmvc;

use eork\phpmvc\db\DbModel;

/**
 * User: Pusp raj joshi
 * Date: Aug 2024
 * 
 */

 /**
  * Class UserModel
  * 
  * @author Pusp Joshi <erpushparaj23@gmail.com>
  * @package eork\phpmvc
  *
  */

  abstract class UserModel extends DbModel
  {
    abstract public function getDisplayName(): string;
  }