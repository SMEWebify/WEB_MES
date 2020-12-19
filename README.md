# WEB_ERP_MES
##  Ressource and Manufacturing execution system  Web

![alt text](https://github.com/billyboy35/WEB_MES/blob/main/MES_VIEW_DEMO.PNG)

#For configuration
* Use __erp.sql__ to import ERP database  
* Connection to the SQL database in include_connection_sql file
* SQL login to define in __include_recup_config.php__

#Project
*  level of development  Beginner ++
* Currently most of the project is procedural

-----------------

# récuération initiale du code source distant (activer le clé ssh)
git clone git@gitlab.com:billy_boy/ERP.git

http://localhost/erp/login.php
-----------------

### Structure Project

* class
  * language.class.php  __class language__
  * notification.class.php   __class notification__
  * sql.class.php  __class sql__
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
* include  
  * include_checking_session.php
  * include_fonction.php
  * include_header.php
  * include_interface.php
  * include_recup_config_company.php
  * include_recup_config.php
* lang
  * en  __XML folder for En lang__ 
  * fr __XML folder for fr lang__ 

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

#### Admin pages

* manage-accounting.php     __Admin for accounting__
* manage-companies.php   __Admin for customer/provider__
* manage-company.php       __Admin for company__
* manage-methodes.php        __Admin for methods__
* manage-quality.php  __Admin for quality__
* manage-study.php        __Admin for study__
* manage-time.php       __Admin for time gestion__
* manage-users.php        __Admin for employees user__
