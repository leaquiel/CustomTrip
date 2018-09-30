
<?php
		require_once 'constant.php';

		function registerValidate($formData, $files) {
		$errors = [];

		$name = trim($formData['name']);
		$user = trim($formData['user']);
		$email = trim($formData['email']);
		$password = trim($formData['password']);
		$rePassword = trim($formData['confirmPassword']);
		$country = trim($formData['country']);

		$target = trim($formData['target']);
		$question = trim($formData['securityQuestion']);
		$answer = trim($formData['securityAnswer']);
		$avatar = $files['avatar'];

		if ( empty($name) ) {
			$errors['name'] = 'Escribí tu nombre completo';
		}

		if ( empty($user) ) {
			$errors['user'] = 'Escribí tu nombre de usuario';
		}

		if ( empty($email) ) {
			$errors['email'] = 'Escribí tu correo electrónico';
		} else if ( !filter_var($email, FILTER_VALIDATE_EMAIL) ) {
			$errors['email'] = 'Escribí un correo válido';
		}
		else if ( emailExist($email) ) {
			$errors['email'] = 'Ese email ya fue registrado';
		}

		if ( empty($password) || empty($rePassword) ) {
			$errors['password'] = 'La contraseña no puede estar vacía';
		} elseif ( $password != $rePassword) {
			$errors['password'] = 'Las contraseñas no coinciden';
		} elseif ( strlen($password) < 4 || strlen($rePassword) < 4 ) {
			$errors['password'] = 'La contraseña debe tener más de 4 caracteres';
		}

		if ( empty($country) ) {
			$errors['country'] = 'Elegí un país';
		}

		if ( empty($target) ) {
			$errors['target'] = 'Elegí un target';
		}

		if ( empty($question) ) {
			$errors['securityQuestion'] = 'Elegí una pregunta de seguridad';
		}

		if ( empty($answer) ) {
			$errors['securityAnswer'] = 'Escribe una respuesta';
		}

		if ( $avatar['error'] !== UPLOAD_ERR_OK ) {
			$errors['image'] = 'Subi una imagen';
		} else {
			$ext = pathinfo($avatar['name'], PATHINFO_EXTENSION);
			if ( !in_array($ext, ALLOWED_IMAGE_TYPES) ) {
				$errors['image'] = 'Formato de imagen no permitido';
			}
		}

		return $errors;
	}

	// Función para subir la imagen
	function saveImage($image) {
		$imgName = $image['name'];
		$ext = pathinfo($imgName, PATHINFO_EXTENSION);

		$theOriginalFile = $image['tmp_name'];

		$finalName = uniqid('user_img_') .  '.' . $ext;

		$theFinalFile = USER_IMAGE_PATH . $finalName;
		// VA A ROMPER 'USER_IMAGE_PATH' ES CONSTANTE NO DECLARADA
		move_uploaded_file($theOriginalFile, $theFinalFile);

		return $finalName;
	}

	// Función Guardar Usuario
	function saveUser($post){
		$userInArray = userCreator($post);

		$userInJsonFormat = json_encode($userInArray);

		file_put_contents('data/users.json', $userInJsonFormat . PHP_EOL, FILE_APPEND);

		return $userInArray;
	}

	// Función traer todos los Usuarios
		function getAllUsers() {
			$allUsersString = file_get_contents('data/users.json');

			$usersInArray = explode(PHP_EOL, $allUsersString);

			array_pop($usersInArray);

			$finalUsersArray = [];

			foreach ($usersInArray as $oneUser) {
				$finalUsersArray[] = json_decode($oneUser, true);
			}

			return $finalUsersArray;
		}

	// Función Generar ID
	function setId(){
			$allUsers = getAllUsers();

			if( count($allUsers) == 0 ) {
				// CUANDO NO HAY USUARIOS REGISTRADOS
				return 1;
			}

			$lastUser = array_pop($allUsers);

			return $lastUser['id'] + 1;
		}

		// Función si existe el email
	function emailExist($email) {
		$allUsers = getAllUsers();

		foreach ($allUsers as $oneUser) {
			if ($email == $oneUser['email']) {
				return true;
			}
		}

		return false;
	}

	// Función Crear Usuarios
	function userCreator($post){
		$user = [
			'id' => setId(),
			'name' => $post['name'],
			'user' => $post['user'],
			'email' => $post['email'],
			'password' => password_hash($post['password'], PASSWORD_DEFAULT),
			'country' => $post['country'],
			'avatar' => $post['avatar'],
			'target' => $post['target'],
			'question' => $post['securityQuestion'],
			'answer' => $post['securityAnswer'],
		];

		return $user;
	}

	// function logear al usuario
	function logIn($user) {
		unset($user['id']);
		unset($user['password']);
		$_SESSION['user'] = $user;
		header('location: index.php');
		// header('location: profile.php');
		exit;
	}

	// function está logueado
	function isLogged() {
		return isset($_SESSION['user']);
	}











  ?>
