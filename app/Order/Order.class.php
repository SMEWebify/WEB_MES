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
    Public $MODE_REG_CUSTOMER_ID;
    Public $ECHEANCIER_ID;
    Public $TRANSPORT_ID;
    Public $COMMENT;
    Public $QUOTE_ID;
    Public $QUOTE_CODE;
    Public $CUSTOMER_NAME;
    Public $NOM;
    Public $PRENOM;

    Public $Order;

    public function NewOrder($CODE, $LABEL='',$CutomerID, $CONTACT_ID='0' , $ADRESSE_ID=0 , $FACTURATION_ID=0 , $UserID, $RESP_COM_ID=0 ,$RESP_TECH_ID=0 ,$COND_REG_CUSTOMER_ID=9 ,$MODE_REG_CUSTOMER_ID=5 ,$ECHEANCIER_ID=0 ,$TRANSPORT_ID=0, $QUOTE_ID=0){

        $NewOrder = $this->GetInsert("INSERT INTO ". TABLE_ERP_COMMANDE ." VALUE ('0',
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

        $Order = $this->GetQuery('SELECT '. TABLE_ERP_COMMANDE .'.id,
                                        '. TABLE_ERP_COMMANDE .'.CODE,
                                        '. TABLE_ERP_COMMANDE .'.INDICE,
                                        '. TABLE_ERP_COMMANDE .'.LABEL,
                                        '. TABLE_ERP_COMMANDE .'.LABEL_INDICE,
                                        '. TABLE_ERP_COMMANDE .'.CUSTOMER_ID,
                                        '. TABLE_ERP_COMMANDE .'.CONTACT_ID,
                                        '. TABLE_ERP_COMMANDE .'.ADRESSE_ID,
                                        '. TABLE_ERP_COMMANDE .'.FACTURATION_ID,
                                        '. TABLE_ERP_COMMANDE .'.DATE,
                                        '. TABLE_ERP_COMMANDE .'.ETAT,
                                        '. TABLE_ERP_COMMANDE .'.CREATEUR_ID,
                                        '. TABLE_ERP_COMMANDE .'.RESP_COM_ID,
                                        '. TABLE_ERP_COMMANDE .'.RESP_TECH_ID,
                                        '. TABLE_ERP_COMMANDE .'.REFERENCE,
                                        '. TABLE_ERP_COMMANDE .'.COND_REG_CUSTOMER_ID,
                                        '. TABLE_ERP_COMMANDE .'.MODE_REG_CUSTOMER_ID,
                                        '. TABLE_ERP_COMMANDE .'.ECHEANCIER_ID,
                                        '. TABLE_ERP_COMMANDE .'.TRANSPORT_ID,
                                        '. TABLE_ERP_COMMANDE .'.COMENT,
                                        '. TABLE_ERP_COMMANDE .'.QUOTE_ID,
                                        '. TABLE_ERP_CLIENT_FOUR .'.NAME AS CUSTOMER_NAME,
                                        '. TABLE_ERP_EMPLOYEES .'.NOM,
                                        '. TABLE_ERP_EMPLOYEES .'.PRENOM,
                                        '. TABLE_ERP_DEVIS .'.CODE AS QUOTE_CODE
                                        FROM `'. TABLE_ERP_COMMANDE .'`
                                            LEFT JOIN `'. TABLE_ERP_CLIENT_FOUR .'` ON `'. TABLE_ERP_COMMANDE .'`.`CUSTOMER_ID` = `'. TABLE_ERP_CLIENT_FOUR .'`.`id`
                                            LEFT JOIN `'. TABLE_ERP_EMPLOYEES .'` ON `'. TABLE_ERP_COMMANDE .'`.`CREATEUR_ID` = `'. TABLE_ERP_EMPLOYEES .'`.`idUSER`
                                            LEFT JOIN `'. TABLE_ERP_DEVIS .'` ON `'. TABLE_ERP_COMMANDE .'`.`QUOTE_ID` = `'. TABLE_ERP_DEVIS .'`.`id`
                                        WHERE '. TABLE_ERP_COMMANDE .'.id = \''. $id_GET.'\' ', true, 'App\Order\Order');
        return $Order;
    }

    public function GETOrderCount($ID = null, $Clause = null){
        
        if($ID != null){
            $Clause = 'WHERE id = \''. $ID .'\'';
        }

        $OrderCount =  $this->GetCount(TABLE_ERP_COMMANDE,'id', $Clause);
        return $OrderCount;
    }

    public function GETOrderList($IdData=0, $Select = true){

        $this->OrderList ='';
        $query='SELECT '. TABLE_ERP_COMMANDE .'.id,
                        '. TABLE_ERP_COMMANDE .'.CODE,
                        '. TABLE_ERP_COMMANDE .'.LABEL,
                        '. TABLE_ERP_CLIENT_FOUR .'.NAME
                FROM '. TABLE_ERP_COMMANDE .'
                    LEFT JOIN `'. TABLE_ERP_CLIENT_FOUR .'` ON `'. TABLE_ERP_COMMANDE .'`.`CUSTOMER_ID` = `'. TABLE_ERP_CLIENT_FOUR .'`.`id`
                ORDER BY  '. TABLE_ERP_COMMANDE .'.id DESC';
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

    public function NewOrderLine($IdOrder, $ORDRE, $ARTICLE_CODE, $LABEL, $QT, $UNIT_ID, $PRIX_U, $REMISE, $TVA_ID, $DELAIS){

        $NewOrderLine = $this->GetInsert("INSERT INTO ". TABLE_ERP_COMMANDE_LIGNE ." VALUE ('0',
                                                                                        '". $IdOrder ."',
                                                                                        '". addslashes($ORDRE) ."',
                                                                                        '". addslashes($ARTICLE_CODE) ."',
                                                                                        '". addslashes($LABEL) ."',
                                                                                        '". addslashes($QT) ."',
                                                                                        '". addslashes($UNIT_ID) ."',
                                                                                        '". addslashes($PRIX_U) ."',
                                                                                        '". addslashes($REMISE) ."',
                                                                                        '". addslashes($TVA_ID) ."',
                                                                                        '". addslashes($DELAIS) ."',
                                                                                        '". addslashes($DELAIS) ."',
                                                                                        '1',
                                                                                        '0')");


        return $NewOrderLine;
    }

    public function UpdateOrderLine($id, $ORDRE, $ARTICLE_CODE, $LABEL, $QT, $UNIT_ID, $PRIX_U, $REMISE, $TVA_ID, $DELAIS, $ETAT){

        $UpdateOrderLine = $this->GetUpdate("UPDATE  ". TABLE_ERP_COMMANDE_LIGNE ." SET 	ORDRE='". addslashes($ORDRE) ."',
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
        $Clause = 'WHERE '. TABLE_ERP_COMMANDE_LIGNE .'.ORDER_ID = \''. addslashes($IdOrder).'\'';
        if($IdOrder===0){
            $Clause = '';
        }elseif(!empty($AddClause)){
            $Clause .= $AddClause;
        }

        $query='SELECT  '. TABLE_ERP_COMMANDE_LIGNE .'.id,
                        '. TABLE_ERP_COMMANDE_LIGNE .'.ORDER_ID,
                        '. TABLE_ERP_COMMANDE_LIGNE .'.ORDRE,
                        '. TABLE_ERP_COMMANDE_LIGNE .'.ARTICLE_CODE,
                        '. TABLE_ERP_COMMANDE_LIGNE .'.LABEL,
                        '. TABLE_ERP_COMMANDE_LIGNE .'.QT,
                        '. TABLE_ERP_COMMANDE_LIGNE .'.UNIT_ID,
                        '. TABLE_ERP_COMMANDE_LIGNE .'.PRIX_U,
                        '. TABLE_ERP_COMMANDE_LIGNE .'.REMISE,
                        '. TABLE_ERP_COMMANDE_LIGNE .'.TVA_ID,
                        '. TABLE_ERP_COMMANDE_LIGNE .'.DELAIS_INTERNE,
                        '. TABLE_ERP_COMMANDE_LIGNE .'.DELAIS,
                        '. TABLE_ERP_COMMANDE_LIGNE .'.ETAT,
                        '. TABLE_ERP_COMMANDE_LIGNE .'.AR,
                        '. TABLE_ERP_COMMANDE .'.CODE AS ORDER_CODE,
                        '. TABLE_ERP_TVA .'.TAUX,
                        '. TABLE_ERP_TVA .'.LABEL AS LABEL_TVA,
                        '. TABLE_ERP_UNIT .'.LABEL AS LABEL_UNIT
                        FROM '. TABLE_ERP_COMMANDE_LIGNE .'
                            LEFT JOIN `'. TABLE_ERP_TVA .'` ON `'. TABLE_ERP_COMMANDE_LIGNE .'`.`TVA_ID` = `'. TABLE_ERP_TVA .'`.`id`
                            LEFT JOIN `'. TABLE_ERP_UNIT .'` ON `'. TABLE_ERP_COMMANDE_LIGNE .'`.`UNIT_ID` = `'. TABLE_ERP_UNIT .'`.`id`
                            LEFT JOIN `'. TABLE_ERP_COMMANDE .'` ON `'. TABLE_ERP_COMMANDE_LIGNE .'`.`ORDER_ID` = `'. TABLE_ERP_COMMANDE .'`.`id`
                            '. $Clause.'
                        ORDER BY '. TABLE_ERP_COMMANDE_LIGNE .'.ORDRE ';
          
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