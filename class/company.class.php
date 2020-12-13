<?php
error_reporting(E_ALL & ~E_NOTICE);

class Company {

    private $_CompanyName;
    private $_CompanyAddress;
    private $_CompanyZipCode;
    private $_CompanyCountry;
    private $_CompanyRegion;
    private $_CompanyPhone;
    private $_CompanyMail;
    private $_CompanyWebSite;
    private $_CompanyFbSite;
    private $_CompanyTwitter;
    private $_CompanyLkd;
    private $_CompanyLogo;
    private $_CompanySIREN;
    private $_CompanyAPE;
    private $_CompanyTVAINTRA;
    private $_CompanyTAUXTVA;
    private $_CompanyCAPITAL;
    private $_CompanyRCS;

    // getter list
    public function CompanyName(){return $this->_CompanyName;}
    public function CompanyAddress(){return $this->_CompanyAddress;}
    public function CompanyZipCode(){return $this->_CompanyZipCode;}
    public function CompanyCity(){return $this->CompanyCity;}
    public function CompanyCountry(){return $this->_CompanyCountry;}
    public function CompanyRegion(){return $this->_CompanyRegion;}
    public function CompanyPhone(){return $this->_CompanyPhone;}
    public function CompanyMail(){return $this->_CompanyMail;}
    public function CompanyWebSite(){return $this->_CompanyWebSite;}
    public function CompanyFbSite(){return $this->_CompanyFbSite;}
    public function CompanyTwitter(){return $this->_CompanyTwitter;}
    public function CompanyLkd(){return $this->_CompanyLkd;}
    public function CompanyLogo(){return $this->_CompanyLogo;}
    public function CompanySIREN(){return $this->_CompanySIREN;}
    public function CompanyAPE(){return $this->_CompanyAPE;}
    public function CompanyTVAINTRA(){return $this->_CompanyTVAINTRA;}
    public function CompanyTAUXTVA(){return $this->_CompanyTAUXTVA;}
    public function CompanyCAPITAL(){return $this->_CompanyCAPITAL;}
    public function CompanyRCS(){return $this->_CompanyRCS;}

    // setter list

    public function SetCompanyName($CompanyName){
      if (is_string($CompanyName)){
        $this->_CompanyName = $CompanyName;
      }
    }
    public function SetCompanyAddress($CompanyAddress){
        if (is_string($CompanyAddress)){
          $this->CompanyAddress = $CompanyAddress;
        }
      }
    public function SetCompanyZipCode($CompanyZipCode){
        if (is_string($CompanyZipCode)){
          $this->CompanyZipCode = $CompanyZipCode;
        }
    }
    public function SetCompanyCity($CompanyCity){
      if (is_string($CompanyCity)){
        $this->CompanyCity = $CompanyCity;
      }
  }
    public function SetCompanyCountry($CompanyCountry){
        if (is_string($CompanyCountry)){
          $this->CompanyCountry = $CompanyCountry;
        }
    }
    public function SetCompanyRegion($CompanyRegion){
      if (is_string($CompanyRegion)){
        $this->CompanyRegion = $CompanyRegion;
      }
    }
    public function SetCompanyPhone($CompanyPhone){
      if (is_string($CompanyPhone)){
        $this->CompanyPhone = $CompanyPhone;
      }
    }
    public function SetCompanyMail($CompanyMail){
      if (is_string($CompanyMail)){
        $this->CompanyMail = $CompanyMail;
      }
    }
    public function SetCompanyWebSite($CompanyWebSite){
      if (is_string($CompanyWebSite)){
        $this->CompanyWebSite = $CompanyWebSite;
      }
    }
    public function SetCompanyFbSite($CompanyFbSite){
      if (is_string($CompanyFbSite)){
        $this->CompanyFbSite = $CompanyFbSite;
      }
    }
    public function SetCompanyTwitter($CompanyTwitter){
      if (is_string($CompanyTwitter)){
        $this->CompanyTwitter = $CompanyTwitter;
      }
    }
    public function SetCompanyLkd($CompanyLkd){
      if (is_string($CompanyLkd)){
        $this->CompanyLkd = $CompanyLkd;
      }
    }
    public function SetCompanyLogo($CompanyLogo){
      if (is_string($CompanyLogo)){
        $this->CompanyLogo = $CompanyLogo;
      }
    }
    public function SetCompanySIREN($CompanySIREN){
      if (is_string($CompanySIREN)){
        $this->CompanySIREN = $CompanySIREN;
      }
    }
    public function SetCompanyAPE($CompanyAPE){
      if (is_string($CompanyAPE)){
        $this->CompanyAPE = $CompanyAPE;
      }
    }
    public function SetCompanyTVAINTRA($CompanyTVAINTRA){
      if (is_string($CompanyTVAINTRA)){
        $this->CompanyTVAINTRA = $CompanyTVAINTRA;
      }
    }
    public function SetCompanyTAUXTVA($CompanyTAUXTVA){
      if (is_string($CompanyTAUXTVA)){
        $this->CompanyTAUXTVA = $CompanyTAUXTVA;
      }
    }
    public function SetCompanyCAPITAL($CompanyCAPITAL){
      if (is_string($CompanyCAPITAL)){
        $this->CompanyCAPITAL = $CompanyCAPITAL;
      }
    }
    public function SetCompanyRCS($CompanyRCS){
      if (is_string($CompanyRCS)){
        $this->CompanyRCS = $CompanyRCS;
      }
    }
}

class CompanysManager
{
  private $_db; // Instance de PDO

  public function __construct($db)
  {
    $this->setDb($db);
  }

  public function getListDb()
  {
    $Company = [];

    $q = $this->_db->query('SELECT NAME,
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
                                 FROM '. TABLE_ERP_COMPANY .'');

    $donnees = $q->fetch(PDO::FETCH_ASSOC);
    $Company[] = new Company($donnees);
 
    return $Company;
  }

  public function updateDb(Company $Company)
  {                          
    $q = $this->_db->prepare('UPDATE '. TABLE_ERP_COMPANY .' SET NAME = :UpdateCompanyName,
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

    $q->bindValue(':UpdateCompanyName', $Company->CompanyName(), PDO::PARAM_INT);
    $q->bindValue(':UpdateCompanyAddress', $Company->CompanyAddress(), PDO::PARAM_INT);
    $q->bindValue(':UpdateCompanyCity', $Company->CompanyCity(), PDO::PARAM_INT);
    $q->bindValue(':UpdateCompanyZipCode', $Company->CompanyZipCode(), PDO::PARAM_INT);
    $q->bindValue(':UpdateCompanyRegion', $Company->CompanyRegion(), PDO::PARAM_INT);
    $q->bindValue(':UpdateCompanyCountry', $Company->CompanyCountry(), PDO::PARAM_INT);
    $q->bindValue(':UpdateCompanyPhone', $Company->CompanyPhone(), PDO::PARAM_INT);
    $q->bindValue(':UpdateCompanyMail', $Company->CompanyMail(), PDO::PARAM_INT);
    $q->bindValue(':UpdateCompanyWebSite', $Company->CompanyWebSite(), PDO::PARAM_INT);
    $q->bindValue(':UpdateCompanyFbSite', $Company->CompanyFbSite(), PDO::PARAM_INT);
    $q->bindValue(':UpdateCompanyTwitter', $Company->CompanyTwitter(), PDO::PARAM_INT);
    $q->bindValue(':UpdateCompanyLkd', $Company->CompanyLkd(), PDO::PARAM_INT);
    $q->bindValue(':UpdateCompanySIREN', $Company->CompanySIREN(), PDO::PARAM_INT);
    $q->bindValue(':UpdateCompanyAPE', $Company->CompanyAPE(), PDO::PARAM_INT);
    $q->bindValue(':UpdateCompanyTVAINTRA', $Company->CompanyTVAINTRA(), PDO::PARAM_INT);
    $q->bindValue(':UpdateCompanyTAUXTVA', $Company->CompanyTAUXTVA(), PDO::PARAM_INT);
    $q->bindValue(':UpdateCompanyCAPITAL', $Company->CompanyCAPITAL(), PDO::PARAM_INT);
    $q->bindValue(':UpdateCompanyRCS', $Company->CompanyRCS(), PDO::PARAM_INT);

    $q->execute();
  }

  public function setDb(PDO $db)
  {
    $this->_db = $db;
  }
}
?>