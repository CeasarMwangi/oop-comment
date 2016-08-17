<?php
    require_once 'core/init.php';
    include('views/parts/header.php');
    /*
     * if user is logged in and trying to access login redirect to home page
     * 
     * */
    $user = new User();
    if($user->isLoggedIn())
    {
        Redirect::to('index.php');
    }
    if(Input::exists())
    {
        if(Token::check(Input::get('token')))
        {
            $validate = new Validate();
            $validation = $validate->check($_POST, array(
                            'username' => array(
                                            'required' => true,
                                            'min' => 2,
                                            'max' => 20
                                    ),
                            'password' => array(
                                            'required' => true,
                                            'min' => 6
                                    )
                        ));
            if($validation->passed())
            {
                $user = new User();
                
                $login = $user->login(trim(Input::get('username')),trim(Input::get('password')));
                if($login)
                {
                    Session::flash('login_success','Login Success');
                    Redirect::to('home.php');
                }
                else
                {
                    ?>
                    <div class="container error">
                        <div class="row">
                            <div class="col-sm-8 col-sm-offset-2">
                                <p>Login failed</p>
                            </div>
                        </div>
                    </div>
                <?php
                }
            }
            else
            {   ?>

                <div class="container error">
                    <div class="row">
                        <div class="col-sm-8 col-sm-offset-2">

                            <?php
                            foreach ($validation->errors() as $error)
                            {
                                echo $error, '<br>';
                            }
                            ?>

                        </div>
                    </div>
                </div>
                <?php
            }
        }
    }

?>

    <section>
        <div class="container">
            <div class="row">
                <div class="col-sm-8 col-sm-offset-2">
                    <form class="form-signin" action="" method="post">
                        <h2 class="form-signin-heading">Please sign in</h2>
                        <label for="username" class="sr-only">Username</label>
                        <input class="form-control" type="text" name="username" id="username" value="<?php echo Input::get('username');?>" autocomplete="off" placeholder="Username" required autofocus>


                        <label for="password" class="sr-only">Password</label>
                        <input type="password" name="password" id="password" class="form-control" placeholder="Password" autocomplete="off" required>
                        <input type="hidden" name="token" value="<?php echo Token::generate();?>">
                        <button class="btn btn-lg btn-primary btn-block" type="submit">Sign in</button>
                        <p id="reg-link">
                            <a href="register.php">Click here to Register</a>
                        </p>
                    </form>
                </div>
            </div>
        </div>
    </section>


<?php
include('views/parts/footer.php');

?>