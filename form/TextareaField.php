<?php
namespace app\core\form;

use app\core\Model;

/**
 * User: Pusp raj joshi
 * Date: Aug 2024
 * 
 */

 /**
  * Class Field
  * 
  * @author Pusp Joshi <erpushparaj23@gmail.com>
  * @package app\core\form
  *
  */

  class TextareaField extends BaseField
  {

    public function renderInput(): string
    {
      return sprintf('
            <textarea name="%s" class="form-control%s">%s </textarea>',
            $this->attribute,
            $this->model->hasError($this->attribute) ? ' is-invalid' : '',
            $this->model->{$this->attribute}
          );
    }
  }