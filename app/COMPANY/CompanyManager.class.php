<?php

namespace App\COMPANY;
use \App\SQL;
use \PDO;

class CompanyManager extends \App\SQL
{
  private $db; // Instance de \App\SQL

  public function __construct(\App\SQL $db)
  {
    $this->db = $db;
  }

  public function getDb(SQL $bdd)
  {
    $donnees[] = array();
    $query = 'SELECT NAME,
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
                                  LOGO,
                                  SIREN,
                                  APE,
                                  TVA_INTRA,
                                  TAUX_TVA,
                                  CAPITAL,
                                  RCS
                                 FROM '. TABLE_ERP_COMPANY .'';

    $donnees[] = $bdd->GetQuery($query);
    return   $donnees;
  }

  public function setDb(PDO $db)
  {
    $this->_db = $db;
  }
}