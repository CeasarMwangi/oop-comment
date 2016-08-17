<?php
 function escape($string){

 	//escape both single and double quotes
 	return htmlentities($string, ENT_QUOTE,'UTF-8');
 }