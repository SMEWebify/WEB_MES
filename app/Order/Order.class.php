<?php

namespace App\Order;
use \App\SQL;

class Order Extends SQL  {

    Public $id;
    Public $CODE;
    Public $INDICE;
    Public $LABEL;
    Public $LABEL_INDICE;
    Public $CUSTOMER_ID;
    Public $CONTACT_ID;
    Public $ADRESSE_ID;
    Public $FACTURATION_ID;
    Public $DATE;
    Public $ETAT;
    Public $CREATEUR_ID;
    Public $RESP_COM_ID;
    Public $RESP_TECH_ID;
    Public $REFERENCE;
    Public $COND_REG_CUSTOMER_ID;
    Public $COND_REG_LABEL;
    Public $MODE_REG_CUSTOMER_ID;
    Public $MODE_REG_LABEL;
    Public $ECHEANCIER_ID;
    Public $ECHEANCIER_LABEL;
    Public $TRANSPORT_ID;
    Public $TRANSPORT_LABEL;
    Public $COMMENT;
    Public $QUOTE_ID;
    Public $QUOTE_CODE;
    Public $CUSTOMER_NAME;
    Public $NOM_CREATOR;
    Public $PRENOM_CREATOR;
    Public $NOM_RESP_COM;
    Public $PRENOM_RESP_COM;
    Public $NOM_RESP_TECH;
    Public $PRENOM_RESP_TECH;

    Public $Order;

    public function NewOrder($CODE, $LABEL='',$CutomerID, $CONTACT_ID='0' , $ADRESSE_ID=0 , $FACTURATION_ID=0 , $UserID, $RESP_COM_ID=0 ,$RESP_TECH_ID=0 ,$COND_REG_CUSTOMER_ID=9 ,$MODE_REG_CUSTOMER_ID=5 ,$ECHEANCIER_ID=0 ,$TRANSPORT_ID=0, $QUOTE_ID=0){

        $NewOrder = $this->GetInsert("INSERT INTO ". TABLE_ERP_ORDER ." VALUE ('0',
                                                                                    '". $CODE ."',
                                                                                    '1',
                                                                                    '". $LABEL ."',
                                                                                    '',
                                                                                    '". addslashes($CutomerID) ."',
                                                                                    '". $CONTACT_ID ."',
                                                                                    '". $ADRESSE_ID ."',
                                                                                    '". $FACTURATION_ID ."',
                                                                                    NOW(),
                                                                                    '1',
                                                                                    '". $UserID ."',
                                                                                    '". $RESP_COM_ID ."',
                                                                                    '". $RESP_TECH_ID ."',
                                                                                    '',
                                                                                    '". $COND_REG_CUSTOMER_ID ."',
                                                                                    '". $MODE_REG_CUSTOMER_ID ."',
                                                                                    '". $ECHEANCIER_ID ."',
                                                                                    '". $TRANSPORT_ID ."',
                                                                                    '',
                                                                                    '". $QUOTE_ID ."')");
                                                                                    
        return $NewOrder;
    }

    public function GETOrder($id_GET){

        if($this-> GETOrderCount($id_GET) == 0){ header('Location: index.php?page=order'); }

        $Order = $this->GetQuery('SELECT '. TABLE_ERP_ORDER .'.id,
                                        '. TABLE_ERP_ORDER .'.CODE,
                                        '. TABLE_ERP_ORDER .'.INDICE,
                                        '. TABLE_ERP_ORDER .'.LABEL,
                                        '. TABLE_ERP_ORDER .'.LABEL_INDICE,
                                        '. TABLE_ERP_ORDER .'.CUSTOMER_ID,
                                        '. TABLE_ERP_ORDER .'.CONTACT_ID,
                                        '. TABLE_ERP_ORDER .'.ADRESSE_ID,
                                        '. TABLE_ERP_ORDER .'.FACTURATION_ID,
                                        '. TABLE_ERP_ORDER .'.DATE,
                                        '. TABLE_ERP_ORDER .'.ETAT,
                                        '. TABLE_ERP_ORDER .'.CREATEUR_ID,
                                        '. TABLE_ERP_ORDER .'.RESP_COM_ID,
                                        '. TABLE_ERP_ORDER .'.RESP_TECH_ID,
                                        '. TABLE_ERP_ORDER .'.REFERENCE,
                                        '. TABLE_ERP_ORDER .'.COND_REG_CUSTOMER_ID,
                                        '. TABLE_ERP_ORDER .'.MODE_REG_CUSTOMER_ID,
                                        '. TABLE_ERP_ORDER .'.ECHEANCIER_ID,
                                        '. TABLE_ERP_ORDER .'.TRANSPORT_ID,
                                        '. TABLE_ERP_ORDER .'.COMENT,
                                        '. TABLE_ERP_ORDER .'.QUOTE_ID,
                                        '. TABLE_ERP_CLIENT_FOUR .'.NAME AS CUSTOMER_NAME,
                                        '. TABLE_ERP_EMPLOYEES .'.NOM AS NOM_CREATOR,
                                        '. TABLE_ERP_EMPLOYEES .'.PRENOM  AS PRENOM_CREATOR,
                                        TABLE_ERP_EMPPLOYEES_RESP_COM.NOM AS NOM_RESP_COM,
                                        TABLE_ERP_EMPPLOYEES_RESP_COM.PRENOM  AS PRENOM_RESP_COM,
                                        TABLE_ERP_EMPPLOYEES_RESP_TECH.NOM AS NOM_RESP_TECH,
                                        TABLE_ERP_EMPPLOYEES_RESP_TECH.PRENOM  AS PRENOM_RESP_TECH,
                                        '. TABLE_ERP_QUOTE .'.CODE AS QUOTE_CODE,
                                        '. TABLE_ERP_CONDI_REG .'.LABEL AS COND_REG_LABEL,
                                        '. TABLE_ERP_MODE_REG .'.LABEL AS MODE_REG_LABEL,
                                        '. TABLE_ERP_ECHEANCIER_TYPE .'.LABEL AS ECHEANCIER_LABEL,
                                        '. TABLE_ERP_TRANSPORT .'.LABEL AS TRANSPORT_LABEL
                                        FROM `'. TABLE_ERP_ORDER .'`
                                            LEFT JOIN `'. TABLE_ERP_CLIENT_FOUR .'` ON `'. TABLE_ERP_ORDER .'`.`CUSTOMER_ID` = `'. TABLE_ERP_CLIENT_FOUR .'`.`id`
                                            LEFT JOIN `'. TABLE_ERP_EMPLOYEES .'` ON `'. TABLE_ERP_ORDER .'`.`CREATEUR_ID` = `'. TABLE_ERP_EMPLOYEES .'`.`idUSER`
                                            LEFT JOIN `'. TABLE_ERP_EMPLOYEES .'` AS  TABLE_ERP_EMPPLOYEES_RESP_COM ON `'. TABLE_ERP_ORDER .'`.`RESP_COM_ID` =  TABLE_ERP_EMPPLOYEES_RESP_COM.`idUSER`
                                            LEFT JOIN `'. TABLE_ERP_EMPLOYEES .'` AS TABLE_ERP_EMPPLOYEES_RESP_TECH ON `'. TABLE_ERP_ORDER .'`.`RESP_TECH_ID` = TABLE_ERP_EMPPLOYEES_RESP_TECH.`idUSER`
                                            LEFT JOIN `'. TABLE_ERP_QUOTE .'` ON `'. TABLE_ERP_ORDER .'`.`QUOTE_ID` = `'. TABLE_ERP_QUOTE .'`.`id`
                                            LEFT JOIN `'. TABLE_ERP_CONDI_REG .'` ON `'. TABLE_ERP_ORDER .'`.`COND_REG_CUSTOMER_ID` = `'. TABLE_ERP_CONDI_REG .'`.`id`
                                            LEFT JOIN `'. TABLE_ERP_MODE_REG .'` ON `'. TABLE_ERP_ORDER .'`.`MODE_REG_CUSTOMER_ID` = `'. TABLE_ERP_MODE_REG .'`.`id`
                                            LEFT JOIN `'. TABLE_ERP_ECHEANCIER_TYPE .'` ON `'. TABLE_ERP_ORDER .'`.`ECHEANCIER_ID` = `'. TABLE_ERP_ECHEANCIER_TYPE .'`.`id`
                                            LEFT JOIN `'. TABLE_ERP_TRANSPORT .'` ON `'. TABLE_ERP_ORDER .'`.`TRANSPORT_ID` = `'. TABLE_ERP_TRANSPORT .'`.`id`
                                        WHERE '. TABLE_ERP_ORDER .'.id = \''. $id_GET.'\' ', true, 'App\Order\Order');
        return $Order;
    }

    public function GETOrderCount($ID = null, $Clause = null){
        
        if($ID != null){
            $Clause = 'WHERE id = \''. $ID .'\'';
        }

        $OrderCount =  $this->GetCount(TABLE_ERP_ORDER,'id', $Clause);
        return $OrderCount;
    }

    public function GETOrderList($IdData=0, $Select = true){

        $this->OrderList ='';
        $query='SELECT '. TABLE_ERP_ORDER .'.id,
                        '. TABLE_ERP_ORDER .'.CODE,
                        '. TABLE_ERP_ORDER .'.LABEL,
                        '. TABLE_ERP_ORDER .'.ETAT,
                        '. TABLE_ERP_CLIENT_FOUR .'.NAME
                FROM '. TABLE_ERP_ORDER .'
                    LEFT JOIN `'. TABLE_ERP_CLIENT_FOUR .'` ON `'. TABLE_ERP_ORDER .'`.`CUSTOMER_ID` = `'. TABLE_ERP_CLIENT_FOUR .'`.`id`
                ORDER BY  '. TABLE_ERP_ORDER .'.id DESC';
        if($Select){
            foreach ($this->GetQuery($query) as $data){
            
                $this->OrderList .='<option value="'. $data->Id .'" '. selected($IdData, $data->id) .'>'. $data->CODE .'</option>';
            }

            return  $this->OrderList;

        }else {
            return  $this->GetQuery($query);
        }  
    }
}

class OrderLines Extends Order  {

    Public $id;
    Public $ORDER_ID;
    Public $ORDRE;
    Public $ARTICLE_CODE;
    Public $LABEL;
    Public $QT;
    Public $DELIVERED_QTY;
    Public $DELIVERED_REMAINING_QTY;
    Public $INVOICED_QTY;
    Public $INVOICED_REMAINING_QTY;
    Public $UNIT_ID;
    Public $ADRESSE_ID;
    Public $PRIX_U;
    Public $REMISE;
    Public $TVA_ID;
    Public $DELAIS_INTERNE;
    Public $DELAIS;
    Public $ETAT;
    Public $AR;
    
    Public $OrderLine;

    public function NewOrderLine($IdOrder, $ORDRE, $ARTICLE_CODE, $LABEL, $QT, $UNIT_ID, $PRIX_U, $REMISE, $TVA_ID, $DELAIS,$IDQuoteLine){
        
        $NewOrderLine = $this->GetInsert("INSERT INTO ". TABLE_ERP_ORDER_LIGNE ." VALUE ('0',
                                                                                        '". $IdOrder ."',
                                                                                        '". addslashes($ORDRE) ."',
                                                                                        '". addslashes($ARTICLE_CODE) ."',
                                                                                        '". addslashes($LABEL) ."',
                                                                                        '". addslashes($QT) ."',
                                                                                        '0',
                                                                                        '". addslashes($QT) ."',
                                                                                        '0',
                                                                                        '". addslashes($QT) ."',
                                                                                        '". addslashes($UNIT_ID) ."',
                                                                                        '". addslashes($PRIX_U) ."',
                                                                                        '". addslashes($REMISE) ."',
                                                                                        '". addslashes($TVA_ID) ."',
                                                                                        '". addslashes($DELAIS) ."',
                                                                                        '". addslashes($DELAIS) ."',
                                                                                        '1',
                                                                                        '0')");
    }

    public function NewOrderLineFromQuote($IdOrder,$IDQuoteLine, $UserID){
        
         $NewOrderLine = $this->GetInsert("INSERT INTO ". TABLE_ERP_ORDER_LIGNE ." (ORDER_ID,
                                                                                    ORDRE,
                                                                                    ARTICLE_CODE,
                                                                                    LABEL,
                                                                                    QT,
                                                                                    DELIVERED_QTY,
                                                                                    DELIVERED_REMAINING_QTY,
                                                                                    INVOICED_QTY,
                                                                                    INVOICED_REMAINING_QTY,
                                                                                    UNIT_ID,
                                                                                    PRIX_U,
                                                                                    REMISE,
                                                                                    TVA_ID,
                                                                                    DELAIS_INTERNE,
                                                                                    DELAIS,
                                                                                    ETAT,
                                                                                    AR)
                                                                                        SELECT
                                                                                            '". $IdOrder ."',
                                                                                            ORDRE,
                                                                                            ARTICLE_CODE,
                                                                                            LABEL,
                                                                                            QT,
                                                                                            '0',
                                                                                            QT,
                                                                                            '0',
                                                                                            QT,
                                                                                            UNIT_ID,
                                                                                            PRIX_U,
                                                                                            REMISE,
                                                                                            TVA_ID,
                                                                                            DELAIS,
                                                                                            DELAIS,
                                                                                            '1',
                                                                                            '0'
                                                                                    FROM 
                                                                                        ". TABLE_ERP_QUOTE_LIGNE ." 
                                                                                    WHERE  
                                                                                    id = '". $IDQuoteLine ."'");

        $this->GetInsert("INSERT INTO ". TABLE_ERP_TASK ." (`LABEL`, 
                                                            `ORDER`, 
                                                            `ORDER_LINE_ID`,
                                                            `SERVICE_ID`, 
                                                            `ARTICLE_ID`, 
                                                            `SETING_TIME`, 
                                                            `UNIT_TIME`, 
                                                            `ETAT`, 
                                                            `TYPE`,
                                                            `QTY`,
                                                            `UNIT_COST`,
                                                            `UNIT_PRICE`,
                                                            `UNIT_ID`,
                                                            `CREATOR_ID`) 
                                                                SELECT 
                                                                `LABEL`,
                                                                    `ORDER`, 
                                                                    '". $NewOrderLine ."',
                                                                    `SERVICE_ID`, 
                                                                    `ARTICLE_ID`, 
                                                                    `SETING_TIME`, 
                                                                    `UNIT_TIME`, 
                                                                    '1', 
                                                                    `TYPE`,
                                                                    `QTY`,
                                                                    `UNIT_COST`,
                                                                    `UNIT_PRICE`,
                                                                    `UNIT_ID`,
                                                                    '". $UserID ."'
                                                                FROM 
                                                                    ". TABLE_ERP_TASK ." 
                                                                WHERE  
                                                                    QUOTE_LINE_ID = '". $IDQuoteLine ."'");

         $this->GetInsert("INSERT INTO ". TABLE_ERP_ORDER_SUB_ASSEMBLY ." ( PARENT_ID, 
                                                                            ORDRE, 
                                                                            ARTICLE_ID,
                                                                            QT) 
                                                                            SELECT 
                                                                                '". $NewOrderLine ."', 
                                                                                ORDRE, 
                                                                                ARTICLE_ID, 
                                                                                QT 
                                                                            FROM 
                                                                                ". TABLE_ERP_QUOTE_SUB_ASSEMBLY ." 
                                                                            WHERE 
                                                                             PARENT_ID = '". $IDQuoteLine ."'");                                                                                        
        return $NewOrderLine;
    }

    public function UpdateOrderLine($id, $ORDRE, $ARTICLE_CODE, $LABEL, $QT, $UNIT_ID, $PRIX_U, $REMISE, $TVA_ID, $DELAIS, $ETAT){

        $UpdateOrderLine = $this->GetUpdate("UPDATE  ". TABLE_ERP_ORDER_LIGNE ." SET 	ORDRE='". addslashes($ORDRE) ."',
                                                                                        ARTICLE_CODE='". addslashes($ARTICLE_CODE) ."',
                                                                                        LABEL='". addslashes($LABEL) ."',
                                                                                        QT='". addslashes($QT) ."',
                                                                                        UNIT_ID='". addslashes($UNIT_ID) ."',
                                                                                        PRIX_U='". addslashes($PRIX_U) ."',
                                                                                        REMISE='". addslashes($REMISE) ."',
                                                                                        TVA_ID='". addslashes($TVA_ID) ."',
                                                                                        DELAIS='". addslashes($DELAIS) ."',
                                                                                        ETAT='". addslashes($ETAT) ."'
                                                                                        WHERE id='". addslashes($id)."'");

        return $UpdateOrderLine;
    }

    public function GETOrderLineList($IdData=0, $Select = true, $IdOrder=0, $AddClause=''){

        $this->OrderLineList ='';
        $Clause = 'WHERE '. TABLE_ERP_ORDER_LIGNE .'.ORDER_ID = \''. addslashes($IdOrder).'\'';
        if($IdOrder===0){
            $Clause = '';
        }elseif(!empty($AddClause)){
            $Clause .= $AddClause;
        }

        $query='SELECT  '. TABLE_ERP_ORDER_LIGNE .'.id,
                        '. TABLE_ERP_ORDER_LIGNE .'.ORDER_ID,
                        '. TABLE_ERP_ORDER_LIGNE .'.ORDRE,
                        '. TABLE_ERP_ORDER_LIGNE .'.ARTICLE_CODE,
                        '. TABLE_ERP_ORDER_LIGNE .'.LABEL,
                        '. TABLE_ERP_ORDER_LIGNE .'.QT,
                        '. TABLE_ERP_ORDER_LIGNE .'.UNIT_ID,
                        '. TABLE_ERP_ORDER_LIGNE .'.PRIX_U,
                        '. TABLE_ERP_ORDER_LIGNE .'.REMISE,
                        '. TABLE_ERP_ORDER_LIGNE .'.TVA_ID,
                        '. TABLE_ERP_ORDER_LIGNE .'.DELAIS_INTERNE,
                        '. TABLE_ERP_ORDER_LIGNE .'.DELAIS,
                        '. TABLE_ERP_ORDER_LIGNE .'.ETAT,
                        '. TABLE_ERP_ORDER_LIGNE .'.AR,
                        '. TABLE_ERP_ORDER .'.CODE AS ORDER_CODE,
                        '. TABLE_ERP_TVA .'.TAUX,
                        '. TABLE_ERP_TVA .'.LABEL AS LABEL_TVA,
                        '. TABLE_ERP_UNIT .'.LABEL AS LABEL_UNIT
                        FROM '. TABLE_ERP_ORDER_LIGNE .'
                            LEFT JOIN `'. TABLE_ERP_TVA .'` ON `'. TABLE_ERP_ORDER_LIGNE .'`.`TVA_ID` = `'. TABLE_ERP_TVA .'`.`id`
                            LEFT JOIN `'. TABLE_ERP_UNIT .'` ON `'. TABLE_ERP_ORDER_LIGNE .'`.`UNIT_ID` = `'. TABLE_ERP_UNIT .'`.`id`
                            LEFT JOIN `'. TABLE_ERP_ORDER .'` ON `'. TABLE_ERP_ORDER_LIGNE .'`.`ORDER_ID` = `'. TABLE_ERP_ORDER .'`.`id`
                            '. $Clause.'
                        ORDER BY '. TABLE_ERP_ORDER_LIGNE .'.ORDRE ';
          
        if($Select){
            foreach ($this->GetQuery($query) as $data){
            
                $this->OrderLineList .='<option value="'. $data->id .'" '. selected($IdData, $data->id) .'>'. $data->CODE .'</option>';
            }

            return  $this->OrderLineList;

        }else {
            
            return  $this->GetQuery($query);
        }  
    }
}