<?php

class Redirect{

	public static function to($location = null)
	{
		if($location)
		{
			if(is_numeric($location))
			{
				switch ($location) 
				{
					case 404:
					header('HTTP/1.0 404 Not Found');
					include 'includes/errors/404.php';
						exit();
					break;

				}
			}
			
			header('Location: '.$location); //this is giving an error
			//Redirect::redirect_to($url); //call to method below
			exit();
		}

	}

	public function redirect_to($url) 
	{
	        flush(); // Flush the buffer to get lid of any set header information
	        ob_flush();//clear all
	        header("Location: $url"); // Rewrite the header
	        die;
	}
}