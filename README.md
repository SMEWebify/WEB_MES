# WEB_ERP_MES
##  Ressource and Manufacturing execution system  Web

![alt text](https://github.com/billyboy35/WEB_MES/blob/main/MES_VIEW_DEMO.PNG)

![alt text](https://github.com/billyboy35/WEB_MES/blob/main/Workflow.png)

#For configuration
* Use __erp.sql__ to import ERP database  
* Connection to the SQL database in __SQL.class.php__ file
* SQL login to define in __include_recup_config.php__

#Project
* level of development  Beginner ++
* Currently most of the project is procedural

-----------------

# initial remote source code recovery
git clone git@gitlab.com:billy_boy/ERP.git

http://localhost/erp/public/

-----------------

### Structure Project

* app
  * Acouting   __class for Acouting data__
    * Allocations.class.php
  * Companies   __class for customers & providers data__
    * Customer.class.php
    * Provider.class.php
  * COMPANY   __class for company data__
    * Company.class.php
    * CompanyManager.class.php
    * Employees.class.php
  * Lang __folder for language class__
    * en  __XML folder for En lang__ 
    * fr __XML folder for fr lang__ 
  * Methods
    * Prestation.class.php
    * Ressource.class.php
    * Section.class.php
  * Quality
  * Auth.class.php   __Authentification user class__
  * Autoload.class.php   __Autoload class__
  * CallOutBox.class.php  __notification class__
  * language.class.php  __class language__
  * SQL.class.php  __class sql__
  * User.class.php  __User sql__
* include  
  * include_fonction.php
  * include_recup_config.php  __contain constant__
* public
  * css  
    * component.css
    * content.css  __content page style__
    * forms.css   __form style__
    * print.css
    * PrintDocument.css
    * ScreenDocument.css
    * tableaux.css  __table style__
    * ui.css  __user interface__
  * fonts  
  * images
  * js
  * index.php __ROUTING PAGE FRONT-END__
  * admin.php  __ROUTING PAGE BACK-END__
* pages
  * templates
    * default.php __Main Template__
  * admin
    #### Admin pages
    * manage-accounting.php     __Admin for accounting__
    * manage-companies.php   __Admin for customer/provider__
    * manage-company.php       __Admin for company__
    * manage-methodes.php        __Admin for methods__
    * manage-quality.php  __Admin for quality__
    * manage-study.php        __Admin for study__
    * manage-time.php       __Admin for time gestion__
    * manage-users.php        __Admin for employees user__
  #### User pages
    * article.php  __Article page__ 
    * calandar.php    __Calendar page__
    * document.php         __Generate document__
    * index.php         __First page__
    * info.php       __Empty__
    * login.php         __page connexion__
    * order.php          __Order page__
    * planning.php        __Empty__
    * profil.php       __Admin for profil user__
    * purchase.php         __Empty__
    * quality.php        __Empty__
    * quote.php        __Quotation page__


