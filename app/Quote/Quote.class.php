<?php

namespace App\Quote;
use \App\SQL;

class Quote Extends SQL  {

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
    Public $DATE_VALIDITE;
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
    Public $CUSTOMER_NAME;
    Public $NOM;
    Public $PRENOM;

    Public $Quote;

    public function NewQuote($CODE, $CutomerID, $UserID){

        $NewQuote = $this->GetInsert("INSERT INTO ". TABLE_ERP_QUOTE ." VALUE ('0', '". $CODE ."','1','','','". $CutomerID ."','0','0','0',
																				NOW(),NOW(),'1','". $UserID ."','0','0','','9','5','0','0','')");

        return $NewQuote;
    }

    public function GETQuote($id_GET){

        if($this-> GETQuoteCount($id_GET) == 0){ header('Location: index.php?page=quote'); }

        $Quote = $this->GetQuery('SELECT '. TABLE_ERP_QUOTE .'.id,
                                        '. TABLE_ERP_QUOTE .'.CODE,
                                        '. TABLE_ERP_QUOTE .'.INDICE,
                                        '. TABLE_ERP_QUOTE .'.LABEL,
                                        '. TABLE_ERP_QUOTE .'.LABEL_INDICE,
                                        '. TABLE_ERP_QUOTE .'.CUSTOMER_ID,
                                        '. TABLE_ERP_QUOTE .'.CONTACT_ID,
                                        '. TABLE_ERP_QUOTE .'.ADRESSE_ID,
                                        '. TABLE_ERP_QUOTE .'.FACTURATION_ID,
                                        '. TABLE_ERP_QUOTE .'.DATE,
                                        '. TABLE_ERP_QUOTE .'.DATE_VALIDITE,
                                        '. TABLE_ERP_QUOTE .'.ETAT,
                                        '. TABLE_ERP_QUOTE .'.CREATEUR_ID,
                                        '. TABLE_ERP_QUOTE .'.RESP_COM_ID,
                                        '. TABLE_ERP_QUOTE .'.RESP_TECH_ID,
                                        '. TABLE_ERP_QUOTE .'.REFERENCE,
                                        '. TABLE_ERP_QUOTE .'.COND_REG_CUSTOMER_ID,
                                        '. TABLE_ERP_QUOTE .'.MODE_REG_CUSTOMER_ID,
                                        '. TABLE_ERP_QUOTE .'.ECHEANCIER_ID,
                                        '. TABLE_ERP_QUOTE .'.TRANSPORT_ID,
                                        '. TABLE_ERP_QUOTE .'.COMENT,
                                        '. TABLE_ERP_CLIENT_FOUR .'.NAME AS CUSTOMER_NAME,
                                        '. TABLE_ERP_EMPLOYEES .'.NOM,
                                        '. TABLE_ERP_EMPLOYEES .'.PRENOM
                                        FROM `'. TABLE_ERP_QUOTE .'`
                                            LEFT JOIN `'. TABLE_ERP_CLIENT_FOUR .'` ON `'. TABLE_ERP_QUOTE .'`.`CUSTOMER_ID` = `'. TABLE_ERP_CLIENT_FOUR .'`.`id`
                                            LEFT JOIN `'. TABLE_ERP_EMPLOYEES .'` ON `'. TABLE_ERP_QUOTE .'`.`CREATEUR_ID` = `'. TABLE_ERP_EMPLOYEES .'`.`idUSER`
                                        WHERE '. TABLE_ERP_QUOTE .'.id = \''. $id_GET.'\' ', true, 'App\Quote\Quote');
        return $Quote;
    }

    public function GETQuoteCount($ID = null, $Clause = null){
        
        if($ID != null){
            $Clause = 'WHERE id = \''. $ID .'\'';
        }

        $QuoteCount =  $this->GetCount(TABLE_ERP_QUOTE,'id', $Clause);
        return $QuoteCount;
    }

    public function GETQuoteList($IdData=0, $Select = true){

        $this->QuoteList ='';
        $query='SELECT '. TABLE_ERP_QUOTE .'.id,
                        '. TABLE_ERP_QUOTE .'.CODE,
                        '. TABLE_ERP_QUOTE .'.LABEL,
                        '. TABLE_ERP_QUOTE .'.ETAT,
                        '. TABLE_ERP_CLIENT_FOUR .'.NAME
                FROM '. TABLE_ERP_QUOTE .'
                LEFT JOIN `'. TABLE_ERP_CLIENT_FOUR .'` ON `'. TABLE_ERP_QUOTE .'`.`CUSTOMER_ID` = `'. TABLE_ERP_CLIENT_FOUR .'`.`id`
                ORDER BY  '. TABLE_ERP_QUOTE .'.id DESC';
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

class QuoteLines Extends Quote  {

    Public $id;
    Public $DEVIS_ID;
    Public $ORDRE;
    Public $ARTICLE_CODE;
    Public $LABEL;
    Public $QT;
    Public $UNIT_ID;
    Public $ADRESSE_ID;
    Public $PRIX_U;
    Public $REMISE;
    Public $TVA_ID;
    Public $DELAIS;
    Public $ETAT;

    Public $QuoteLine;

    public function NewQuoteLine($IdQuote, $ORDRE, $ARTICLE_CODE, $LABEL, $QT, $UNIT_ID, $PRIX_U, $REMISE, $TVA_ID, $DELAIS){

        $NewQuoteLine = $this->GetInsert("INSERT INTO ". TABLE_ERP_QUOTE_LIGNE ." VALUE ('0',
                                                                                        '". $IdQuote ."',
                                                                                        '". addslashes($ORDRE) ."',
                                                                                        '". addslashes($ARTICLE_CODE) ."',
                                                                                        '". addslashes($LABEL) ."',
                                                                                        '". addslashes($QT) ."',
                                                                                        '". addslashes($UNIT_ID) ."',
                                                                                        '". addslashes($PRIX_U) ."',
                                                                                        '". addslashes($REMISE) ."',
                                                                                        '". addslashes($TVA_ID) ."',
                                                                                        '". addslashes($DELAIS) ."',
                                                                                        '1')");

                      

        return $NewQuoteLine;
    }

    public function UpdateQuoteLine($id, $ORDRE, $ARTICLE_CODE, $LABEL, $QT, $UNIT_ID, $PRIX_U, $REMISE, $TVA_ID, $DELAIS, $ETAT){

        $UpdateQuoteLine = $this->GetUpdate("UPDATE  ". TABLE_ERP_QUOTE_LIGNE ." SET 	ORDRE='". addslashes($ORDRE) ."',
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

        return $UpdateQuoteLine;
    }

    public function GETQuoteLineList($IdData=0, $Select = true, $IdQuote=0){

        $this->QuoteLineList ='';
        $Clause = 'WHERE '. TABLE_ERP_QUOTE_LIGNE .'.DEVIS_ID = \''. $IdQuote.'\'';
        if($IdQuote===0){
            $Clause = '';
        }
        $query='SELECT  '. TABLE_ERP_QUOTE_LIGNE .'.id,
                        '. TABLE_ERP_QUOTE_LIGNE .'.DEVIS_ID,
                        '. TABLE_ERP_QUOTE_LIGNE .'.ORDRE,
                        '. TABLE_ERP_QUOTE_LIGNE .'.ARTICLE_CODE,
                        '. TABLE_ERP_QUOTE_LIGNE .'.LABEL,
                        '. TABLE_ERP_QUOTE_LIGNE .'.QT,
                        '. TABLE_ERP_QUOTE_LIGNE .'.UNIT_ID,
                        '. TABLE_ERP_QUOTE_LIGNE .'.PRIX_U,
                        '. TABLE_ERP_QUOTE_LIGNE .'.REMISE,
                        '. TABLE_ERP_QUOTE_LIGNE .'.TVA_ID,
                        '. TABLE_ERP_QUOTE_LIGNE .'.DELAIS,
                        '. TABLE_ERP_QUOTE_LIGNE .'.ETAT,
                        '. TABLE_ERP_QUOTE .'.CODE AS QUOTE_CODE,
                        '. TABLE_ERP_TVA .'.TAUX,
                        '. TABLE_ERP_TVA .'.LABEL AS LABEL_TVA,
                        '. TABLE_ERP_UNIT .'.LABEL AS LABEL_UNIT
                        FROM '. TABLE_ERP_QUOTE_LIGNE .'
                            LEFT JOIN `'. TABLE_ERP_TVA .'` ON `'. TABLE_ERP_QUOTE_LIGNE .'`.`TVA_ID` = `'. TABLE_ERP_TVA .'`.`id`
                            LEFT JOIN `'. TABLE_ERP_UNIT .'` ON `'. TABLE_ERP_QUOTE_LIGNE .'`.`UNIT_ID` = `'. TABLE_ERP_UNIT .'`.`id`
                            LEFT JOIN `'. TABLE_ERP_QUOTE .'` ON `'. TABLE_ERP_QUOTE_LIGNE .'`.`DEVIS_ID` = `'. TABLE_ERP_QUOTE .'`.`id`
                            '. $Clause.'
                        ORDER BY '. TABLE_ERP_QUOTE_LIGNE .'.ORDRE ';
        if($Select){
            foreach ($this->GetQuery($query) as $data){
            
                $this->QuoteLineList .='<option value="'. $data->id .'" '. selected($IdData, $data->id) .'>'. $data->CODE .'</option>';
            }

            return  $this->QuoteLineList;

        }else {
            return  $this->GetQuery($query);
        }  
    }
}