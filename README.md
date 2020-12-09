# WEB_MES
## Web Manufacturing execution system

![alt text](https://github.com/billyboy35/WEB_MES/blob/main/MES_VIEW_DEMO.PNG)

#For configuration
* Use erp.sql to import ERP database  
* Connection to the SQL database in include_connection_sql file

#Project
*  level of development  Beginner ++
* Currently most of the project is procedural

# récuération initiale du code source distant (activer le clé ssh)
git clone git@gitlab.com:billy_boy/ERP.git

-----------------

#Structure Project

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
  * include_connection_sql.php
  * include_fonction.php
  * include_header.php
  * include_interface.php
  * include_recup_config.php
  * verification_session.php
* admqualite.php  __Admin for quality__
* article.php  
* calendrier.php    __Calendar page__
* clientfourni.php   __Admin for customer/provider__
* order.php          __Order page__
* compta.php     __Admin for accounting__
* connexion.php         __page connexion__
* devis.php        __Quotation page__
* document.php         __Generate document__
* etudes.php        __Admin for study__
* gestion.php       __Admin for company__
* index.php         __First page__
* info.php       __Empty__
* methodes.php        __Admin for methods__
* planning.php        __Empty__
* profil.php       __Admin for profil user__
* qualite.php        __Empty__
* soustraitance.php         __Empty__
* users.php        __Admin for employees user__
