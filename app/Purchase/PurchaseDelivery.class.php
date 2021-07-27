<?php

namespace App\Purchase;
use \App\SQL;

class PurchaseDelivery Extends SQL  {

    Public $id;
    Public $CODE;
    Public $INDICE;
    Public $LABEL;
    Public $LABEL_INDICE;
    Public $COMPANY_ID;
    Public $CONTACT_ID;
    Public $ADRESSE_ID;
    Public $DATE;
    Public $ETAT;
    Public $CREATOR_ID;
    Public $MODIFIED_ID;
    Public $COMENT;
    Public $NOM_CREATOR;
    Public $PRENOM_CREATOR;
    Public $NOM_MODIFIED;
    Public $PRENOM_MODIFIED;   

    Public $PurchaseDelivery;

    public function NewPurchaseDelivery($CODE, $CompanyId, $UserID){

        $NewPurchaseDelivery = $this->GetInsert("INSERT INTO ". TABLE_ERP_PURCHASE_DELIVERY_NOTE ." VALUE ('0', '". $CODE ."','','','','". $CompanyId ."','0','0',
                                                                                                  NOW(),'1','". $UserID ."','0','')");

        return $NewPurchaseDelivery;
    }

    public function GETPurchaseDelivery($id_GET){

        if($this-> GETPurchaseDeliveryCount($id_GET) == 0){ header('Location: index.php?page=purchase'); }

        $PurchaseDelivery = $this->GetQuery('SELECT '. TABLE_ERP_PURCHASE_DELIVERY_NOTE .'.id,
                                        '. TABLE_ERP_PURCHASE_DELIVERY_NOTE .'.CODE,
                                        '. TABLE_ERP_PURCHASE_DELIVERY_NOTE .'.INDICE,
                                        '. TABLE_ERP_PURCHASE_DELIVERY_NOTE .'.LABEL,
                                        '. TABLE_ERP_PURCHASE_DELIVERY_NOTE .'.LABEL_INDICE,
                                        '. TABLE_ERP_PURCHASE_DELIVERY_NOTE .'.COMPANY_ID,
                                        '. TABLE_ERP_PURCHASE_DELIVERY_NOTE .'.CONTACT_ID,
                                        '. TABLE_ERP_PURCHASE_DELIVERY_NOTE .'.ADRESSE_ID,
                                        '. TABLE_ERP_PURCHASE_DELIVERY_NOTE .'.DATE,
                                        '. TABLE_ERP_PURCHASE_DELIVERY_NOTE .'.ETAT,
                                        '. TABLE_ERP_PURCHASE_DELIVERY_NOTE .'.CREATOR_ID,
                                        '. TABLE_ERP_PURCHASE_DELIVERY_NOTE .'.MODIFIED_ID,
                                        '. TABLE_ERP_PURCHASE_DELIVERY_NOTE .'.COMENT,
                                        '. TABLE_ERP_COMPANES .'.LABEL As CUSTOMER_LABEL,
                                        '. TABLE_ERP_EMPLOYEES .'.NOM AS NOM_CREATOR,
                                        '. TABLE_ERP_EMPLOYEES .'.PRENOM AS PRENOM_CREATOR,
                                        '. TABLE_ERP_EMPLOYEES .'_MODIFIED.NOM AS NOM_MODIFIED,
                                        '. TABLE_ERP_EMPLOYEES .'_MODIFIED.PRENOM  AS PRENOM_MODIFIED
                                        FROM `'. TABLE_ERP_PURCHASE_DELIVERY_NOTE .'`
                                            LEFT JOIN `'. TABLE_ERP_COMPANES .'` ON `'. TABLE_ERP_PURCHASE_DELIVERY_NOTE .'`.`COMPANY_ID` = `'. TABLE_ERP_COMPANES .'`.`id`
                                            LEFT JOIN `'. TABLE_ERP_EMPLOYEES .'` ON `'. TABLE_ERP_PURCHASE_DELIVERY_NOTE .'`.`CREATOR_ID` = `'. TABLE_ERP_EMPLOYEES .'`.`idUSER`
                                            LEFT JOIN `'. TABLE_ERP_EMPLOYEES .'` AS '. TABLE_ERP_EMPLOYEES .'_MODIFIED ON `'. TABLE_ERP_PURCHASE_DELIVERY_NOTE .'`.`MODIFIED_ID` =  '. TABLE_ERP_EMPLOYEES .'_MODIFIED.`idUSER`
                                           WHERE '. TABLE_ERP_PURCHASE_DELIVERY_NOTE .'.id = \''. $id_GET.'\' ', true, 'App\Purchase\PurchaseDelivery');
        return $PurchaseDelivery;
    }

    public function GETPurchaseDeliveryCount($ID = null, $Clause = null){
        
        if($ID != null){
            $Clause = 'WHERE id = \''. $ID .'\'';
        }

        $PurchaseDeliveryCount =  $this->GetCount(TABLE_ERP_PURCHASE_DELIVERY_NOTE,'id', $Clause);
        return $PurchaseDeliveryCount;
    }

    public function GETPurchaseDeliveryList($IdData=0, $Select = true){

        $this->QuoteList ='';
        $query='SELECT '. TABLE_ERP_PURCHASE_DELIVERY_NOTE .'.id,
                        '. TABLE_ERP_PURCHASE_DELIVERY_NOTE .'.CODE,
                        '. TABLE_ERP_PURCHASE_DELIVERY_NOTE .'.LABEL,
                        '. TABLE_ERP_PURCHASE_DELIVERY_NOTE .'.ETAT,
                        '. TABLE_ERP_COMPANES .'.LABEL As CUSTOMER_LABEL
                FROM '. TABLE_ERP_PURCHASE_DELIVERY_NOTE .'
                    LEFT JOIN `'. TABLE_ERP_COMPANES .'` ON `'. TABLE_ERP_PURCHASE_DELIVERY_NOTE .'`.`COMPANY_ID` = `'. TABLE_ERP_COMPANES .'`.`id`
                ORDER BY  '. TABLE_ERP_PURCHASE_DELIVERY_NOTE .'.id DESC';
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

class PurchaseDeliveryLines Extends PurchaseDelivery  {

    Public $id;
    Public $PURCHASE_DELIVERY_ID;
    Public $PURCHASE_ORDER_LINES_ID;
    Public $TASK_ID;
    Public $ARTICLE_ID;
    Public $ORDRE;
    Public $LABEL;
    Public $QT;
    Public $QTY_RECEIPT;
    Public $QTY_TO_RETURN;
    Public $UNIT_ID;
    Public $PRIX_U;
    Public $DISCOUNT;
    Public $ETAT;
    
    Public $PurchaseDeliveryLines;

    public function NewPurchaseDeliveryLines($IdPurchaseDelivery, $IdPurchaseOrderLineId, $ORDRE, $PRIX_U, $ETAT = 1){

        $NewPurchaseDeliveryLines = $this->GetInsert("INSERT INTO ". TABLE_ERP_PURCHASE_DELIVERY_NOTE_LINES ." VALUE ('0',
                                                                                        '". $IdPurchaseDelivery ."',
                                                                                        '". $IdPurchaseOrderLineId ."',
                                                                                        '". addslashes($ORDRE) ."',
                                                                                        '". addslashes($PRIX_U) ."',
                                                                                        '". addslashes($ETAT) ."')");

                      

        return $NewPurchaseDeliveryLines;
    }

    public function UpdatePurchaseDeliveryLines($id,  $ORDRE, $QTY_RECEIPT, $QTY_TO_RETURN, $PRIX_U, $ETAT){

        $UpdatePurchaseDeliveryLines = $this->GetUpdate("UPDATE  ". TABLE_ERP_PURCHASE_DELIVERY_NOTE_LINES ." SET 	
                                                                                        ORDRE='". addslashes($ORDRE) ."',
                                                                                        QTY_RECEIPT ='". addslashes($QTY_RECEIPT) ."',
                                                                                        QTY_TO_RETURN='". addslashes($QTY_TO_RETURN) ."',
                                                                                        PRIX_U='". addslashes($PRIX_U) ."',
                                                                                        ETAT='". addslashes($ETAT) ."'
                                                                                     WHERE id='". addslashes($id)."'");

        return $UpdatePurchaseDeliveryLines;
    }

    public function GETPurchaseDeliveryLinesList($IdData=0, $Select = true, $IdPurchaseDelivery=0){

        $this->PurchaseDeliveryLinesList ='';
        $Clause = 'WHERE '. TABLE_ERP_PURCHASE_DELIVERY_NOTE_LINES .'.PURCHASE_DELIVERY_ID = \''. $IdPurchaseDelivery.'\'';
        if($IdPurchaseDelivery===0){
            $Clause = '';
        }
        $query='SELECT  '. TABLE_ERP_PURCHASE_DELIVERY_NOTE_LINES .'.id,
                        '. TABLE_ERP_PURCHASE_DELIVERY_NOTE_LINES .'.PURCHASE_DELIVERY_ID,
                        '. TABLE_ERP_PURCHASE_DELIVERY_NOTE_LINES .'.PURCHASE_ORDER_LINES_ID,
                        '. TABLE_ERP_PURCHASE_DELIVERY_NOTE_LINES .'.ETAT,
                        '. TABLE_ERP_PURCHASE_DELIVERY_NOTE_LINES .'.PRIX_U,
                        '. TABLE_ERP_PURCHASE_DELIVERY_NOTE_LINES .'.ORDRE,
                        '. TABLE_ERP_PURCHASE_ORDER_LINES .'.LABEL,
                        '. TABLE_ERP_PURCHASE_ORDER_LINES .'.TASK_ID,
                        '. TABLE_ERP_PURCHASE_ORDER_LINES .'.ARTICLE_ID,
                        '. TABLE_ERP_PURCHASE_ORDER_LINES .'.TECHNICAL_SPECIFICATION,
                        '. TABLE_ERP_PURCHASE_ORDER_LINES .'.QT,
                        '. TABLE_ERP_PURCHASE_ORDER_LINES .'.UNIT_ID,
                        '. TABLE_ERP_PURCHASE_ORDER_LINES .'.DISCOUNT,
                        '. TABLE_ERP_PURCHASE_DELIVERY_NOTE .'.CODE AS PURCHASE_REQUEST_CODE,
                        '. TABLE_ERP_UNIT .'.LABEL AS LABEL_UNIT
                        FROM '. TABLE_ERP_PURCHASE_DELIVERY_NOTE_LINES .'
                            LEFT JOIN `'. TABLE_ERP_PURCHASE_DELIVERY_NOTE .'` ON `'. TABLE_ERP_PURCHASE_DELIVERY_NOTE_LINES .'`.`PURCHASE_DELIVERY_ID` = `'. TABLE_ERP_PURCHASE_DELIVERY_NOTE .'`.`id`
                            LEFT JOIN `'. TABLE_ERP_PURCHASE_ORDER_LINES .'` ON `'. TABLE_ERP_PURCHASE_DELIVERY_NOTE_LINES .'`.`PURCHASE_ORDER_LINES_ID` = `'. TABLE_ERP_PURCHASE_ORDER_LINES .'`.`id`
                            LEFT JOIN `'. TABLE_ERP_UNIT .'` ON `'. TABLE_ERP_PURCHASE_ORDER_LINES .'`.`UNIT_ID` = `'. TABLE_ERP_UNIT .'`.`id`
                            '. $Clause.'
                        ORDER BY '. TABLE_ERP_PURCHASE_DELIVERY_NOTE_LINES .'.ORDRE ';
        if($Select){
            foreach ($this->GetQuery($query) as $data){
            
                $this->PurchaseDeliveryLinesList .='<option value="'. $data->id .'" '. selected($IdData, $data->id) .'>'. $data->CODE .'</option>';
            }

            return  $this->PurchaseDeliveryLinesList;

        }else {
            return  $this->GetQuery($query);
        }  
    }
}