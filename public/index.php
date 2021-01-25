<?php
	// include for the constants
    require_once '../include/include_recup_config.php';
    // include for functions
    require_once '../include/include_fonctions.php';
    
    use \App\SQL;
    use \App\Auth;
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
    if($p == 'home'){
    	//init xml for user language
        $langue = new Language('lang', 'index', $User->LANGUAGE);
        require '../pages/home.php';
    }
    elseif($p == 'profil'){
        //init xml for user language
        $langue = new Language('lang', 'profil', $User->LANGUAGE);
        require '../pages/profil.php';
    }
    elseif($p == 'order'){
    	//init xml for user language
        $langue = new Language('lang', 'order', $User->LANGUAGE);
        require '../pages/order.php';
    }
    elseif($p == 'quote'){
    	//init xml for user language
        $langue = new Language('lang', 'quote', $User->LANGUAGE);
        require '../pages/quote.php';
    }
    elseif($p == 'planning'){
    	//init xml for user language
        $langue = new Language('lang', 'planning', $User->LANGUAGE);
        require '../pages/planning.php';
    }
    elseif($p == 'companies'){
    	//init xml for user language
        $langue = new Language('lang', 'companies', $User->LANGUAGE);
        require '../pages/companies.php';
    }
    elseif($p == 'purchase'){
    	//init xml for user language
        $langue = new Language('lang', 'purchase', $User->LANGUAGE);
        require '../pages/purchase.php';
    }
    elseif($p == 'article'){
    	//init xml for user language
        $langue = new Language('lang', 'article', $User->LANGUAGE);
        require '../pages/article.php';
    }
    elseif($p == 'quality'){
    	//init xml for user language
        $langue = new Language('lang', 'quality', $User->LANGUAGE);
        require '../pages/quality.php';
    }
    elseif($p == 'login'){
    	//init xml for user language
        $langue = new Language('lang', 'login', $User->LANGUAGE);
        require '../pages/login.php';
    }
    else{
    	//init xml for user language
        $langue = new Language('lang', 'login', $User->LANGUAGE);
        require '../pages/login.php'; 
    }
    $content = ob_get_clean();

    require '../pages/templates/default.php';
   