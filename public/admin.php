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

    if($p == 'manage-company'){
        require '../pages/admin/manage-company.php';
    }
    elseif($p == 'manage-companies'){
        require '../pages/admin/manage-companies.php';
    }
    elseif($p == 'manage-time'){
        require '../pages/admin/manage-time.php';
    }
    elseif($p == 'manage-users'){
        require '../pages/admin/manage-users.php';
    }
    elseif($p == 'manage-methodes'){
        require '../pages/admin/manage-methodes.php';
    }
    elseif($p == 'manage-study'){
        require '../pages/admin/manage-study.php';
    }
    elseif($p == 'manage-quality'){
        require '../pages/admin/manage-quality.php';
    }
    elseif($p == 'manage-accounting'){
        require '../pages/admin/manage-accounting.php';
    }
    else{
        require '../pages/login.php'; 
    }
    $content = ob_get_clean();

    require '../pages/templates/default.php';