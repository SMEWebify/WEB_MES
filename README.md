# WEB_ERP_MES
##  Ressource and Manufacturing execution system  Web

![alt text](https://github.com/billyboy35/WEB_MES/blob/master/public/images/Doc/Workflow.png)

#For configuration
* Use __erp.sql__ to import ERP database  
* Connection to the SQL database in __SQL.class.php__ file
* SQL login to define in __include_recup_config.php__

-----------------

# initial remote source code recovery
git clone git@gitlab.com:billy_boy/ERP.git

# url acces with wamp server
http://localhost/erp/public/

# Log acces to user pages
Login : Billy
Password : KN1

-----------------
![alt text](https://github.com/billyboy35/WEB_MES/blob/master/public/images/Doc/Menu.PNG)

### Structure Project

* app
  * Acouting   __class for Acouting data__
  * Companies   __class for customers & providers data__
  * Company   __class for company data__
  * Lang __folder for language class__
    * en  __XML folder for En lang__ 
    * fr __XML folder for fr lang__ 
  * Methods __class for methods data__
  * Quality  __class for quality data__
  * Quote  __class for quote data__
  * Study __class for study data__
  ----
  * Auth.class.php   __Authentification user class__
  * Autoload.class.php   __Autoload class__
  * CallOutBox.class.php  __notification class__
  * Form.class.php
  * language.class.php  __class language__
  * SQL.class.php  __class sql__
  * User.class.php  __User sql__
* include  
  * include_fonction.php
  * include_recup_config.php  __contain constant__
* public
  * css  
    * content.css  __content page style__
    * forms.css   __form style__
    * print.css
    * PrintDocument.css
    * ScreenDocument.css
    * tableaux.css  __table style__
    * ui.css  __user interface__
  * images
  * js
  * index.php __ROUTING PAGE __
  * admin.php  __ROUTING PAGE __
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
    * companies.php    __Companies page__
    * document.php         __Generate document__
    * home.php         __First page__
    * info.php       __Empty__
    * login.php         __page connexion__
    * order.php          __Order page__
    * planning.php        __Empty__
    * profil.php       __Admin for profil user__
    * purchase.php         __Empty__
    * quality.php       __Quality page__
    * quote.php        __Quotation page__


