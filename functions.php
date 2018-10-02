
<?php
		require_once 'constant.php';

		session_start();

		// pregunto si esta setiada la cookie para loggear directamente al usuario
		if ( isset($_COOKIE['userLogged'] ) ) {
		$user = getUserByEmailOrUserName($_COOKIE['userLogged']);
		unset($user['password']);
		$_SESSION['user'] = $user;
		}


		// funcion Validar Register
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
		else if (userExist($user)){
			$errors['user'] = 'El nombre de usuario ya esta en uso';
		}
		// CUANDO SE PUEDA VALIDAR EN TIEMPO REAL, PARA QUE HAYA SOLO UN USUARIO CON DICHO NOMBRE

		if ( empty($email) ) {
			$errors['email'] = 'Escribí tu correo electrónico';
		} else if ( !filter_var($email, FILTER_VALIDATE_EMAIL) ) {
			$errors['email'] = 'Escribí un correo válido';
		}	else if ( emailExist($email) ) {
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

	// Función si existe el usuario
	function userExist($user){
		$allUsers = getAllUsers();

		foreach ($allUsers as $oneUser) {
			if ($user == $oneUser['user']) {
				return true;
			}
		}

		return false;
	}

	// Función Crear Usuarios
	function userCreator($post){
		$user = [
			'id' => setId(),
			'name' => trim($post['name']),
			'user' => trim($post['user']),
			'email' => trim($post['email']),
			'password' => password_hash($post['password'], PASSWORD_DEFAULT),
			'country' => trim($post['country']),
			'avatar' => trim($post['avatar']),
			'target' => trim($post['target']),
			'question' => trim($post['securityQuestion']),
			'answer' => trim($post['securityAnswer']),
		];

		return $user;
	}

	// function logear al usuario
	function logIn($user) {
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

	// funcion Validar Login
	function loginValidate($formData) {
	$errors = [];

	$userOrEmail = trim($formData['userOrEmail']);
	$password = trim($formData['userPassword']);

	if ( empty($userOrEmail) ) {
		$errors['userOrEmail'] = 'Ingresá tu correo electrónico o tu usuario';
	}elseif( !getUserByEmailOrUserName($userOrEmail)) {
		$errors['userOrEmail'] = 'Ingrese un correo electrónico o usuario valido';
	} else {
		$user = getUserByEmailOrUserName($userOrEmail);
		if ( !password_verify($password, $user['password']) ) {
			$errors['userPassword'] = 'Contraseña incorrecta';
		}
	}

	if ( empty($password) ) {
		$errors['userPassword'] = 'Ingresá una contraseña';
	}

	return $errors;
}

// función traer al usuario por email o por user name
function getUserByEmailOrUserName($userOrEmail) {
	$allUsers = getAllUsers();

	foreach ($allUsers as $oneUser) {
		if ($oneUser['email'] === $userOrEmail) {
			return $oneUser;
		}
		else if ($oneUser['user'] === $userOrEmail) {
			return $oneUser;
		}
	}
	return false;
}

function searchAccountValidate($formData){
	$errors = [];

	$userOrEmail = trim($formData['userOrEmail']);
	$pregunta = trim($formData['securityQuestion']);
	$respuesta = trim($formData['securityAnswer']);

	if (empty($userOrEmail) ) {
		$errors['userOrEmail'] = 'Ingresá tu correo electrónico o tu usuario';
	}	elseif( !getUserByEmailOrUserName($userOrEmail)) {
		$errors['userOrEmail'] = 'Ingrese un correo electrónico o usuario valido';
	}

	if (empty($pregunta)){
		$errors['securityQuestion'] = 'Elije una opcion';


	}
	if (empty($respuesta)){
		$errors['securityAnswer'] = 'Ingresá tu respuesta';

	}

	return $errors;

}

function searchAccount($formData){
	$allUsers = getAllUsers();

	foreach ($allUsers as $oneUser) {
		if ($oneUser['email'] === $formData) {
			return $oneUser;
		}
		else if ($oneUser['user'] === $formData) {
			return $oneUser;
		}
	}

	return false;
}


function getUserById($theUserId){
	$allUsers = getAllUsers();

	foreach ($allUsers as $oneUser) {
		if ($oneUser['id'] === $theUserId) {
			return $oneUser;
		}
	}
	return false;
}
//  NO ME ESTA CAMBIANDO LA CONTRASEÑAAAAA
function changePassword($theUserId, $post){
	$user=getUserById($theUserId);
	foreach ($user as $oneItem => &$itemValue) {
		if ($oneItem === 'password') {
			unset($itemValue);
			$user[$oneItem]= password_hash($post['newPassword'], PASSWORD_DEFAULT);
			// $user['password']= $post['newPassword'];
		}
	}
	return $user;
}


function newPasswordValidate($formData){
	$errors = [];

	$password = trim($formData['newPassword']);
	$rePassword = trim($formData['confirmNewPassword']);

	if (empty($password) || empty($rePassword)){
		$errors['newPassword'] = 'La contraseña no puede quedar en blanco';
	} else if ($password != $rePassword){
		$errors['newPassword'] = 'Las contraseñas no coinciden';
	} elseif ( strlen($password) < 4 || strlen($rePassword) < 4 ) {
		$errors['newPassword'] = 'La contraseña debe tener más de 4 caracteres';
	}
	return $errors;
	}

	function saveNewPassword($userWithNewPassword){
		$allUsers=getAllUsers();
		$newUserId=$userWithNewPassword['id'];
		// $user=getUserById($newUserId);
		foreach ($allUsers as $llave => $oneUser) {
			foreach ($oneUser as $key => $value) {
			if ($value === $newUserId) {
				unset($oneUser['password']);
				$oneUser['password']=$userWithNewPassword['password'];
				$allUsers[$llave] = $oneUser;
			}
		}
	}
		foreach ($allUsers as $oneUser) {
			// code...
		$userInJsonFormat = json_encode($oneUser);

		file_put_contents('data/users.json', $userInJsonFormat . PHP_EOL);
		}

		return $allUsers;

	}

?>
