<?php
	require_once 'connection.php';
	require_once 'DB.php';
	// require_once 'User.php';

	class DBSQL extends DB
	{

    private $database;
		private $connection;

    public function __construct($dbName)
		{
			$this->database = $dbName;

			$host = "mysql:host=localhost; dbname={$this->database}; charset=utf8mb4";
			$user = 'root';
			$pass = '';

			try{
				$this->connection = new PDO(
					$host,
					$user,
					$pass,
					[PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
			}catch( PDOException $Exception ) {
		   	echo $Exception->getMessage();
			}
		}



		// private $database;
		private static $allUsers;


    public function getAllUsers(){
      $query = $this->connection->query("
			SELECT *
			FROM user
		  ");

		return $query->fetchAll(PDO::FETCH_ASSOC);
    }

    public function emailExist($email){
      $query = $this->connection->query("
			SELECT userEmail
			FROM 'user'
		  WHERE userEmail = '$email'");
      try {
        $query->fetch(PDO::FETCH_ASSOC);
      } catch (PDOException $Exception) {
        return false;
      }
      return true;
    }

    public function userExist($user){
      $query = $this->connection->query("
			SELECT userName
			FROM 'user'
		  WHERE userName = '$user'");
      try {
        $query->fetch(PDO::FETCH_ASSOC);
      } catch (PDOException $Exception) {
        return false;
      }
      return true;
    }

    public function getUserByEmail($email){
      $query = $this->connection->query("
			SELECT *
			FROM 'user'
		  WHERE userEmail = '$email'");
      try {
        $resp=$query->fetch(PDO::FETCH_ASSOC);
      } catch (PDOException $Exception) {
        return false;
      }
      return $resp;
    }

    public function getUserByEmailOrUserName($userOrEmail){
      $query = $this->connection->query("
			SELECT *
       FROM 'user' WHERE userName like '$userOrEmail' OR userEmail like '$userOrEmail' ");
      try {
        $resp=$query->fetch(PDO::FETCH_ASSOC);
      } catch (PDOException $Exception) {
        return false;
      }
      return $resp;
    }

    public function saveUser(User $user){

      // echo "<pre>";
      // print_r($user);
      // exit;

      $insertStmt = $this->connection->prepare("
			INSERT INTO user (
				userName,
        userFullName,
        userNationality,
        userEmail,
        userPassword,
        userTarget,
        userQuestion,
        userAnswer,
        userImage
			)
			VALUES (
        :userName,
        :userFullName,
        :userNationality,
        :userEmail,
        :userPassword,
        :userTarget,
        :userQuestion,
        :userAnswer,
        :userImage
			)
		");

    $userName = $user->getUserName();
    $name = $user->getName();
    $country = $user->getCountry();
    $email = $user->getEmail();
    $password = $user->getPassword();
    $target = $user->getTarget();
    $securityQuestion = $user->getSecurityQuestion();
    $securityAnswer = $user->getSecurityAnswer();
    $image = $user->getImage();

		$insertStmt->bindValue(':userName', $userName, PDO::PARAM_STR);
		$insertStmt->bindValue(':userFullName', $name, PDO::PARAM_STR);
		$insertStmt->bindValue(':userNationality', $country, PDO::PARAM_STR);
		$insertStmt->bindValue(':userEmail', $email, PDO::PARAM_STR);
		$insertStmt->bindValue(':userPassword', $password, PDO::PARAM_STR);
		$insertStmt->bindValue(':userTarget', $target, PDO::PARAM_STR);
		$insertStmt->bindValue(':userQuestion', $securityQuestion, PDO::PARAM_STR);
    $insertStmt->bindValue(':userAnswer', $securityAnswer, PDO::PARAM_STR);
		$insertStmt->bindValue(':userImage', $image, PDO::PARAM_STR);

		$insertStmt->execute();

		return true;

      // $userName = $user->getUserName();
      // $name = $user->getName();
      // $country = $user->getCountry();
      // $email = $user->getEmail();
      // $password = $user->getPassword();
      // $target = $user->getTarget();
      // $securityQuestion = $user->getSecurityQuestion();
      // $securityAnswer = $user->getSecurityAnswer();
      // $image = $user->getImage();
      // $query = $this->connection->prepare("
      // INSERT INTO 'user' ('userName', 'userFullName', 'userNationality', 'userEmail', 'userPassword', 'userTarget', 'userQuestion', 'userAnswer', 'userImage')
      // VALUES ('$userName' , '$name', '$country', '$email', '$password', '$target', '$securityQuestion', '$securityAnswer', '$image')");
      // $query->execute();


    }

    public function theLast($db)
		{
			$stmt = $this->connection->prepare("SELECT id FROM user ORDER BY id DESC");
			$stmt->execute();

			$result = $stmt->fetch(PDO::FETCH_OBJ);

			if ($result) {
        $this->migrateFromJson($db);
      }
			return false;
		}


    public function migrateFromJson($db){

      $allUsers = $db->getAllUsers();

      // echo "<pre>";
      // print_r($allUsers);
      // exit;

      foreach ($allUsers as $oneUser) {

          $insertStmt = $this->connection->prepare("
    			INSERT INTO user (
    				userName,
            userFullName,
            userNationality,
            userEmail,
            userPassword,
            userTarget,
            userQuestion,
            userAnswer,
            userImage
    			)
    			VALUES (
            :userName,
            :userFullName,
            :userNationality,
            :userEmail,
            :userPassword,
            :userTarget,
            :userQuestion,
            :userAnswer,
            :userImage
    			)
    		");

        $userName = $oneUser->user;
        $name = $oneUser->name;
        $country = $oneUser->country;
        $email = $oneUser->email;
        $password = $oneUser->password;
        $target = $oneUser->target;
        $securityQuestion = $oneUser->securityQuestion;
        $securityAnswer = $oneUser->securityAnswer;
        $image = $oneUser->image;


        $insertStmt->bindValue(':userName', $userName, PDO::PARAM_STR);
    		$insertStmt->bindValue(':userFullName', $name, PDO::PARAM_STR);
    		$insertStmt->bindValue(':userNationality', $country, PDO::PARAM_STR);
    		$insertStmt->bindValue(':userEmail', $email, PDO::PARAM_STR);
    		$insertStmt->bindValue(':userPassword', $password, PDO::PARAM_STR);
    		$insertStmt->bindValue(':userTarget', $target, PDO::PARAM_STR);
    		$insertStmt->bindValue(':userQuestion', $securityQuestion, PDO::PARAM_STR);
        $insertStmt->bindValue(':userAnswer', $securityAnswer, PDO::PARAM_STR);
    		$insertStmt->bindValue(':userImage', $image, PDO::PARAM_STR);

    		$insertStmt->execute();

      }

      return true;


    }




  }
