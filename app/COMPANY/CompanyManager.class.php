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

  public function updateDb(Company $Company)
  {                          
   /* $this->GetPrepare('UPDATE '. TABLE_ERP_COMPANY .' SET NAME = :UpdateCompanyName,
                                                            ADDRESS = :UpdateCompanyAddress,
                                                            CITY = :UpdateCompanyCity,
                                                            ZIPCODE = :UpdateCompanyZipCode,
                                                            REGION = :UpdateCompanyRegion,
                                                            COUNTRY = :UpdateCompanyCountry,
                                                            PHONE_NUMBER = :UpdateCompanyPhone,
                                                            MAIL = :UpdateCompanyMail,
                                                            WEB_SITE = :UpdateCompanyMail,
                                                            FACEBOOK_SITE = :UpdateCompanyFbSite,
                                                            TWITTER_SITE = :UpdateCompanyTwitter,
                                                            LKD_SITE = :UpdateCompanyLkd,
                                                            SIREN = :UpdateCompanySIREN,
                                                            APE = :UpdateCompanyAPE,
                                                            TVA_INTRA = :UpdateCompanyTVAINTRA,
                                                            TAUX_TVA = :UpdateCompanyTAUXTVA,
                                                            CAPITAL = :UpdateCompanyCAPITAL,
                                                            RCS = :UpdateCompanyRCS');

    $this->bindValue(':UpdateCompanyName', $Company->CompanyName(), PDO::PARAM_STR );
    $this->bindValue(':UpdateCompanyAddress', $Company->CompanyAddress(), PDO::PARAM_STR );
    $this->bindValue(':UpdateCompanyCity', $Company->CompanyCity(), PDO::PARAM_STR );
    $this->bindValue(':UpdateCompanyZipCode', $Company->CompanyZipCode(), PDO::PARAM_STR );
    $this->bindValue(':UpdateCompanyRegion', $Company->CompanyRegion(), PDO::PARAM_STR );
    $this->bindValue(':UpdateCompanyCountry', $Company->CompanyCountry(), PDO::PARAM_STR );
    $this->bindValue(':UpdateCompanyPhone', $Company->CompanyPhone(), PDO::PARAM_STR );
    $this->bindValue(':UpdateCompanyMail', $Company->CompanyMail(), PDO::PARAM_STR );
    $this->bindValue(':UpdateCompanyWebSite', $Company->CompanyWebSite(), PDO::PARAM_STR );
    $this->bindValue(':UpdateCompanyFbSite', $Company->CompanyFbSite(), PDO::PARAM_STR );
    $this->bindValue(':UpdateCompanyTwitter', $Company->CompanyTwitter(), PDO::PARAM_STR );
    $this->bindValue(':UpdateCompanyLkd', $Company->CompanyLkd(), PDO::PARAM_STR );
    $this->bindValue(':UpdateCompanySIREN', $Company->CompanySIREN(), PDO::PARAM_STR );
    $this->bindValue(':UpdateCompanyAPE', $Company->CompanyAPE(), PDO::PARAM_STR );
    $this->bindValue(':UpdateCompanyTVAINTRA', $Company->CompanyTVAINTRA(), PDO::PARAM_STR );
    $this->bindValue(':UpdateCompanyTAUXTVA', $Company->CompanyTAUXTVA(), PDO::PARAM_STR );
    $this->bindValue(':UpdateCompanyCAPITAL', $Company->CompanyCAPITAL(), PDO::PARAM_STR );
    $this->bindValue(':UpdateCompanyRCS', $Company->CompanyRCS(), PDO::PARAM_STR );

    $this->execute();*/
  }

  public function setDb(PDO $db)
  {
    $this->_db = $db;
  }
}