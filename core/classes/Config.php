<?php
class Config
{

	//the get function
	// null is the default argument
	//usage $host = Config::get('mysql/host');
	public static function get($path = null)
	{ 
		if($path)
		{
			//$GLOBALS is defined in core/init.php
			$config = $GLOBALS['config']; 
			$path = explode('/', $path); //Break a string into an array

			//loop through the array
			foreach ($path as $bit) 
			{	
				if(isset($config[$bit]))
				{
					//set the config array to the inner array/the array element
					//note $GLOBALS['config'] is an array of arrays defined in core/init.php
					$config = $config[$bit]; //reassign the value of config[$bit] to config
				}
				else{
					return $config;
				}
			}
			return $config;
		}
		return false;
	}
}