<?php

namespace App\Purchase;
use \App\SQL;

class PurchaseOrder Extends SQL  {

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
    

    Public $PurchaseOrder;

    public function NewPurchaseOrder($CODE, $CompanyId, $UserID){

        $NewPurchaseOrder = $this->GetInsert("INSERT INTO ". TABLE_ERP_PURCHASE_ORDER ." VALUE ('0', '". $CODE ."','','','','". $CompanyId ."','0','0',
                                                                                                  NOW(),NOW(),'1','". $UserID ."','0','0','')");

        return $NewPurchaseOrder;
    }

    public function GETPurchaseOrder($id_GET){

        if($this-> GETPurchaseOrderCount($id_GET) == 0){ header('Location: index.php?page=purchase'); }

        $PurchaseOrder = $this->GetQuery('SELECT '. TABLE_ERP_PURCHASE_ORDER .'.id,
                                        '. TABLE_ERP_PURCHASE_ORDER .'.CODE,
                                        '. TABLE_ERP_PURCHASE_ORDER .'.INDICE,
                                        '. TABLE_ERP_PURCHASE_ORDER .'.LABEL,
                                        '. TABLE_ERP_PURCHASE_ORDER .'.LABEL_INDICE,
                                        '. TABLE_ERP_PURCHASE_ORDER .'.COMPANY_ID,
                                        '. TABLE_ERP_PURCHASE_ORDER .'.CONTACT_ID,
                                        '. TABLE_ERP_PURCHASE_ORDER .'.ADRESSE_ID,
                                        '. TABLE_ERP_PURCHASE_ORDER .'.DATE,
                                        '. TABLE_ERP_PURCHASE_ORDER .'.DATE_REQUIREMENT,
                                        '. TABLE_ERP_PURCHASE_ORDER .'.ETAT,
                                        '. TABLE_ERP_PURCHASE_ORDER .'.CREATOR_ID,
                                        '. TABLE_ERP_PURCHASE_ORDER .'.MODIFIED_ID,
                                        '. TABLE_ERP_PURCHASE_ORDER .'.BUYER_ID,
                                        '. TABLE_ERP_PURCHASE_ORDER .'.COMENT,
                                        '. TABLE_ERP_COMPANES .'.LABEL As CUSTOMER_LABEL,
                                        '. TABLE_ERP_EMPLOYEES .'.NOM AS NOM_CREATOR,
                                        '. TABLE_ERP_EMPLOYEES .'.PRENOM AS PRENOM_CREATOR,
                                        '. TABLE_ERP_EMPLOYEES .'_MODIFIED.NOM AS NOM_MODIFIED,
                                        '. TABLE_ERP_EMPLOYEES .'_MODIFIED.PRENOM  AS PRENOM_MODIFIED,
                                        '. TABLE_ERP_EMPLOYEES .'_BUYER.NOM AS NOM_BUYER,
                                        '. TABLE_ERP_EMPLOYEES .'_BUYER.PRENOM  AS PRENOM_BUYER
                                        FROM `'. TABLE_ERP_PURCHASE_ORDER .'`
                                            LEFT JOIN `'. TABLE_ERP_COMPANES .'` ON `'. TABLE_ERP_PURCHASE_ORDER .'`.`COMPANY_ID` = `'. TABLE_ERP_COMPANES .'`.`id`
                                            LEFT JOIN `'. TABLE_ERP_EMPLOYEES .'` ON `'. TABLE_ERP_PURCHASE_ORDER .'`.`CREATOR_ID` = `'. TABLE_ERP_EMPLOYEES .'`.`idUSER`
                                            LEFT JOIN `'. TABLE_ERP_EMPLOYEES .'` AS '. TABLE_ERP_EMPLOYEES .'_MODIFIED ON `'. TABLE_ERP_PURCHASE_ORDER .'`.`MODIFIED_ID` =  '. TABLE_ERP_EMPLOYEES .'_MODIFIED.`idUSER`
                                            LEFT JOIN `'. TABLE_ERP_EMPLOYEES .'` AS '. TABLE_ERP_EMPLOYEES .'_BUYER ON `'. TABLE_ERP_PURCHASE_ORDER .'`.`BUYER_ID` = '. TABLE_ERP_EMPLOYEES .'_BUYER.`idUSER`
                                          WHERE '. TABLE_ERP_PURCHASE_ORDER .'.id = \''. $id_GET.'\' ', true, 'App\Purchase\PurchaseOrder');
        return $PurchaseOrder;
    }

    public function GETPurchaseOrderCount($ID = null, $Clause = null){
        
        if($ID != null){
            $Clause = 'WHERE id = \''. $ID .'\'';
        }

        $PurchaseOrderCount =  $this->GetCount(TABLE_ERP_PURCHASE_ORDER,'id', $Clause);
        return $PurchaseOrderCount;
    }

    public function GETPurchaseOrderList($IdData=0, $Select = true){

        $this->QuoteList ='';
        $query='SELECT '. TABLE_ERP_PURCHASE_ORDER .'.id,
                        '. TABLE_ERP_PURCHASE_ORDER .'.CODE,
                        '. TABLE_ERP_PURCHASE_ORDER .'.LABEL,
                        '. TABLE_ERP_PURCHASE_ORDER .'.ETAT,
                        '. TABLE_ERP_COMPANES .'.LABEL As CUSTOMER_LABEL
                FROM '. TABLE_ERP_PURCHASE_ORDER .'
                    LEFT JOIN `'. TABLE_ERP_COMPANES .'` ON `'. TABLE_ERP_PURCHASE_ORDER .'`.`COMPANY_ID` = `'. TABLE_ERP_COMPANES .'`.`id`
                ORDER BY  '. TABLE_ERP_PURCHASE_ORDER .'.id DESC';
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

class PurchaseOrderLines Extends PurchaseOrder  {

    Public $id;
    Public $PURCHASE_ORDER_ID;
    Public $TASK_ID;
    Public $ARTICLE_ID;
    Public $ORDRE;
    Public $LABEL;
    Public $QT;
    Public $UNIT_ID;
    Public $PRIX_U;
    Public $DISCOUNT;
    Public $ETAT;
    
    Public $PurchaseOrderLines;

    public function NewPurchaseOrderLines($IdPurchaseOrder, $TASK_ID, $ARTICLE_ID, $ORDRE,   $LABEL,$TECHNICAL_SPECIFICATION, $QT, $UNIT_ID, $PRIX_U, $DISCOUNT, $ETAT = 1){

        $NewPurchaseOrderLines = $this->GetInsert("INSERT INTO ". TABLE_ERP_PURCHASE_ORDER_LINES ." VALUE ('0',
                                                                                        '". $IdPurchaseOrder ."',
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

                      

        return $NewPurchaseOrderLines;
    }

    public function UpdatePurchaseOrderLines($id,  $TASK_ID, $ARTICLE_ID, $ORDRE, $LABEL, $TECHNICAL_SPECIFICATION, $QT, $UNIT_ID, $PRIX_U, $DISCOUNT, $ETAT){

        $UpdatePurchaseOrderLines = $this->GetUpdate("UPDATE  ". TABLE_ERP_PURCHASE_ORDER_LINES ." SET 	
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

        return $UpdatePurchaseOrderLines;
    }

    public function GETPurchaseOrderLinesList($IdData=0, $Select = true, $IdPurchaseOrder=0){

        $this->PurchaseOrderLinesList ='';
        $Clause = 'WHERE '. TABLE_ERP_PURCHASE_ORDER_LINES .'.PURCHASE_ORDER_ID = \''. $IdPurchaseOrder.'\'';
        if($IdPurchaseOrder===0){
            $Clause = '';
        }
        $query='SELECT  '. TABLE_ERP_PURCHASE_ORDER_LINES .'.id,
                        '. TABLE_ERP_PURCHASE_ORDER_LINES .'.PURCHASE_ORDER_ID,
                        '. TABLE_ERP_PURCHASE_ORDER_LINES .'.TASK_ID,
                        '. TABLE_ERP_PURCHASE_ORDER_LINES .'.ARTICLE_ID,
                        '. TABLE_ERP_PURCHASE_ORDER_LINES .'.ORDRE,
                        '. TABLE_ERP_PURCHASE_ORDER_LINES .'.LABEL,
                        '. TABLE_ERP_PURCHASE_ORDER_LINES .'.TECHNICAL_SPECIFICATION,
                        '. TABLE_ERP_PURCHASE_ORDER_LINES .'.QT,
                        '. TABLE_ERP_PURCHASE_ORDER_LINES .'.UNIT_ID,
                        '. TABLE_ERP_PURCHASE_ORDER_LINES .'.PRIX_U,
                        '. TABLE_ERP_PURCHASE_ORDER_LINES .'.DISCOUNT,
                        '. TABLE_ERP_PURCHASE_ORDER_LINES .'.ETAT,
                        '. TABLE_ERP_PURCHASE_ORDER .'.CODE AS PURCHASE_REQUEST_CODE,
                        '. TABLE_ERP_UNIT .'.LABEL AS LABEL_UNIT
                        FROM '. TABLE_ERP_PURCHASE_ORDER_LINES .'
                            LEFT JOIN `'. TABLE_ERP_UNIT .'` ON `'. TABLE_ERP_PURCHASE_ORDER_LINES .'`.`UNIT_ID` = `'. TABLE_ERP_UNIT .'`.`id`
                            LEFT JOIN `'. TABLE_ERP_PURCHASE_ORDER .'` ON `'. TABLE_ERP_PURCHASE_ORDER_LINES .'`.`PURCHASE_ORDER_ID` = `'. TABLE_ERP_PURCHASE_ORDER .'`.`id`
                            '. $Clause.'
                        ORDER BY '. TABLE_ERP_PURCHASE_ORDER_LINES .'.ORDRE ';
        if($Select){
            foreach ($this->GetQuery($query) as $data){
            
                $this->PurchaseOrderLinesList .='<option value="'. $data->id .'" '. selected($IdData, $data->id) .'>'. $data->CODE .'</option>';
            }

            return  $this->PurchaseOrderLinesList;

        }else {
            return  $this->GetQuery($query);
        }  
    }
}