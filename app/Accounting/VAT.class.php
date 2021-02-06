<?php

namespace App\Accounting;
use \App\SQL;

class VAT Extends SQL  {

    Public $VATList;

    public function NewVAT($CODE, $LABEL, $VATRate){
        $NewVAT = $this->GetInsert("INSERT INTO ". TABLE_ERP_TVA ." VALUE ('0',
                                                                                '". addslashes($CODE) ."',
                                                                                '". addslashes($LABEL) ."',
                                                                                '". addslashes($VATRate) ."')");
        return $NewVAT;
    }

    public function GETVATList($IdData=0, $Select = true){
        $this->VATList = '';
        $query='SELECT '. TABLE_ERP_TVA .'.id,
                        '. TABLE_ERP_TVA .'.CODE,
                        '. TABLE_ERP_TVA .'.LABEL,
                        '. TABLE_ERP_TVA .'.TAUX
                        FROM `'. TABLE_ERP_TVA .'`
                        ORDER BY CODE';
        
        if($Select){
            foreach ( $this->GetQuery($query) as $data){
                $this->VATList .='<option value="'. $data->id .'" '. selected($IdData, $data->id) .'>'. $data->TAUX .'% - '. $data->LABEL .'</option>';
            }
        
            return  $this->VATList;
        }else {
            return  $this->GetQuery($query);
        } 
    }
}