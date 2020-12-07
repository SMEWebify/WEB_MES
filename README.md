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
  * content.css  *content page style*
  * forms.css   *form style*
  * print.css
  * PrintDocument.css
  * ScreenDocument.css
  * tableaux.css  *table style*
  * ui.css  *user interface*
* fonts  
* images  
* include  
  * include_connection_sql.php
  * include_fonction.php
  * include_header.php
  * include_interface.php
  * include_recup_config.php
  * verification_session.php
* admqualite.php  *Admin for quality*
* article.php  
* calendrier.php    *Calendar page*
* clientfourni.php   *Admin for customer/provider*
* commandes.php          *Order page*
* compta.php     *Admin for accounting*
* connexion.php         *page connexion*
* devis.php        *Quotation page*
* document.php         *Generate document*
* etudes.php        *Admin for study*
* gestion.php       *Admin for company*
* index.php         *First page*
* info.php       *Empty*
* methodes.php        *Admin for methods*
* planning.php        *Empty*
* profil.php       *Admin for profil user*
* qualite.php        *Empty*
* soustraitance.php         *Empty*
* users.php        *Admin for employees user*
