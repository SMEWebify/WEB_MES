<?php
namespace App;

Class User Extends SQL{
    public  $idUSER ;
    public  $CODE ;
    public  $NOM;  
    public  $PRENOM;
    public  $DATE_NAISSANCE;
    public  $MAIL;  
    public  $NUMERO_PERSO;  
    public  $NUMERO_INTERNE;  
    public  $IMAGE_PROFIL;  
    public  $STATU ;
    public  $CONNEXION ;
    public  $NAME ;
    public  $PASSWORD ;
    public  $FONCTION;
    public  $LANGUAGE;
    public  $page_1 ;
    public  $page_2 ;
    public  $page_3 ;
    public  $page_4 ;
    public  $page_5 ;
    public  $page_6 ;
    public  $page_7;
    public  $page_8;
    public  $page_9;
    public  $page_10;

    Public $UserCount;

    public function __construct() {}

    public function UpdateLanguage($POST){
        
        //update database	
        $this->GetUpdate('UPDATE '. TABLE_ERP_EMPLOYEES .' SET  LANGUAGE = \''. addslashes($POST) .'\' WHERE IdUser=\''. $_SESSION['id'] .'\'');
        $this->_LANGUAGE = $POST;

        return $this->_LANGUAGE;
    }

    public function GETUserCount($ID = null){
        $Clause = '';
        if($ID != null){
            $Clause = 'WHERE IdUser = \''. $ID .'\'';
        }

        $UserCount =  $this->GetCount(TABLE_ERP_EMPLOYEES,'IdUser', $Clause);
        return $UserCount;
    }
}