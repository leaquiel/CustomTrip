<?php
	require_once 'FormValidator.php';
	// require_once 'autoload.php';


	class RegisterFormValidator extends FormValidator
	{
		private $name;
		private $user;
		private $email;
		private $country;
		private $password;
		private $rePassword;
		private $target;
		private $securityQuestion;
		private $securityAnswer;
		private $avatar;

		public function __construct($post, $files)
		{

      $this->name = isset($_POST['name']) ? trim($_POST['name']) : '';
      $this->user = isset($_POST['user']) ? trim($_POST['user']) : '';
      $this->email = isset($_POST['email']) ? trim($_POST['email']) : '';
      $this->country = isset($_POST['country']) ? ($_POST['country']) : '';
      $this->password = isset($_POST['password']) ? ($_POST['password']) : '';
      $this->rePassword = isset($post['confirmPassword']) ?  $post['confirmPassword'] : '';
      $this->target = isset($_POST['target']) ? ($_POST['target']) : '';
      $this->securityQuestion = isset($_POST['securityQuestion']) ? ($_POST['securityQuestion']) : '';
      $this->securityAnswer = isset($_POST['securityAnswer']) ? ($_POST['securityAnswer']) : '';
      $this->avatar = isset($files['avatar']) ?  $files['avatar'] : '';

		}


    public function isValid()
    {
    if ( empty($this->name) ) {
      $this->addError('name', 'Escribí tu nombre completo');
    }
    if ( empty($this->user) ) {
      $this->addError('user', 'Escribí tu nombre de usuario');
    }
		// else if ($db->userExist($this->user)){
		// 	$this->addError('user', 'El nombre de usuario ya esta en uso');
		// }

    if ( empty($this->email) ) {
      $this->addError('email', 'Escribí tu correo electrónico');
    } else if ( !filter_var($this->email, FILTER_VALIDATE_EMAIL) ) {
      $this->addError('email', 'Escribí un correo válido');
    }
		// else if ( $db->emailExist($this->email) ) {
		// 	$this->addError('email', 'Ese email ya fue registrado');
		// }

    if ( empty($this->password) || empty($this->rePassword) ) {
      $this->addError('password', 'La contraseña no puede estar vacía');
    } elseif ( $this->password != $this->rePassword) {
      $this->addError('password', 'Las contraseñas no coinciden');
    } elseif ( strlen($this->password) < 4 || strlen($this->rePassword) < 4 ) {
      $this->addError('password', 'La contraseña debe tener más de 4 caracteres');
    }

    if ( empty($this->country) ) {
      $this->addError('country', 'Elegí un país');
    }

    if ( empty($this->target) ) {
      $this->addError('target', 'Elegí un target');
    }

    if ( empty($this->securityQuestion) ) {
      $this->addError('securityQuestion', 'Elegí una pregunta de seguridad');
    }

    if ( empty($this->securityAnswer) ) {
      $this->addError('securityAnswer', 'Escribe una respuesta');
    }

    if ( $this->avatar['error'] !== UPLOAD_ERR_OK ) {
      $this->addError('avatar', 'Ché subite una imagen');
    } else {
      $ext = pathinfo($this->avatar['name'], PATHINFO_EXTENSION);
      if ( !in_array($ext, ALLOWED_IMAGE_TYPES) ) {
        $this->addError('avatar', 'Formato de imagen no permitido');
      }
    }

    return empty($this->getAllErrors());
  }


    public function getName()
    {
      return $this->name;
    }

    public function getUserName()
    {
      return $this->user;
    }

    public function getEmail()
    {
      return $this->email;
    }

    public function getPassword()
    {
      return $this->password;
    }

    public function getTarget() {
      return $this->target;
    }

    public function getQuestion() {
      return $this->securityQuestion;
    }

    public function getAnswer() {
      return $this->securityAnswer;
    }

    public function getCountry()
    {
      return $this->country;
    }

    public function getImage() {
      return $this->image;
    }
	}
