<?php
    require_once 'core/init.php';
   include('views/parts/header.php');

?>
        <div class="content">
<?php
    if(Session::exists('home')){
            echo '<p>'. Session::flash('home') .'</p';
    }

    $user = new User();

    if($user->isLoggedIn())
    {
        Redirect::to('home.php');

    }
    else
    {
        Redirect::to('login.php');
    }

    include('views/parts/footer.php');