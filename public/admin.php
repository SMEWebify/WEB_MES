<?php
	// include for the constants
    require_once '../include/include_recup_config.php';
    // include for functions
    require_once '../include/include_fonctions.php';
    
    use \App\SQL;
    use \App\Language;
    use \App\CallOutBox;
	use \App\COMPANY\Company;
    use \App\COMPANY\CompanyManager;
    
	//auto load class
	require '../app/Autoload.class.php';
    App\Autoloader::register();

    //open sql connexion
    $bdd = new SQL();
    //init call out box for notification
    $CallOutBox = new CallOutBox();
    //load company vairiable
	$CompanyManager = new CompanyManager($bdd);
	$donneesCompany = $CompanyManager->getDb($bdd);
    $Company = new Company($donneesCompany);
    

    if(isset($_GET['page'])){
        $p = $_GET['page'];
    }
    else{
        $p = 'login';
    }

    ob_start();
    if($p == 'manage-company'){
        //init xml for user language
         $langue = new Language('lang', 'manage-company', $UserLanguage);
        require '../pages/admin/manage-company.php';
    }
    elseif($p == 'manage-companies'){
        //init xml for user language
        $langue = new Language('lang', 'manage-companies', $UserLanguage);
        require '../pages/admin/manage-companies.php';
    }
    elseif($p == 'manage-time'){
        $langue = new Language('lang', 'manage-time', $UserLanguage);
        require '../pages/admin/manage-time.php';
    }
    elseif($p == 'manage-users'){
        $langue = new Language('lang', 'manage-users', $UserLanguage);
        require '../pages/admin/manage-users.php';
    }
    elseif($p == 'manage-methodes'){
        $langue = new Language('lang', 'manage-methodes', $UserLanguage);
        require '../pages/admin/manage-methodes.php';
    }
    elseif($p == 'manage-study'){
        $langue = new Language('lang', 'manage-study', $UserLanguage);
        require '../pages/admin/manage-study.php';
    }
    elseif($p == 'manage-quality'){
        $langue = new Language('lang', 'manage-quality', $UserLanguage);
        require '../pages/admin/manage-quality.php';
    }
    elseif($p == 'manage-accounting'){
        $langue = new Language('lang', 'manage-accounting', $UserLanguage);
        require '../pages/admin/manage-accounting.php';
    }
    else{
        require '../pages/login.php'; 
    }
    $content = ob_get_clean();

    require '../pages/templates/default.php';