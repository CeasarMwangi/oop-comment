<?php
    require_once 'core/init.php';
   include('views/parts/header.php');

    if(Session::exists('login_success')){
            echo '<p>'. Session::flash('login_success') .'</p>';
    }

    $user = new User();

    if($user->isLoggedIn())
    {
       
        Redirect::to('views/posts.php');

    }
    else
    {
        Redirect::to('login.php');
    }

   include('views/parts/footer.php');
