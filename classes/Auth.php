<?php

	class Auth
	{

		public function __construct()
		{
			session_start();
			if( isset($_COOKIE['userLogged']) && !$this->isLoged() ) {
				$this->login($_COOKIE['userLogged']);
			}
		}

		public function logIn($userEmail)
		{
			unset($user['password']);
			$_SESSION['user'] = $userEmail;
			header('location: index.php');
			exit;
		}

		public function isLoged() {
			return isset($_SESSION['user']);
		}

		public function logOut()
		{
			// session_start();
			session_destroy();
			setcookie('userLogged', '', time() - 10);
			header('location: index.php');
			exit;
		}
	}
