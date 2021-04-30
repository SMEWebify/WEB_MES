<?php

namespace App\Companies;
use \App\SQL;

class Companies Extends SQL  {

    Public $id;
    Public $CODE;
    Public $NAME;
    Public $WEBSITE;  
    Public $FBSITE;  
    Public $TWITTERSITE; 
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
    Public $TVA_LABEL;

    Public $ProviderList;
    Public $ProviderCheckedList;
    Public $CompaniesCount;

    public function GETCompanie($id_GET_Companie){

        if($this-> GETCompanieCount($id_GET_Companie) == 0){ header('Location: index.php?page=companies'); }

        $GETCompanie = $this->GetQuery('SELECT  '. TABLE_ERP_CLIENT_FOUR .'.id,
                                                '. TABLE_ERP_CLIENT_FOUR .'.CODE,
                                                '. TABLE_ERP_CLIENT_FOUR .'.NAME,
                                                '. TABLE_ERP_CLIENT_FOUR .'.WEBSITE,  
                                                '. TABLE_ERP_CLIENT_FOUR .'.FBSITE,  
                                                '. TABLE_ERP_CLIENT_FOUR .'.TWITTERSITE, 
                                                '. TABLE_ERP_CLIENT_FOUR .'.LKDSITE,   
                                                '. TABLE_ERP_CLIENT_FOUR .'.SIREN,
                                                '. TABLE_ERP_CLIENT_FOUR .'.APE,
                                                '. TABLE_ERP_CLIENT_FOUR .'.TVA_INTRA,
                                                '. TABLE_ERP_CLIENT_FOUR .'.TVA_ID,
                                                '. TABLE_ERP_CLIENT_FOUR .'.LOGO,
                                                '. TABLE_ERP_CLIENT_FOUR .'.STATU_CLIENT,
                                                '. TABLE_ERP_CLIENT_FOUR .'.COND_REG_CLIENT_ID,
                                                '. TABLE_ERP_CLIENT_FOUR .'.MODE_REG_CLIENT_ID,
                                                '. TABLE_ERP_CLIENT_FOUR .'.REMISE,
                                                '. TABLE_ERP_CLIENT_FOUR .'.RESP_COM_ID,
                                                '. TABLE_ERP_CLIENT_FOUR .'.RESP_TECH_ID,
                                                '. TABLE_ERP_CLIENT_FOUR .'.COMPTE_GEN_CLIENT,
                                                '. TABLE_ERP_CLIENT_FOUR .'.COMPTE_AUX_CLIENT,
                                                '. TABLE_ERP_CLIENT_FOUR .'.STATU_FOUR,
                                                '. TABLE_ERP_CLIENT_FOUR .'.COND_REG_FOUR_ID,
                                                '. TABLE_ERP_CLIENT_FOUR .'.MODE_REG_FOUR_ID,
                                                '. TABLE_ERP_CLIENT_FOUR .'.COMPTE_GEN_FOUR,
                                                '. TABLE_ERP_CLIENT_FOUR .'.COMPTE_AUX_FOUR,
                                                '. TABLE_ERP_CLIENT_FOUR .'.CONTROLE_FOUR,
                                                '. TABLE_ERP_CLIENT_FOUR .'.DATE_CREA,
                                                '. TABLE_ERP_CLIENT_FOUR .'.COMMENT,
                                                '. TABLE_ERP_CLIENT_FOUR .'.SECTOR_ID ,
                                                '. TABLE_ERP_TVA .'.LABEL AS TVA_LABEL
                                            FROM '. TABLE_ERP_CLIENT_FOUR .' 
                                            LEFT JOIN `'. TABLE_ERP_TVA .'` ON `'. TABLE_ERP_CLIENT_FOUR .'`.`TVA_ID` = `'. TABLE_ERP_TVA .'`.`id`
                                            WHERE  '. TABLE_ERP_CLIENT_FOUR .'.id = \''. $id_GET_Companie . '\'', true, 'App\Companies\Companies');
        return $GETCompanie;
    }

    public function GETCompanieCount($ID = null){
        $Clause = '';
        if($ID != null){
            $Clause = 'WHERE id = \''. $ID .'\'';
        }

        $CompaniesCount =  $this->GetCount(TABLE_ERP_CLIENT_FOUR,'id', $Clause);
        return $CompaniesCount;
    }

    public function GetProviderList($IdData=0){

        $this->ProviderList ='';
        $query='SELECT Id, LABEL   FROM '. TABLE_ERP_CLIENT_FOUR .'';
		foreach ($this->GetQuery($query) as $data){
           
			$this->ProviderList .='<option value="'. $data->Id .'" '. selected($IdData, $data->Id) .'>'. $data->LABEL .'</option>';
		}
        
        return  $this->ProviderList;
    }

    public function GetProviderCheckedList($IdData){
        $this->ProviderCheckedList = '';
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

    public function GetCustomerList($IdData=0, $Select = true){
        $this->CustomerList = '';
        $query='SELECT id, NAME   FROM '. TABLE_ERP_CLIENT_FOUR .' WHERE STATU_CLIENT=1 ';

        if($Select){

            foreach ($this->GetQuery($query) as $data){

                $this->CustomerList .='<option value="'. $data->id .'" '. selected($IdData, $data->id) .'>'. $data->NAME .'</option>';
            }
            return  $this->CustomerList;
        }else {
            return  $this->GetQuery($query);
        } 
    }
}
