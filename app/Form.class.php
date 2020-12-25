<?php
namespace App;
    
class Form {

    private $data;

    public function __construct($data){
        $this->data = $data;
    }

    public function input($type, $name, $value){
        return '<input type="'. $type .'" name="'. $name .'" value="'. $value .'">';
    }

    public function submit($text){
        return '<input type="submit" value="'. $text .'" />';
    }
}