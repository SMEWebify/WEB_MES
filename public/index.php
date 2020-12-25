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
    if($p == 'home'){
    	//init xml for user language
        $langue = new Language('lang', 'index', $UserLanguage);
        require '../pages/home.php';
    }
    elseif($p == 'profil'){
        //init xml for user language
        $langue = new Language('lang', 'profil', $UserLanguage);
        require '../pages/profil.php';
    }
    elseif($p == 'order'){
    	//init xml for user language
        $langue = new Language('lang', 'order', $UserLanguage);
        require '../pages/order.php';
    }
    elseif($p == 'quote'){
    	//init xml for user language
        $langue = new Language('lang', 'quote', $UserLanguage);
        require '../pages/quote.php';
    }
    elseif($p == 'planning'){
    	//init xml for user language
        $langue = new Language('lang', 'planning', $UserLanguage);
        require '../pages/planning.php';
    }
    elseif($p == 'calendar'){
    	//init xml for user language
        $langue = new Language('lang', 'calendar', $UserLanguage);
        require '../pages/calendar.php';
    }
    elseif($p == 'purchase'){
    	//init xml for user language
        $langue = new Language('lang', 'purchase', $UserLanguage);
        require '../pages/purchase.php';
    }
    elseif($p == 'article'){
    	//init xml for user language
        $langue = new Language('lang', 'article', $UserLanguage);
        require '../pages/article.php';
    }
    elseif($p == 'quality'){
    	//init xml for user language
        $langue = new Language('lang', 'quality', $UserLanguage);
        require '../pages/quality.php';
    }
    elseif($p == 'login'){
    	//init xml for user language
        $langue = new Language('lang', 'login', $UserLanguage);
        require '../pages/login.php';
    }
    else{
    	//init xml for user language
        $langue = new Language('lang', 'login', $UserLanguage);
        require '../pages/login.php'; 
    }
    $content = ob_get_clean();

    require '../pages/templates/default.php';