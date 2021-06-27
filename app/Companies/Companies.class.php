<?php

namespace App\Companies;
use \App\SQL;

class Companies Extends SQL  {

    Public $id;
    Public $CODE;
    Public $LABEL;
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
    Public $DISCOUNT;
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

        $GETCompanie = $this->GetQuery('SELECT  '. TABLE_ERP_COMPANES .'.id,
                                                '. TABLE_ERP_COMPANES .'.CODE,
                                                '. TABLE_ERP_COMPANES .'.LABEL,
                                                '. TABLE_ERP_COMPANES .'.WEBSITE,  
                                                '. TABLE_ERP_COMPANES .'.FBSITE,  
                                                '. TABLE_ERP_COMPANES .'.TWITTERSITE, 
                                                '. TABLE_ERP_COMPANES .'.LKDSITE,   
                                                '. TABLE_ERP_COMPANES .'.SIREN,
                                                '. TABLE_ERP_COMPANES .'.APE,
                                                '. TABLE_ERP_COMPANES .'.TVA_INTRA,
                                                '. TABLE_ERP_COMPANES .'.TVA_ID,
                                                '. TABLE_ERP_COMPANES .'.LOGO,
                                                '. TABLE_ERP_COMPANES .'.STATU_CLIENT,
                                                '. TABLE_ERP_COMPANES .'.COND_REG_CLIENT_ID,
                                                '. TABLE_ERP_COMPANES .'.MODE_REG_CLIENT_ID,
                                                '. TABLE_ERP_COMPANES .'.DISCOUNT,
                                                '. TABLE_ERP_COMPANES .'.RESP_COM_ID,
                                                '. TABLE_ERP_COMPANES .'.RESP_TECH_ID,
                                                '. TABLE_ERP_COMPANES .'.COMPTE_GEN_CLIENT,
                                                '. TABLE_ERP_COMPANES .'.COMPTE_AUX_CLIENT,
                                                '. TABLE_ERP_COMPANES .'.STATU_FOUR,
                                                '. TABLE_ERP_COMPANES .'.COND_REG_FOUR_ID,
                                                '. TABLE_ERP_COMPANES .'.MODE_REG_FOUR_ID,
                                                '. TABLE_ERP_COMPANES .'.COMPTE_GEN_FOUR,
                                                '. TABLE_ERP_COMPANES .'.COMPTE_AUX_FOUR,
                                                '. TABLE_ERP_COMPANES .'.CONTROLE_FOUR,
                                                '. TABLE_ERP_COMPANES .'.DATE_CREA,
                                                '. TABLE_ERP_COMPANES .'.COMMENT,
                                                '. TABLE_ERP_COMPANES .'.SECTOR_ID ,
                                                '. TABLE_ERP_TVA .'.LABEL AS TVA_LABEL
                                            FROM '. TABLE_ERP_COMPANES .' 
                                            LEFT JOIN `'. TABLE_ERP_TVA .'` ON `'. TABLE_ERP_COMPANES .'`.`TVA_ID` = `'. TABLE_ERP_TVA .'`.`id`
                                            WHERE  '. TABLE_ERP_COMPANES .'.id = \''. $id_GET_Companie . '\'', true, 'App\Companies\Companies');
        return $GETCompanie;
    }

    public function GETCompanieCount($ID = null, $Clause = null){
        
        if($ID != null){
            $ClauseSQL = 'WHERE id = \''. $ID .'\' ';
        }

        If($Clause != null){
            $ClauseSQL = 'WHERE STATU_CLIENT = \''. $Clause .'\' ';
        }
        
        $CompaniesCount =  $this->GetCount(TABLE_ERP_COMPANES,'id', $ClauseSQL);
        return $CompaniesCount;
    }

    public function GetProviderList($IdData=0){

        $this->ProviderList ='';
        $query='SELECT Id, LABEL   FROM '. TABLE_ERP_COMPANES .'';
		foreach ($this->GetQuery($query) as $data){
           
			$this->ProviderList .='<option value="'. $data->Id .'" '. selected($IdData, $data->Id) .'>'. $data->LABEL .'</option>';
		}
        
        return  $this->ProviderList;
    }

    public function GetProviderCheckedList($IdData){
        $this->ProviderCheckedList = '';
        $IdData = explode(",", $IdData);
        $query='SELECT id, CODE, LABEL   FROM '. TABLE_ERP_COMPANES .' WHERE STATU_FOUR=1 ';

		foreach ($this->GetQuery($query) as $data){
            if(in_array($data->id,$IdData)){
                $checked = 'checked';
            }
            else{
                $checked = '';
            }

            $this->ProviderCheckedList .='<tr><td><input type="checkbox" '. $checked .' value="'. $data->id .'" name="PROVIDER_ID[]" /><label for="PROVIDER_ID">'. $data->CODE .' - '. $data->LABEL .'</label></td></tr>';
		}
        
        return  $this->ProviderCheckedList;
    }

    public function GetCustomerList($IdData=0, $Select = true){
        $this->CustomerList = '';
        $query='SELECT id, CODE, LABEL   FROM '. TABLE_ERP_COMPANES .' WHERE STATU_CLIENT=1 ';

        if($Select){

            foreach ($this->GetQuery($query) as $data){

                $this->CustomerList .='<option value="'. $data->id .'" '. selected($IdData, $data->id) .'>'. $data->LABEL .'</option>';
            }
            return  $this->CustomerList;
        }else {
            return  $this->GetQuery($query);
        } 
    }
}
