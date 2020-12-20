<?php

namespace ERP\COMPANY;

class Company   {

    private $_CompanyName, 
            $_CompanyAddress, 
            $_CompanyZipCode, 
            $_CompanyCity, 
            $_CompanyCountry, 
            $_CompanyRegion, 
            $_CompanyPhone, 
            $_CompanyMail, 
            $_CompanyWebSite, 
            $_CompanyFbSite, 
            $_CompanyTwitter, 
            $_CompanyLkd, 
            $_CompanyLogo, 
            $_CompanySIREN, 
            $_CompanyAPE, 
            $_CompanyTVAINTRA, 
            $_CompanyTAUXTVA, 
            $_CompanyCAPITAL, 
            $_CompanyRCS;

    public function __construct(array $donnees)
    {
      $this->hydrate($donnees);
    }

    // getter list
    public function CompanyNAME(){return $this->_CompanyName;}
    public function CompanyAddress(){return $this->_CompanyAddress;}
    public function CompanyZipCode(){return $this->_CompanyZipCode;}
    public function CompanyCity(){return $this->_CompanyCity;}
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

    public function hydrate(array $donnees)
    {
     
      foreach ($donnees as $key => $value)
      {
        // On récupère le nom du setter correspondant à l'attribut.
        $method = 'set'.ucfirst($key);  
        // Si le setter correspondant existe.
        if (method_exists($this, $method))
        {
          // On appelle le setter.
          $this->$method($value);
        }
      }
    }

    // setter list
    public function SetNAME($CompanyName){
      if (is_string($CompanyName)){
        $this->_CompanyName = $CompanyName;
      }
    }
    public function SetADDRESS($CompanyAddress){
        if (is_string($CompanyAddress)){
          $this->_CompanyAddress = $CompanyAddress;
        }
      }
    public function SetZipCode($CompanyZipCode){
        if (is_string($CompanyZipCode)){
          $this->_CompanyZipCode = $CompanyZipCode;
        }
    }
    public function setCITY($CompanyCity){
      if (is_string($CompanyCity)){
        $this->_CompanyCity = $CompanyCity;
      }
    }
    public function SetCountry($CompanyCountry){
        if (is_string($CompanyCountry)){
          $this->_CompanyCountry = $CompanyCountry;
        }
    }
    public function SetRegion($CompanyRegion){
      if (is_string($CompanyRegion)){
        $this->_CompanyRegion = $CompanyRegion;
      }
    }
    public function SetPhone_number($CompanyPhone){
      if (is_string($CompanyPhone)){
        $this->_CompanyPhone = $CompanyPhone;
      }
    }
    public function SetMAIL($CompanyMail){
      if (is_string($CompanyMail)){
        $this->_CompanyMail = $CompanyMail;
      }
    }
    public function SetWeb_Site($CompanyWebSite){
      if (is_string($CompanyWebSite)){
        $this->_CompanyWebSite = $CompanyWebSite;
      }
    }
    public function SetFACEBOOK_SITE($CompanyFbSite){
      if (is_string($CompanyFbSite)){
        $this->_CompanyFbSite = $CompanyFbSite;
      }
    }
    public function SetTWITTER_SITE($CompanyTwitter){
      if (is_string($CompanyTwitter)){
        $this->_CompanyTwitter = $CompanyTwitter;
      }
    }
    public function SetLKD_SITE($CompanyLkd){
      if (is_string($CompanyLkd)){
        $this->_CompanyLkd = $CompanyLkd;
      }
    }
    public function SetLogo($CompanyLogo){
      if (is_string($CompanyLogo)){
        $this->_CompanyLogo = $CompanyLogo;
      }
    }
    public function SetSIREN($CompanySIREN){
      if (is_string($CompanySIREN)){
        $this->_CompanySIREN = $CompanySIREN;
      }
    }
    public function SetAPE($CompanyAPE){
      if (is_string($CompanyAPE)){
        $this->_CompanyAPE = $CompanyAPE;
      }
    }
    public function SetTVA_INTRA($CompanyTVAINTRA){
      if (is_string($CompanyTVAINTRA)){
        $this->_CompanyTVAINTRA = $CompanyTVAINTRA;
      }
    }
    public function SetTAUX_TVA($CompanyTAUXTVA){
      if (is_string($CompanyTAUXTVA)){
        $this->_CompanyTAUXTVA = $CompanyTAUXTVA;
      }
    }
    public function SetCAPITAL($CompanyCAPITAL){
      if (is_string($CompanyCAPITAL)){
        $this->_CompanyCAPITAL = $CompanyCAPITAL;
      }
    }
    public function SetRCS($CompanyRCS){
      if (is_string($CompanyRCS)){
        $this->_CompanyRCS = $CompanyRCS;
      }
    }
}
?>