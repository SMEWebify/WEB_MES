<?php
namespace App;
    
class Form {

    private $data;

    public function __construct($data){
        $this->data = $data;
    }

    public function ActivateForm($bool){
        $this->_activate = $bool;
    }

    public function input($type, $name, $value='', $placeholder='', $activate=true, $option =''){
        
        if($activate){
            if(!empty($placeholder))
            {
                $placeholder =  'placeholder="'. $placeholder .'"';
            }

            return '<input type="'. $type .'" name="'. $name .'" value="'. $value .'" '. $placeholder .' '. $option .' >';
        }
        else{
            return $value;
        }
    }

    public function submit($text, $activate=true){
        if($activate){
            return '<input class="input-moyen" type="submit" value="'. $text .'" />';
        }
         else{
             return '';
        }
    }
}