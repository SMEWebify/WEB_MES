<?php

namespace App\COMPANY;
use \App\SQL;

class Company Extends SQL  {

  Public $id; 
  Public $NAME; 
  Public $ADDRESS; 
  Public $CITY; 
  Public $ZICODE; 
  Public $REGION; 
  Public $PHONE_NUMBER; 
  Public $MAIL; 
  Public $WEB_SITE; 
  Public $FACEBOOK_SITE; 
  Public $TWITTER_SITE; 
  Public $LKD_SITE; 
  Public $PICTURE_COMPANY; 
  Public $SIREN; 
  Public $APE; 
  Public $TVA_INTRA; 
  Public $TAUX_TVA; 
  Public $CAPITAL; 
  Public $RCS;


  public function GETCompany(){

    $Order = $this->GetQuery('SELECT NAME,
                                  ADDRESS,
                                  CITY,
                                  ZIPCODE,
                                  REGION,
                                  COUNTRY,
                                  PHONE_NUMBER,
                                  MAIL,
                                  WEB_SITE,
                                  FACEBOOK_SITE,
                                  TWITTER_SITE,
                                  LKD_SITE,
                                  PICTURE_COMPANY,
                                  SIREN,
                                  APE,
                                  TVA_INTRA,
                                  TAUX_TVA,
                                  CAPITAL,
                                  RCS
                                FROM '. TABLE_ERP_COMPANY .'', true, 'App\COMPANY\Company');
      return $Order;
    }  
}