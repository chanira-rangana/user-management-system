<!-- this file is used to destroy session and destroy cookie related to session  -->

<?php
    session_start();

    // remove session values with assigning empty array
    $_SESSION = array();


    // $_COOKIE[session_name()] -> session related cookie
    if(isset($_COOKIE[session_name()])){

        /* 
            setcookie($cookie_name, $cookie_value, time() + (86400 * 30), "/") 
            setcookie(name, value, expire, path); path=affecting files "/" means affected to whole project
        */
        setcookie(session_name(),'',time()-86400,'/');
    }

    // destroy session
    session_destroy();

    //redirect to the index.php page
    header('Location: index.php?logout=true');
?>