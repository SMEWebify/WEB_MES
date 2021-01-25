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

        $NewQuote = $this->GetInsert("INSERT INTO ". TABLE_ERP_DEVIS ." VALUE ('0',
																				'". $CODE ."',
																				'1',
																				'',
																				'',
																				'". $CutomerID ."',
																				'0',
																				'0',
																				'0',
																				NOW(),
																				NOW(),
																				'1',
																				'". $UserID ."',
																				'0',
																				'0',
																				'',
																				'9',
																				'5',
																				'0',
																				'0',
                                                                                '')");
        return $NewQuote;
    }

    public function GETQuote($id_GET){

        $Quote = $this->GetQuery('SELECT '. TABLE_ERP_DEVIS .'.id,
                                        '. TABLE_ERP_DEVIS .'.CODE,
                                        '. TABLE_ERP_DEVIS .'.INDICE,
                                        '. TABLE_ERP_DEVIS .'.LABEL,
                                        '. TABLE_ERP_DEVIS .'.LABEL_INDICE,
                                        '. TABLE_ERP_DEVIS .'.CUSTOMER_ID,
                                        '. TABLE_ERP_DEVIS .'.CONTACT_ID,
                                        '. TABLE_ERP_DEVIS .'.ADRESSE_ID,
                                        '. TABLE_ERP_DEVIS .'.FACTURATION_ID,
                                        '. TABLE_ERP_DEVIS .'.DATE,
                                        '. TABLE_ERP_DEVIS .'.DATE_VALIDITE,
                                        '. TABLE_ERP_DEVIS .'.ETAT,
                                        '. TABLE_ERP_DEVIS .'.CREATEUR_ID,
                                        '. TABLE_ERP_DEVIS .'.RESP_COM_ID,
                                        '. TABLE_ERP_DEVIS .'.RESP_TECH_ID,
                                        '. TABLE_ERP_DEVIS .'.REFERENCE,
                                        '. TABLE_ERP_DEVIS .'.COND_REG_CUSTOMER_ID,
                                        '. TABLE_ERP_DEVIS .'.MODE_REG_CUSTOMER_ID,
                                        '. TABLE_ERP_DEVIS .'.ECHEANCIER_ID,
                                        '. TABLE_ERP_DEVIS .'.TRANSPORT_ID,
                                        '. TABLE_ERP_DEVIS .'.COMENT,
                                        '. TABLE_ERP_CLIENT_FOUR .'.NAME AS CUSTOMER_NAME,
                                        '. TABLE_ERP_EMPLOYEES .'.NOM,
                                        '. TABLE_ERP_EMPLOYEES .'.PRENOM
                                        FROM `'. TABLE_ERP_DEVIS .'`
                                            LEFT JOIN `'. TABLE_ERP_CLIENT_FOUR .'` ON `'. TABLE_ERP_DEVIS .'`.`CUSTOMER_ID` = `'. TABLE_ERP_CLIENT_FOUR .'`.`id`
                                            LEFT JOIN `'. TABLE_ERP_EMPLOYEES .'` ON `'. TABLE_ERP_DEVIS .'`.`CREATEUR_ID` = `'. TABLE_ERP_EMPLOYEES .'`.`idUSER`
                                        WHERE '. TABLE_ERP_DEVIS .'.id = \''. $id_GET.'\' ', true, 'App\Quote\Quote');
        return $Quote;
    }

    public function GETQuoteCount($ID = null, $Clause = null){
        
        if($ID != null){
            $Clause = 'WHERE id = \''. $ID .'\'';
        }

        $QuoteCount =  $this->GetCount(TABLE_ERP_DEVIS,'id', $Clause);
        return $QuoteCount;
    }

    public function GETQuoteList($IdData=0, $Select = true){

        $this->QuoteList ='';
        $query='SELECT '. TABLE_ERP_DEVIS .'.id,
                        '. TABLE_ERP_DEVIS .'.CODE,
                        '. TABLE_ERP_DEVIS .'.LABEL,
                        '. TABLE_ERP_CLIENT_FOUR .'.NAME
                FROM '. TABLE_ERP_DEVIS .'
                LEFT JOIN `'. TABLE_ERP_CLIENT_FOUR .'` ON `'. TABLE_ERP_DEVIS .'`.`CUSTOMER_ID` = `'. TABLE_ERP_CLIENT_FOUR .'`.`id`
                ORDER BY  '. TABLE_ERP_DEVIS .'.id DESC';
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

        $NewQuoteLine = $this->GetInsert("INSERT INTO ". TABLE_ERP_DEVIS_LIGNE ." VALUE ('0',
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

        $UpdateQuoteLine = $this->GetUpdate("UPDATE  ". TABLE_ERP_DEVIS_LIGNE ." SET 	ORDRE='". addslashes($ORDRE) ."',
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
        $Clause = 'WHERE '. TABLE_ERP_DEVIS_LIGNE .'.DEVIS_ID = \''. $IdQuote.'\'';
        if($IdQuote===0){
            $Clause = '';
        }
        $query='SELECT  '. TABLE_ERP_DEVIS_LIGNE .'.id,
                        '. TABLE_ERP_DEVIS_LIGNE .'.DEVIS_ID,
                        '. TABLE_ERP_DEVIS_LIGNE .'.ORDRE,
                        '. TABLE_ERP_DEVIS_LIGNE .'.ARTICLE_CODE,
                        '. TABLE_ERP_DEVIS_LIGNE .'.LABEL,
                        '. TABLE_ERP_DEVIS_LIGNE .'.QT,
                        '. TABLE_ERP_DEVIS_LIGNE .'.UNIT_ID,
                        '. TABLE_ERP_DEVIS_LIGNE .'.PRIX_U,
                        '. TABLE_ERP_DEVIS_LIGNE .'.REMISE,
                        '. TABLE_ERP_DEVIS_LIGNE .'.TVA_ID,
                        '. TABLE_ERP_DEVIS_LIGNE .'.DELAIS,
                        '. TABLE_ERP_DEVIS_LIGNE .'.ETAT,
                        '. TABLE_ERP_DEVIS .'.CODE AS QUOTE_CODE,
                        '. TABLE_ERP_TVA .'.TAUX,
                        '. TABLE_ERP_TVA .'.LABEL AS LABEL_TVA,
                        '. TABLE_ERP_UNIT .'.LABEL AS LABEL_UNIT
                        FROM '. TABLE_ERP_DEVIS_LIGNE .'
                            LEFT JOIN `'. TABLE_ERP_TVA .'` ON `'. TABLE_ERP_DEVIS_LIGNE .'`.`TVA_ID` = `'. TABLE_ERP_TVA .'`.`id`
                            LEFT JOIN `'. TABLE_ERP_UNIT .'` ON `'. TABLE_ERP_DEVIS_LIGNE .'`.`UNIT_ID` = `'. TABLE_ERP_UNIT .'`.`id`
                            LEFT JOIN `'. TABLE_ERP_DEVIS .'` ON `'. TABLE_ERP_DEVIS_LIGNE .'`.`DEVIS_ID` = `'. TABLE_ERP_DEVIS .'`.`id`
                            '. $Clause.'
                        ORDER BY '. TABLE_ERP_DEVIS_LIGNE .'.ORDRE ';
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