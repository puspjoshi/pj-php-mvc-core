<?php
namespace eork\phpmvc\form;

use eork\phpmvc\Model;

/**
 * User: Pusp raj joshi
 * Date: Aug 2024
 * 
 */

 /**
  * Class Form
  * 
  * @author Pusp Joshi <erpushparaj23@gmail.com>
  * @package eork\phpmvc\form
  *
  */

  class Form
  {
    public static function begin($action, $method)
    {
        echo sprintf('<form action="%s" method="%s">',$action, $method);
        return new Form();
    }

    public static function end()
    {
        echo '</form>';
    }

    public function field(Model $model, $attributes)
    {
        return new InputField($model, $attributes);
    }

    public function textareaField(Model $model, $attributes)
    {
        return new TextareaField($model, $attributes);
    }

  }