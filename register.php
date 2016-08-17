<?php
	require_once 'core/init.php';
   include('views/parts/header.php');


    /*
     * if user is logged in and trying to access register page redirect to home page
     * 
     * */
    $user = new User();
    if($user->isLoggedIn())
    {
        Redirect::to('index.php');
    }

	//check to see if the button on the form was clicked
	//calling a static function/method
	if(Input::exists())
	{
		//validate that the token exists and is valid
		//calling a static function/method
		if(Token::check(Input::get('token')))
		{

			//echo 'submitted i have been run';

			//echo $_POST['username'];
			//echo Input::get('username');//getter method
			$validate = new Validate();
			$validation = $validate->check($_POST, array(
					'username' => array(
							'required' => true,
							'min' => 2,
							'max' => 20,
							'unique' => 'author'//username should be unique in the author table
						),
					'password' => array(
							'required' => true,
							'min' => 6
						),
					'password_again' => array(
							'required' => true,
							'matches' => 'password'
						),
					'first_name' => array(
							'required' => true,
							'min' => 2,
							'max' => 50
						),
					'last_name' => array(
						'required' => true,
						'min' => 2,
						'max' => 50
					)
				));

			if($validation->passed())
			{
				$user = new User();

				//$salt = Hash::salt(32);//this resulted to error during login
				$salt = Hash::random_num();
				try
				{
					
					$sha_pass = Hash::make(trim(Input::get('password')),$salt);
					
					$user->create(array(
							'username'=>trim(Input::get('username')),
							'password'=>$sha_pass,
							'first_name'=>Input::get('first_name'),
							'last_name'=>Input::get('last_name')
						));
	
					Session::flash('home', 'You have been registered and now you can login');
					Redirect::to('index.php');

				}
				catch(Exception $e)
				{
					die($e->getMessage());
				}


			}
			else
			{	?>

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
				<form method="post" action="">
					<div class="form-group">
						<label for="first_name">First Name</label>
						<input type="text" class="form-control" name="first_name" id="first_name" value="<?php echo Input::get('first_name');?>" autocomplete="off" required placeholder="First Name">
					</div>
					<div class="form-group">
						<label for="last_name">Last Name</label>
						<input type="text" class="form-control" name="last_name" id="last_name" value="<?php echo Input::get('last_name');?>" required placeholder="Last Name">
					</div>
					<div class="form-group">
						<label for="username">Username</label>
						<input type="text" class="form-control" name="username" id="username" value="<?php echo Input::get('username');?>" required placeholder="Username">
					</div>
					<div class="form-group">
						<label for="password">Password</label>
						<input type="password" class="form-control" name="password" id="password" required placeholder="Password">
					</div>
					<div class="form-group">
						<label for="password_again">Password</label>
						<input type="password" class="form-control" name="password_again" id="password_again" required placeholder="Password">
					</div>
					<input type="hidden" name="token" value="<?php echo Token::generate();?>">
					<button type="submit" class="btn btn-default">Register</button>
					<button type="submit" class="btn btn-default"><a href="login.php">Login</a></button>
				</form>
			</div>
		</div>
	</div>
</section>


<?php
   include('views/parts/footer.php');

?>