<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$config = array(
	'navigation_bar_visitor' => array(
		"Home" => "/", 
		// "News" => "/news", 
		"Login" => "/user/login", 
		"Register" => "/user/register",
	),
	'navigation_bar_user' => array(
		// "Home" => "/", 
		// "News" => "/news", 
		"Challenges" => "/challenges/view", 
		"Score" => "/user/score", 
		// "WriteUp" => "/writeup", 
		// "Wiki" => "/wiki", 
		"Profile" => "/user/profile", 
		"Logout" => "/user/logout",
	),
	'navigation_bar_admin' => array(
		// "Home" => "/", 
		// "News" => "/news", 
		"Challenges" => "/challenges/view", 
		"CreateChallenges" => "/challenges/create", 
		"Score" => "/user/score", 
		// "WriteUp" => "/writeup", 
		// "Wiki" => "/wiki", 
		"Profile" => "/user/profile", 
		"Logout" => "/user/logout",
	),
);
