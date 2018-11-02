<?php
	require_once 'DB.php';
	// require_once 'User.php';

	class DBJson extends DB
	{
		private $database;
		private static $allUsers;

		function __construct($archive)
		{
			$this->database = $archive;
			self::$allUsers = self::getAllUsers();
		}

		public function getAllUsers(){
			$allUsersString = file_get_contents('data/users.json');

			$usersInArray = explode(PHP_EOL, $allUsersString);
			array_pop($usersInArray);

			$finalUsersArray = [];

			foreach ($usersInArray as $oneUser) {
				$finalUsersArray[] = json_decode($oneUser);
			}

			return $finalUsersArray;
		}

		public function emailExist($email){
			foreach (self::$allUsers  as $oneUser) {
				if ($email == $oneUser->email) {
					return true;
				}
			}

			return false;
		}

		public function userExist($user){
			foreach (self::$allUsers  as $oneUser) {
				if ($user == $oneUser->user) {
					return true;
				}
			}

			return false;
		}

		public function getUserByEmail($email){
			foreach (self::$allUsers as $oneUser) {
				if($oneUser->email == $email) {
					$elUsuarioEncontrado = (array) $oneUser;
					$finalUser = new User($elUsuarioEncontrado);
					$finalUser->setId($elUsuarioEncontrado['id']);
					return $finalUser;
				}
			}

			return false;
		}
		public function getUserByEmailOrUserName($userOrEmail){
			foreach (self::$allUsers as $oneUser) {
				if($oneUser->email == $userOrEmail) {
					$elUsuarioEncontrado = (array) $oneUser;
					$finalUser = new User($elUsuarioEncontrado);
					$finalUser->setId($elUsuarioEncontrado['id']);
					return $finalUser;
				} elseif ($oneUser->user == $userOrEmail) {
          $elUsuarioEncontrado = (array) $oneUser;
          $finalUser = new User($elUsuarioEncontrado);
          $finalUser->setId($elUsuarioEncontrado['id']);
          return $finalUser;
        }
			}

			return false;
		}

		public function generateId()
		{
			if( count(self::$allUsers) == 0 ) {
				return 1;
			}

			$lastUser = array_pop(self::$allUsers);

			return $lastUser->id + 1;
		}

		public function saveUser(User $user){
			$userInJsonFormat = json_encode($user->exportUserData());

			file_put_contents($this->database, $userInJsonFormat . PHP_EOL, FILE_APPEND);
		}
	}
