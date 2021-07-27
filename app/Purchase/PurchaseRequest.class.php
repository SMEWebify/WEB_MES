<?php

namespace App\Purchase;
use \App\SQL;

class PurchaseRequest Extends SQL  {

    Public $id;
    Public $CODE;
    Public $INDICE;
    Public $LABEL;
    Public $LABEL_INDICE;
    Public $CUSTOMER_LABEL;
    Public $COMPANY_ID;
    Public $CONTACT_ID;
    Public $ADRESSE_ID;
    Public $DATE;
    Public $DATE_REQUIREMENT;
    Public $ETAT;
    Public $CREATOR_ID;
    Public $MODIFIED_ID;
    Public $COMENT;
    Public $NOM_CREATOR;
    Public $PRENOM_CREATOR;
    Public $NOM_MODIFIED;
    Public $PRENOM_MODIFIED;   
    Public $NOM_BUYER;
    Public $PRENOM_BUYER;   
    Public $BUYER_ID;
    

    Public $PurchaseRequest;

    public function NewPurchaseRequest($CODE, $CompanyId, $UserID){

        $NewPurchaseRequest = $this->GetInsert("INSERT INTO ". TABLE_ERP_PURCHASE_REQUEST ." VALUE ('0', '". $CODE ."','','','','". $CompanyId ."','0','0',
																				NOW(),NOW(),'1','". $UserID ."','0','0','')");

        return $NewPurchaseRequest;
    }

    public function GETPurchaseRequest($id_GET){

        if($this-> GETPurchaseRequestCount($id_GET) == 0){ header('Location: index.php?page=purchase'); }

        $PurchaseRequest = $this->GetQuery('SELECT '. TABLE_ERP_PURCHASE_REQUEST .'.id,
                                        '. TABLE_ERP_PURCHASE_REQUEST .'.CODE,
                                        '. TABLE_ERP_PURCHASE_REQUEST .'.INDICE,
                                        '. TABLE_ERP_PURCHASE_REQUEST .'.LABEL,
                                        '. TABLE_ERP_PURCHASE_REQUEST .'.LABEL_INDICE,
                                        '. TABLE_ERP_PURCHASE_REQUEST .'.COMPANY_ID,
                                        '. TABLE_ERP_PURCHASE_REQUEST .'.CONTACT_ID,
                                        '. TABLE_ERP_PURCHASE_REQUEST .'.ADRESSE_ID,
                                        '. TABLE_ERP_PURCHASE_REQUEST .'.DATE,
                                        '. TABLE_ERP_PURCHASE_REQUEST .'.DATE_REQUIREMENT,
                                        '. TABLE_ERP_PURCHASE_REQUEST .'.ETAT,
                                        '. TABLE_ERP_PURCHASE_REQUEST .'.CREATOR_ID,
                                        '. TABLE_ERP_PURCHASE_REQUEST .'.MODIFIED_ID,
                                        '. TABLE_ERP_PURCHASE_REQUEST .'.BUYER_ID,
                                        '. TABLE_ERP_PURCHASE_REQUEST .'.COMENT,
                                        '. TABLE_ERP_COMPANES .'.LABEL As CUSTOMER_LABEL,
                                        '. TABLE_ERP_EMPLOYEES .'.NOM AS NOM_CREATOR,
                                        '. TABLE_ERP_EMPLOYEES .'.PRENOM AS PRENOM_CREATOR,
                                        '. TABLE_ERP_EMPLOYEES .'_MODIFIED.NOM AS NOM_MODIFIED,
                                        '. TABLE_ERP_EMPLOYEES .'_MODIFIED.PRENOM  AS PRENOM_MODIFIED,
                                        '. TABLE_ERP_EMPLOYEES .'_BUYER.NOM AS NOM_BUYER,
                                        '. TABLE_ERP_EMPLOYEES .'_BUYER.PRENOM  AS PRENOM_BUYER
                                        FROM `'. TABLE_ERP_PURCHASE_REQUEST .'`
                                            LEFT JOIN `'. TABLE_ERP_COMPANES .'` ON `'. TABLE_ERP_PURCHASE_REQUEST .'`.`COMPANY_ID` = `'. TABLE_ERP_COMPANES .'`.`id`
                                            LEFT JOIN `'. TABLE_ERP_EMPLOYEES .'` ON `'. TABLE_ERP_PURCHASE_REQUEST .'`.`CREATOR_ID` = `'. TABLE_ERP_EMPLOYEES .'`.`idUSER`
                                            LEFT JOIN `'. TABLE_ERP_EMPLOYEES .'` AS '. TABLE_ERP_EMPLOYEES .'_MODIFIED ON `'. TABLE_ERP_PURCHASE_REQUEST .'`.`MODIFIED_ID` =  '. TABLE_ERP_EMPLOYEES .'_MODIFIED.`idUSER`
                                            LEFT JOIN `'. TABLE_ERP_EMPLOYEES .'` AS '. TABLE_ERP_EMPLOYEES .'_BUYER ON `'. TABLE_ERP_PURCHASE_REQUEST .'`.`BUYER_ID` = '. TABLE_ERP_EMPLOYEES .'_BUYER.`idUSER`
                                          WHERE '. TABLE_ERP_PURCHASE_REQUEST .'.id = \''. $id_GET.'\' ', true, 'App\Purchase\PurchaseRequest');
        return $PurchaseRequest;
    }

    public function GETPurchaseRequestCount($ID = null, $Clause = null){
        
        if($ID != null){
            $Clause = 'WHERE id = \''. $ID .'\'';
        }

        $PurchaseRequestCount =  $this->GetCount(TABLE_ERP_PURCHASE_REQUEST,'id', $Clause);
        return $PurchaseRequestCount;
    }

    public function GETPurchaseRequestList($IdData=0, $Select = true){

        $this->QuoteList ='';
        $query='SELECT '. TABLE_ERP_PURCHASE_REQUEST .'.id,
                        '. TABLE_ERP_PURCHASE_REQUEST .'.CODE,
                        '. TABLE_ERP_PURCHASE_REQUEST .'.LABEL,
                        '. TABLE_ERP_PURCHASE_REQUEST .'.ETAT,
                        '. TABLE_ERP_COMPANES .'.LABEL As CUSTOMER_LABEL
                FROM '. TABLE_ERP_PURCHASE_REQUEST .'
                    LEFT JOIN `'. TABLE_ERP_COMPANES .'` ON `'. TABLE_ERP_PURCHASE_REQUEST .'`.`COMPANY_ID` = `'. TABLE_ERP_COMPANES .'`.`id`
                ORDER BY  '. TABLE_ERP_PURCHASE_REQUEST .'.id DESC';
        if($Select){
            foreach ($this->GetQuery($query) as $data){
            
                $this->QuoteList .='<option value="'. $data->Id .'" '. selected($IdData, $data->id) .'>'. $data->CODE .'</option>';
            }

            return  $this->QuoteList;

        }else {
            return  $this->GetQuery($query);
        }  
    }
}

class PurchaseRequestLines Extends PurchaseRequest  {

    Public $id;
    Public $PURCHASE_REQUEST_ID;
    Public $TASK_ID;
    Public $ARTICLE_ID;
    Public $ORDRE;
    Public $LABEL;
    Public $QT;
    Public $UNIT_ID;
    Public $PRIX_U;
    Public $DISCOUNT;
    Public $ETAT;
    
    Public $PurchaseRequestLines;

    public function NewPurchaseRequestLines($IdPurchaseRequest, $TASK_ID, $ARTICLE_ID, $ORDRE,   $LABEL,$TECHNICAL_SPECIFICATION, $QT, $UNIT_ID, $PRIX_U, $DISCOUNT, $ETAT = 1){

        $NewPurchaseRequestLines = $this->GetInsert("INSERT INTO ". TABLE_ERP_PURCHASE_REQUEST_LINES ." VALUE ('0',
                                                                                        '". $IdPurchaseRequest ."',
                                                                                        '". addslashes($TASK_ID) ."',
                                                                                        '". addslashes($ARTICLE_ID) ."',
                                                                                        '". addslashes($ORDRE) ."',
                                                                                        '". addslashes($LABEL) ."',
                                                                                        '". addslashes($TECHNICAL_SPECIFICATION) ."',
                                                                                        '". addslashes($QT) ."',
                                                                                        '". addslashes($UNIT_ID) ."',
                                                                                        '". addslashes($PRIX_U) ."',
                                                                                        '". addslashes($DISCOUNT) ."',
                                                                                        '". addslashes($ETAT) ."')");

                      

        return $NewPurchaseRequestLines;
    }

    public function UpdatePurchaseRequestLines($id,  $TASK_ID, $ARTICLE_ID, $ORDRE, $LABEL, $TECHNICAL_SPECIFICATION, $QT, $UNIT_ID, $PRIX_U, $DISCOUNT, $ETAT){

        $UpdatePurchaseRequestLines = $this->GetUpdate("UPDATE  ". TABLE_ERP_PURCHASE_REQUEST_LINES ." SET 	
                                                                                        TASK_ID='". addslashes($TASK_ID) ."',
                                                                                        ARTICLE_ID='". addslashes($ARTICLE_ID) ."',
                                                                                        ORDRE='". addslashes($ORDRE) ."',
                                                                                        LABEL='". addslashes($LABEL) ."',
                                                                                        TECHNICAL_SPECIFICATION ='". addslashes($TECHNICAL_SPECIFICATION) ."',
                                                                                        QT='". addslashes($QT) ."',
                                                                                        UNIT_ID='". addslashes($UNIT_ID) ."',
                                                                                        PRIX_U='". addslashes($PRIX_U) ."',
                                                                                        DISCOUNT='". addslashes($DISCOUNT) ."',
                                                                                        ETAT='". addslashes($ETAT) ."'
                                                                                        WHERE id='". addslashes($id)."'");

        return $UpdatePurchaseRequestLines;
    }

    public function GETPurchaseRequestLinesList($IdData=0, $Select = true, $IdPurchaseRequest=0){

        $this->PurchaseRequestLinesList ='';
        $Clause = 'WHERE '. TABLE_ERP_PURCHASE_REQUEST_LINES .'.PURCHASE_REQUEST_ID = \''. $IdPurchaseRequest.'\'';
        if($IdPurchaseRequest===0){
            $Clause = '';
        }
        $query='SELECT  '. TABLE_ERP_PURCHASE_REQUEST_LINES .'.id,
                        '. TABLE_ERP_PURCHASE_REQUEST_LINES .'.PURCHASE_REQUEST_ID,
                        '. TABLE_ERP_PURCHASE_REQUEST_LINES .'.TASK_ID,
                        '. TABLE_ERP_PURCHASE_REQUEST_LINES .'.ARTICLE_ID,
                        '. TABLE_ERP_PURCHASE_REQUEST_LINES .'.ORDRE,
                        '. TABLE_ERP_PURCHASE_REQUEST_LINES .'.LABEL,
                        '. TABLE_ERP_PURCHASE_REQUEST_LINES .'.TECHNICAL_SPECIFICATION,
                        '. TABLE_ERP_PURCHASE_REQUEST_LINES .'.QT,
                        '. TABLE_ERP_PURCHASE_REQUEST_LINES .'.UNIT_ID,
                        '. TABLE_ERP_PURCHASE_REQUEST_LINES .'.PRIX_U,
                        '. TABLE_ERP_PURCHASE_REQUEST_LINES .'.DISCOUNT,
                        '. TABLE_ERP_PURCHASE_REQUEST_LINES .'.ETAT,
                        '. TABLE_ERP_PURCHASE_REQUEST .'.CODE AS PURCHASE_REQUEST_CODE,
                        '. TABLE_ERP_UNIT .'.LABEL AS LABEL_UNIT
                        FROM '. TABLE_ERP_PURCHASE_REQUEST_LINES .'
                            LEFT JOIN `'. TABLE_ERP_UNIT .'` ON `'. TABLE_ERP_PURCHASE_REQUEST_LINES .'`.`UNIT_ID` = `'. TABLE_ERP_UNIT .'`.`id`
                            LEFT JOIN `'. TABLE_ERP_PURCHASE_REQUEST .'` ON `'. TABLE_ERP_PURCHASE_REQUEST_LINES .'`.`PURCHASE_REQUEST_ID` = `'. TABLE_ERP_PURCHASE_REQUEST .'`.`id`
                            '. $Clause.'
                        ORDER BY '. TABLE_ERP_PURCHASE_REQUEST_LINES .'.ORDRE ';
        if($Select){
            foreach ($this->GetQuery($query) as $data){
            
                $this->PurchaseRequestLinesList .='<option value="'. $data->id .'" '. selected($IdData, $data->id) .'>'. $data->CODE .'</option>';
            }

            return  $this->PurchaseRequestLinesList;

        }else {
            return  $this->GetQuery($query);
        }  
    }
}