<?php
	// include for the constants
    require_once '../include/include_recup_config.php';
    // include for functions
    require_once '../include/include_fonctions.php';
    
    use \App\SQL;
    use \App\Auth;

	//auto load class
	require '../app/Autoload.class.php';
    App\Autoloader::register();

    //open sql connexion
    $bdd = new SQL();
    
	//session checking  user
	$auth = New Auth($bdd);
	$User = $auth->User();

    /* Getting file name */
    $filename = $_FILES['file']['name'];

    /* Getting File size */
    $filesize = $_FILES['file']['size'];

    $Folder = substr($_GET['type'],0,-3);

    if (!file_exists("../public/Files/". $Folder))
    {
            mkdir ("../public/Files/". $Folder,0700);  
    }

    if (!file_exists("../public/Files/". $Folder ."/". $_GET['id']))
    {
        mkdir ("../public/Files/". $Folder ."/". $_GET['id'],0700);
    }
    
    /* Location */
    $location = "../public/Files/". $Folder ."/". $_GET['id'] ."/".$filename;

    $return_arr = array();

    /* Upload file */
    if(move_uploaded_file($_FILES['file']['tmp_name'],$location)){
        $src = "default.png";
        
        // checking file is image or not
        if(is_array(getimagesize($location))){
            $src = $location;
        }
        $return_arr = array("name" => $filename,"size" => $filesize, "src"=> $src);

        $bdd->GetInsert("INSERT INTO ".TABLE_ERP_ATTACHED_DOCUMENT."(LABEL, 
                                                                        DATE, 
                                                                        PATH_FILE, 
                                                                        SIZE, 
                                                                        CREATOR_USER_ID, 
                                                                        ". $_GET['type'] .") 
                                                                        VALUES( '". $filename ."',
                                                                                NOW(), 
                                                                                '". $location ."',
                                                                                '". $filesize ."',
                                                                                '". $User->idUSER ."', 
                                                                                '". $_GET['id'] ."')");
                

    }else{
        $return_arr = array("name" => "error","size" => "N/A", "src"=> "N/A");

    }
    
    echo json_encode($return_arr);