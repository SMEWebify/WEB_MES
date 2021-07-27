<?php
	// include for the constants
    require_once '../include/include_recup_config.php';
    // include for functions
    require_once '../include/include_fonctions.php';
    
    use \App\SQL;
    use \App\Auth;
    use \App\UI\CallOutBox;
    use \App\Language\Language;
	use \App\Company\Company;


	//auto load class
	require '../app/Autoload.class.php';
    App\Autoloader::register();

    //open sql connexion
    $bdd = new SQL();
    //init call out box for notification
    $CallOutBox = new CallOutBox();
    //load company vairiable
    $Company = new Company();
	$Company= $Company->GETCompany();
    
	//session checking  user
	$auth = New Auth($bdd);
	$User = $auth->User();

    ob_start();

    if(isset($_GET['page'])){
        //init xml for user language
        $langue = new Language('Language', $_GET['page'], $User->LANGUAGE);
        //load 
        require '../pages/'. $_GET['page'] .'.php';
    }
    else{
        //init xml for user language
        $langue = new Language('Language', 'login', $User->LANGUAGE);
        require '../pages/login.php';
    }

    $content = ob_get_clean();

    require '../pages/templates/default.php';
   