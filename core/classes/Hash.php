<?php

class Hash{

	public static function make($string){

		return hash('sha256', $string);
	}

//this resulted to error during login

	public static function salt($length){
		return mcrypt_create_iv($length);
		
	}


	public static function unique(){

		return self::make(uniqid());
	}
	public static function random_num(){
	
		return mt_rand();
	}
}