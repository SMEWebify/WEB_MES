<?php

namespace App\Order;
use \App\SQL;

class InvoiceOrder Extends SQL  {

    Public $id;
    Public $CODE;
    Public $ORDER_ID;
    Public $LABEL;
    Public $LABEL_INDICE;
    Public $CREATED;
    Public $MODIFIED;
    Public $ETAT;
    Public $CREATOR_ID;
    Public $MODIFIED_ID;
    
    Public $INCOTERM;
    Public $COMMENT;

    Public $COMPANY_ID;
    Public $CONTACT_ID;
    Public $ADRESSE_ID;
    Public $FACTURATION_ID;
    Public $COND_REG_COMPANY_ID;
    Public $COND_REG_LABEL;
    Public $MODE_REG_COMPANY_ID;
    Public $MODE_REG_LABEL;
    Public $ECHEANCIER_ID;
    Public $ECHEANCIER_LABEL;
    Public $TRANSPORT_ID;
    Public $TRANSPORT_LABEL;
    Public $CUSTOMER_LABEL;
    Public $NOM_CREATOR;
    Public $PRENOM_CREATOR;
    Public $NOM_RESP_COM;
    Public $PRENOM_RESP_COM;
    Public $NOM_RESP_TECH;
    Public $PRENOM_RESP_TECH;

    Public $InvoiceOrder;

    public function NewInvoiceOrder($CODE, $ORDER_ID, $UserID){

        $NewInvoiceOrder = $this->GetInsert("INSERT INTO ". TABLE_ERP_ORDER_INVOICE ." VALUE ('0',
                                                                                                    '". $CODE ."',
                                                                                                    '". $ORDER_ID ."',
                                                                                                    '',
                                                                                                    '',
                                                                                                    NOW(),
                                                                                                    NOW(),
                                                                                                    '1',
                                                                                                    '". $UserID ."',
                                                                                                    '". $UserID ."',
                                                                                                    '1',
                                                                                                    '')");
        return $NewInvoiceOrder;
    }

    public function GETInvoiceOrder($id_GET){

        if($this-> GETInvoiceOrderCount($id_GET) == 0){ header('Location: index.php?page=order'); }

        $InvoiceOrder = $this->GetQuery('SELECT '. TABLE_ERP_ORDER_INVOICE .'.id,
                                        '. TABLE_ERP_ORDER_INVOICE .'.CODE,
                                        '. TABLE_ERP_ORDER_INVOICE .'.ORDER_ID,
                                        '. TABLE_ERP_ORDER_INVOICE .'.LABEL,
                                        '. TABLE_ERP_ORDER_INVOICE .'.LABEL_INDICE,
                                        '. TABLE_ERP_ORDER_INVOICE .'.CREATED,
                                        '. TABLE_ERP_ORDER_INVOICE .'.MODIFIED,
                                        '. TABLE_ERP_ORDER_INVOICE .'.ETAT,
                                        '. TABLE_ERP_ORDER_INVOICE .'.CREATOR_ID,
                                        '. TABLE_ERP_ORDER_INVOICE .'.MODIFIED_ID,
                                        '. TABLE_ERP_ORDER_INVOICE .'.INCOTERM,
                                        '. TABLE_ERP_ORDER_INVOICE .'.COMENT,
                                        '. TABLE_ERP_EMPLOYEES .'.NOM AS NOM_CREATOR,
                                        '. TABLE_ERP_EMPLOYEES .'.PRENOM  AS PRENOM_CREATOR,
                                        TABLE_ERP_EMPPLOYEES_RESP_COM.NOM AS NOM_RESP_COM,
                                        TABLE_ERP_EMPPLOYEES_RESP_COM.PRENOM  AS PRENOM_RESP_COM,
                                        TABLE_ERP_EMPPLOYEES_RESP_TECH.NOM AS NOM_RESP_TECH,
                                        TABLE_ERP_EMPPLOYEES_RESP_TECH.PRENOM  AS PRENOM_RESP_TECH,
                                        '. TABLE_ERP_ORDER .'.COMPANY_ID,
                                        '. TABLE_ERP_ORDER .'.CONTACT_ID,
                                        '. TABLE_ERP_ORDER .'.ADRESSE_ID,
                                        '. TABLE_ERP_ORDER .'.FACTURATION_ID,
                                        '. TABLE_ERP_ORDER .'.RESP_COM_ID,
                                        '. TABLE_ERP_ORDER .'.RESP_TECH_ID,
                                        '. TABLE_ERP_ORDER .'.REFERENCE,
                                        '. TABLE_ERP_ORDER .'.COND_REG_COMPANY_ID,
                                        '. TABLE_ERP_ORDER .'.MODE_REG_COMPANY_ID,
                                        '. TABLE_ERP_ORDER .'.ECHEANCIER_ID,
                                        '. TABLE_ERP_ORDER .'.TRANSPORT_ID,
                                        '. TABLE_ERP_COMPANES .'.LABEL As CUSTOMER_LABEL,
                                        '. TABLE_ERP_CONDI_REG .'.LABEL AS COND_REG_LABEL,
                                        '. TABLE_ERP_MODE_REG .'.LABEL AS MODE_REG_LABEL,
                                        '. TABLE_ERP_ECHEANCIER_TYPE .'.LABEL AS ECHEANCIER_LABEL,
                                        '. TABLE_ERP_TRANSPORT .'.LABEL AS TRANSPORT_LABEL
                                        FROM `'. TABLE_ERP_ORDER_INVOICE .'`
                                           LEFT JOIN `'. TABLE_ERP_ORDER .'` ON `'. TABLE_ERP_ORDER_INVOICE .'`.`ORDER_ID` = `'. TABLE_ERP_ORDER .'`.`id`
                                            LEFT JOIN `'. TABLE_ERP_EMPLOYEES .'` ON `'. TABLE_ERP_ORDER_INVOICE .'`.`CREATOR_ID` = `'. TABLE_ERP_EMPLOYEES .'`.`idUSER`
                                            LEFT JOIN `'. TABLE_ERP_EMPLOYEES .'` AS  TABLE_ERP_EMPPLOYEES_RESP_COM ON `'. TABLE_ERP_ORDER .'`.`RESP_COM_ID` =  TABLE_ERP_EMPPLOYEES_RESP_COM.`idUSER`
                                            LEFT JOIN `'. TABLE_ERP_EMPLOYEES .'` AS TABLE_ERP_EMPPLOYEES_RESP_TECH ON `'. TABLE_ERP_ORDER .'`.`RESP_TECH_ID` = TABLE_ERP_EMPPLOYEES_RESP_TECH.`idUSER`
                                            LEFT JOIN `'. TABLE_ERP_COMPANES .'` ON `'. TABLE_ERP_ORDER .'`.`COMPANY_ID` = `'. TABLE_ERP_COMPANES .'`.`id`
                                            LEFT JOIN `'. TABLE_ERP_CONDI_REG .'` ON `'. TABLE_ERP_ORDER .'`.`COND_REG_COMPANY_ID` = `'. TABLE_ERP_CONDI_REG .'`.`id`
                                            LEFT JOIN `'. TABLE_ERP_MODE_REG .'` ON `'. TABLE_ERP_ORDER .'`.`MODE_REG_COMPANY_ID` = `'. TABLE_ERP_MODE_REG .'`.`id`
                                            LEFT JOIN `'. TABLE_ERP_ECHEANCIER_TYPE .'` ON `'. TABLE_ERP_ORDER .'`.`ECHEANCIER_ID` = `'. TABLE_ERP_ECHEANCIER_TYPE .'`.`id`
                                            LEFT JOIN `'. TABLE_ERP_TRANSPORT .'` ON `'. TABLE_ERP_ORDER .'`.`TRANSPORT_ID` = `'. TABLE_ERP_TRANSPORT .'`.`id`
                                        WHERE '. TABLE_ERP_ORDER_INVOICE .'.id = \''. $id_GET.'\' ', true, 'App\Order\InvoiceOrder');
        return $InvoiceOrder;
    }

    public function GETInvoiceOrderCount($ID = null, $Clause = null){
        
        if($ID != null){
            $Clause = 'WHERE id = \''. $ID .'\'';
        }

        $InvoiceOrderCount =  $this->GetCount(TABLE_ERP_ORDER_INVOICE,'id', $Clause);
        return $InvoiceOrderCount;
    }

    public function GETInvoiceOrderList($IdData=0, $Select = true, $OrderId=0){

        If($OrderId>0){
            $Clause = 'WHERE ORDER_ID = '. $OrderId .' ';
        }

        $this->InvoiceOrderList ='';
        $query='SELECT '. TABLE_ERP_ORDER_INVOICE .'.id,
                        '. TABLE_ERP_ORDER_INVOICE .'.CODE,
                        '. TABLE_ERP_ORDER_INVOICE .'.LABEL,
                        '. TABLE_ERP_ORDER_INVOICE .'.ETAT,
                        '. TABLE_ERP_COMPANES .'.LABEL As CUSTOMER_LABEL
                FROM '. TABLE_ERP_ORDER_INVOICE .'
                  LEFT JOIN `'. TABLE_ERP_ORDER .'` ON `'. TABLE_ERP_ORDER_INVOICE .'`.`ORDER_ID` = `'. TABLE_ERP_ORDER .'`.`id`
                  LEFT JOIN `'. TABLE_ERP_COMPANES .'` ON `'. TABLE_ERP_ORDER .'`.`COMPANY_ID` = `'. TABLE_ERP_COMPANES .'`.`id`
                  '. $Clause .'
                ORDER BY  '. TABLE_ERP_ORDER_INVOICE .'.id DESC';
              
        if($Select){
            foreach ($this->GetQuery($query) as $data){
            
                $this->InvoiceOrderList .='<option value="'. $data->Id .'" '. selected($IdData, $data->id) .'>'. $data->CODE .'</option>';
            }

            return  $this->InvoiceOrderList;

        }else {
            return  $this->GetQuery($query);
        }  
    }
}

class InvoiceOrderLines Extends InvoiceOrder  {

    Public $id;
    Public $ORDER_INVOICE_ID;
    Public $ORDER_ID;
    Public $ORDRE;
    Public $ORDER_LINE_ID;
    Public $ARTICLE_CODE;
    Public $LABEL;
    Public $QT;
    Public $UNIT_ID;
    Public $PRIX_U;
    Public $DISCOUNT;
    Public $TVA_ID;
    Public $DELAIS;
    Public $ORDER_ACKNOWLEGMENT_CODE;
    Public $ORDER_CODE;
    Public $TAUX;
    Public $LABEL_TVA;
    Public $LABEL_UNIT;
    Public $ETAT;
    
    Public $InvoiceOrderLines;

    public function NewInvoiceOrderLines($IdInvoiceOrder, $OrderID, $Order, $orderLineId, $QT_ToDelyvery){

        $NewInvoiceOrderLines = $this->GetInsert("INSERT INTO ". TABLE_ERP_ORDER_INVOICE_LINES ." VALUE ('0',
                                                                                        '". $IdInvoiceOrder ."',
                                                                                        '". addslashes($OrderID) ."',
                                                                                        '". addslashes($Order) ."',
                                                                                        '". addslashes($orderLineId) ."',
                                                                                        '". addslashes($QT_ToDelyvery) ."',
                                                                                        '1')");


        return $NewInvoiceOrderLines;
    }

    public function UpdateInvoiceOrderLines($id, $ORDRE){

        $UpdateInvoiceOrderLines = $this->GetUpdate("UPDATE  ". TABLE_ERP_ORDER_INVOICE_LINES ." SET 	ORDRE='". addslashes($ORDRE) ."' WHERE id='". addslashes($id)."'");

        return $UpdateInvoiceOrderLines;
    }

    public function GETInvoiceOrderLinesList($IdData=0, $Select = true, $IdInvoiceOrder=0){

        $this->InvoiceOrderLinesList ='';
        $Clause = 'WHERE '. TABLE_ERP_ORDER_INVOICE_LINES .'.ORDER_INVOICE_ID = \''. $IdInvoiceOrder.'\'';
        if($IdInvoiceOrder===0){
            $Clause = '';
        }
        $query='SELECT  '. TABLE_ERP_ORDER_INVOICE_LINES .'.id,
                        '. TABLE_ERP_ORDER_INVOICE_LINES .'.ORDER_INVOICE_ID,
                        '. TABLE_ERP_ORDER_INVOICE_LINES .'.ORDER_ID,
                        '. TABLE_ERP_ORDER_INVOICE_LINES .'.ORDRE,
                        '. TABLE_ERP_ORDER_INVOICE_LINES .'.ORDER_LINE_ID,
                        '. TABLE_ERP_ORDER_INVOICE_LINES .'.ETAT,
                        '. TABLE_ERP_ORDER_LIGNE .'.ARTICLE_CODE,
                        '. TABLE_ERP_ORDER_LIGNE .'.LABEL,
                        '. TABLE_ERP_ORDER_LIGNE .'.QT,
                        '. TABLE_ERP_ORDER_LIGNE .'.UNIT_ID,
                        '. TABLE_ERP_ORDER_LIGNE .'.PRIX_U,
                        '. TABLE_ERP_ORDER_LIGNE .'.DISCOUNT,
                        '. TABLE_ERP_ORDER_LIGNE .'.TVA_ID,
                        '. TABLE_ERP_ORDER_LIGNE .'.DELAIS,
                        '. TABLE_ERP_ORDER_ACKNOWLEGMENT .'.CODE AS ORDER_ACKNOWLEGMENT_CODE,
                        '. TABLE_ERP_ORDER .'.CODE AS ORDER_CODE,
                        '. TABLE_ERP_TVA .'.TAUX,
                        '. TABLE_ERP_TVA .'.LABEL AS LABEL_TVA,
                        '. TABLE_ERP_UNIT .'.LABEL AS LABEL_UNIT
                        FROM '. TABLE_ERP_ORDER_INVOICE_LINES .'
                            LEFT JOIN `'. TABLE_ERP_ORDER .'` ON `'. TABLE_ERP_ORDER_INVOICE_LINES .'`.`ORDER_ID` = `'. TABLE_ERP_ORDER .'`.`id`
                            LEFT JOIN `'. TABLE_ERP_ORDER_LIGNE .'` ON `'. TABLE_ERP_ORDER_INVOICE_LINES .'`.`ORDER_LINE_ID` = `'. TABLE_ERP_ORDER_LIGNE .'`.`id`
                            LEFT JOIN `'. TABLE_ERP_TVA .'` ON `'. TABLE_ERP_ORDER_LIGNE .'`.`TVA_ID` = `'. TABLE_ERP_TVA .'`.`id`
                            LEFT JOIN `'. TABLE_ERP_UNIT .'` ON `'. TABLE_ERP_ORDER_LIGNE .'`.`UNIT_ID` = `'. TABLE_ERP_UNIT .'`.`id`
                            LEFT JOIN `'. TABLE_ERP_ORDER_ACKNOWLEGMENT .'` ON `'. TABLE_ERP_ORDER_INVOICE_LINES .'`.`ORDER_INVOICE_ID` = `'. TABLE_ERP_ORDER_ACKNOWLEGMENT .'`.`id` 
                            '. $Clause.'
                        ORDER BY '. TABLE_ERP_ORDER_INVOICE_LINES .'.ORDRE ';
          
        if($Select){
            foreach ($this->GetQuery($query) as $data){
            
                $this->InvoiceOrderLinesList .='<option value="'. $data->id .'" '. selected($IdData, $data->id) .'>'. $data->ORDER_ACKNOWLEGMENT_CODE .' - '. $data->CODE .'</option>';
            }

            return  $this->InvoiceOrderLinesList;

        }else {
            
            return  $this->GetQuery($query);
        }  
    }
}