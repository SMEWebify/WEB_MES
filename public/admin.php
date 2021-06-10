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

    if(isset($_GET['page'])){
        $p = $_GET['page'];
    }
    else{
        $p = 'login';
    }

    ob_start();
    if($p == 'manage-company'){
        //init xml for user language
         $langue = new Language('Language', 'manage-company', $User->LANGUAGE);
        require '../pages/admin/manage-company.php';
    }
    elseif($p == 'manage-companies'){
        //init xml for user language
        $langue = new Language('Language', 'manage-companies', $User->LANGUAGE);
        require '../pages/admin/manage-companies.php';
    }
    elseif($p == 'manage-time'){
        $langue = new Language('Language', 'manage-time', $User->LANGUAGE);
        require '../pages/admin/manage-time.php';
    }
    elseif($p == 'manage-users'){
        $langue = new Language('Language', 'manage-users', $User->LANGUAGE);
        require '../pages/admin/manage-users.php';
    }
    elseif($p == 'manage-methodes'){
        $langue = new Language('Language', 'manage-methodes', $User->LANGUAGE);
        require '../pages/admin/manage-methodes.php';
    }
    elseif($p == 'manage-study'){
        $langue = new Language('Language', 'manage-study', $User->LANGUAGE);
        require '../pages/admin/manage-study.php';
    }
    elseif($p == 'manage-quality'){
        $langue = new Language('Language', 'manage-quality', $User->LANGUAGE);
        require '../pages/admin/manage-quality.php';
    }
    elseif($p == 'manage-accounting'){
        $langue = new Language('Language', 'manage-accounting', $User->LANGUAGE);
        require '../pages/admin/manage-accounting.php';
    }
    else{
        $langue = new Language('Language', 'manage-accounting', 'fr');
        require '../pages/login.php'; 
    }
    $content = ob_get_clean();

    require '../pages/templates/default.php';