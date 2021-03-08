<?php

    require_once("classes/user.php");

    // Retorna el error
    function error(){
        echo json_encode(Array(
                'error' => 'No params settled.',
                'res' => false
            )
        );    
    }

if(isset($_GET['session_action'])){    
    //Verifica el inicio de sesion
    if($_GET['session_action'] == "new_session" && isset($_GET["firstname_"]) && isset($_GET["lastname_"]) && isset($_GET["email_"]) && isset($_GET["password_"])){
        
        $firstname = $_GET["firstname_"];
        $lastname = $_GET["lastname_"];
        $email = $_GET["email_"];
        $password = $_GET["password_"];

        $user = new usuario($firstname, $lastname, $email, $password);
        echo $user->newUser();
    } else if($_GET['session_action'] == "start_session" && isset($_GET["email"])&&isset($_GET["password"])){

        $email =$_GET["email"];
        $password =$_GET["password"];

        $user = new usuario($email,$password);
        $user_data = $user->verifyUser();

        $verify = json_decode($user_data);
			
        if($verify->res == true ){

            session_start();
            $_SESSION["user"] = $user_data;
            echo $_SESSION["user"];

        }else{

            error();
        }

    } else if($_GET['session_action'] == "session_verify"){

        session_start();
        if(empty($_SESSION)){
				error();

        }else{
            echo json_encode(Array(
                    'status' => 'Sesion activa',
                    'res' => true
                    )
            );
        }
    } else if($_GET['session_action'] == "session_destroy"){
        
        session_start();
        if(empty($_SESSION)){
				error();

        } else{
            session_destroy();

            echo json_encode(Array(
                    'status' => 'Sesion terminada',
                    'res' => true
                    )
            );
        }
        
    } else{

        error();
    }


} else if (isset($_GET['book_action'])) { // Leemos la Acci�n

    if ( $_GET['book_action'] == 'set_book' && isset( $_GET['book_ID'] ) ){
        // Caso: Establecer un libro global En las Cookies.

        setcookie('book_ID', $_GET['book_ID']);
        
        echo json_encode(Array(
                'status' => 'Libro en indice.',
                'res' => true
            )
        );
    

    } else if ($_GET['book_action'] == 'get_book'){
        // Caso: Extraer un libro global En las Cookies.
        
        
        echo json_encode(Array(
                'id' => $_COOKIE['book_ID'],
                'status' => true
            )
        );

    } 


    else {
        retError();
    }

} else{
        //Mandamos a llamar el error
        error();
}

?>