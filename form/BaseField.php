<?php
namespace eork\phpmvc\form;

use eork\phpmvc\Model;

/**
 * User: Pusp raj joshi
 * Date: Aug 2024
 * 
 */

 /**
  * Class BaseField
  * 
  * @author Pusp Joshi <erpushparaj23@gmail.com>
  * @package eork\phpmvc\form
  *
  */

  abstract class BaseField
  {
    
    public Model $model;
    public string $attribute;
    
    abstract public function renderInput(): string;

    public function __construct(Model $model, string $attribute)
    {
        $this->model = $model;
        $this->attribute = $attribute;
    }
    public function __toString()
    {
        return sprintf('
            <div class="form-group">
            <label>%s</label>
                %s
                <div class="invalid-feedback">
                %s
            </div>
            </div>
            
        ',

        $this->model->getLables($this->attribute),
        $this->renderInput(),
        $this->model->getFirstError($this->attribute)
        
        
        );
    }
  }