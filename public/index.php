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
    if($p == 'home'){
    	//init xml for user language
        $langue = new Language('Language', 'index', $User->LANGUAGE);
        require '../pages/home.php';
    }
    elseif($p == 'profil'){
        //init xml for user language
        $langue = new Language('Language', 'profil', $User->LANGUAGE);
        require '../pages/profil.php';
    }
    elseif($p == 'order'){
    	//init xml for user language
        $langue = new Language('Language', 'order', $User->LANGUAGE);
        require '../pages/order.php';
    }
    elseif($p == 'quote'){
    	//init xml for user language
        $langue = new Language('Language', 'quote', $User->LANGUAGE);
        require '../pages/quote.php';
    }
    elseif($p == 'planning'){
    	//init xml for user language
        $langue = new Language('Language', 'planning', $User->LANGUAGE);
        require '../pages/planning.php';
    }
    elseif($p == 'companies'){
    	//init xml for user language
        $langue = new Language('Language', 'companies', $User->LANGUAGE);
        require '../pages/companies.php';
    }
    elseif($p == 'purchase'){
    	//init xml for user language
        $langue = new Language('Language', 'purchase', $User->LANGUAGE);
        require '../pages/purchase.php';
    }
    elseif($p == 'article'){
    	//init xml for user language
        $langue = new Language('Language', 'article', $User->LANGUAGE);
        require '../pages/article.php';
    }
    elseif($p == 'quality'){
    	//init xml for user language
        $langue = new Language('Language', 'quality', $User->LANGUAGE);
        require '../pages/quality.php';
    }
    elseif($p == 'document'){
    	//init xml for user language
        $langue = new Language('Language', 'document', $User->LANGUAGE);
        require '../pages/document.php';
        exit;
    }
    elseif($p == 'login'){
    	//init xml for user language
        $langue = new Language('Language', 'login', $User->LANGUAGE);
        require '../pages/login.php';
    }
    else{
    	//init xml for user language
        $langue = new Language('Language', 'login', $User->LANGUAGE);
        require '../pages/login.php'; 
    }

    $content = ob_get_clean();

    require '../pages/templates/default.php';
   