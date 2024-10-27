<?php
namespace app\core\form;

use app\core\Model;

/**
 * User: Pusp raj joshi
 * Date: Aug 2024
 * 
 */

 /**
  * Class Form
  * 
  * @author Pusp Joshi <erpushparaj23@gmail.com>
  * @package app\core\form
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