<?php
namespace App;
use \App\SQL;

class Form Extends SQL  {

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

    public function select($SelectName='', $SelectId='',$TargetId='', $activate=true, $NoSelectValue='', $QueryResult ){

        if($activate){

            $option ='';

            

            foreach($QueryResult as $line){
                $option .= $this->option($line->id, $line->LABEL, $activate, selected($line->id, $TargetId) );  
            }


            return '<select name="'. $SelectName .'" >
                '. $option .'
            </select>';

            
        }
        else{
            return $NoSelectValue;
        }
    }

    public function option($Datavalue='', $Displayvalue='', $activate=true, $Selected = '' ){

        if($activate){
            return '<option value="'. $Datavalue .'" '.  $Selected .'>'. $Displayvalue .'</option>';
        }
        else{
            return $Displayvalue;
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