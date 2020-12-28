<?php

namespace App\Companies;
use \App\SQL;

class Companies Extends SQL  {

    Public $id;
    Public $CODE;
    Public $NAME;
    Public $WEBSITE;  
    Public $FBSITE;  
    Public $TWITTERITE; 
    Public $LKDSITE;   
    Public $SIREN;
    Public $APE;
    Public $TVA_INTRA;
    Public $TVA_ID;
    Public $LOGO;
    Public $STATU_CLIENT;
    Public $COND_REG_CLIENT_ID;
    Public $MODE_REG_CLIENT_ID;
    Public $REMISE;
    Public $RESP_COM_ID;
    Public $RESP_TECH_ID;
    Public $COMPTE_GEN_CLIENT;
    Public $COMPTE_AUX_CLIENT;
    Public $STATU_FOUR;
    Public $COND_REG_FOUR_ID;
    Public $MODE_REG_FOUR_ID;
    Public $COMPTE_GEN_FOUR;
    Public $COMPTE_AUX_FOUR;
    Public $CONTROLE_FOUR;
    Public $DATE_CREA;
    Public $COMMENT;
    Public $SECTOR_ID;

    Public $ProviderList;
    Public $ProviderCheckedList;

    public function GetProviderList($IdData=0){

        $this->ProviderList ='<option value="0">Aucune</option>';
        $query='SELECT Id, LABEL   FROM '. TABLE_ERP_CLIENT_FOUR .'';
		foreach ($this->GetQuery($query) as $data){
           
			$this->ProviderList .='<option value="'. $data->Id .'" '. selected($IdData, $data->Id) .'>'. $data->LABEL .'</option>';
		}
        
        return  $this->ProviderList;
    }

    public function GetProviderCheckedList($IdData){
        $IdData = explode(",", $IdData);
        $query='SELECT id, CODE, NAME   FROM '. TABLE_ERP_CLIENT_FOUR .' WHERE STATU_FOUR=1 ';

		foreach ($this->GetQuery($query) as $data){
            if(in_array($data->id,$IdData)){
                $checked = 'checked';
            }
            else{
                $checked = '';
            }

            $this->ProviderCheckedList .='<tr><td><input type="checkbox" '. $checked .' value="'. $data->id .'" name="PROVIDER_ID[]" /><label for="PROVIDER_ID">'. $data->CODE .' - '. $data->NAME .'</label></td></tr>';
		}
        
        return  $this->ProviderCheckedList;
    }

    public function GetCustomerList(array $IdData){
        $IdData = explode(",", $IdData);
        $query='SELECT id, NAME   FROM '. TABLE_ERP_CLIENT_FOUR .' WHERE STATU_CLIENT=1 ';

		foreach ($this->GetQuery($query) as $data){
            if(in_array($data->id,$IdData)){
                $checked = 'checked';
            }
            else{
                $checked = '';
            }

			$this->CustomerList .='<option value="'. $data->id .'" '. $checked .'>'. $data->LABEL .'</option>';
		}
        
        return  $this->CustomerList;
    }
}
