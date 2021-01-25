<?php
namespace App;
    
class Form {

    private $data;

    public function __construct($data){
        $this->data = $data;
    }

    public function input($type, $name, $value='', $placeholder=''){
        return '<input type="'. $type .'" name="'. $name .'" value="'. $value .'" placeholder="'. $placeholder .'">';
    }

    public function submit($text){
        return '<input class="input-moyen" type="submit" value="'. $text .'" />';
    }
}