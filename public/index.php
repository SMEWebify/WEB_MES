<?php
	//auto load class
	require '../app/Autoload.class.php';
    App\Autoloader::register();

    ob_start();

    if(isset($_GET['page'])){
        $p = $_GET['page'];
    }
    else{
        $p = 'login';
    }

    if($p == 'home'){
        require '../pages/home.php';
    }
    elseif($p == 'profil'){
        require '../pages/profil.php';
    }
    elseif($p == 'order'){
        require '../pages/order.php';
    }
    elseif($p == 'quote'){
        require '../pages/quote.php';
    }
    elseif($p == 'planning'){
        require '../pages/planning.php';
    }
    elseif($p == 'calendar'){
        require '../pages/calendar.php';
    }
    elseif($p == 'purchase'){
        require '../pages/purchase.php';
    }
    elseif($p == 'article'){
        require '../pages/article.php';
    }
    elseif($p == 'quality'){
        require '../pages/quality.php';
    }
    elseif($p == 'login'){
        require '../pages/login.php';
    }
    else{
        require '../pages/login.php'; 
    }
    $content = ob_get_clean();

    require '../pages/templates/default.php';