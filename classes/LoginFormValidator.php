<?php
	require_once 'FormValidator.php';

	class LoginFormValidator extends FormValidator
	{
		private $userOrEmail;
		private $password;

		public function __construct($post)
		{
			$this->userOrEmail = isset($post['userOrEmail']) ?  $post['userOrEmail'] : '';
			$this->password = isset($post['password']) ?  $post['password'] : '';
		}

		public function isValid()
		{

			if ( empty($this->userOrEmail) ) {
				$this->addError('userOrEmail', 'Escribí tu correo electrónico');
			}

			if ( empty($this->password) ) {
				$this->addError('password', 'La contraseña no puede estar vacía');
			}

			return empty($this->getAllErrors());
		}

		public function getUserOrEmail()
		{
			return $this->userOrEmail;
		}

		public function getPassword()
		{
			return $this->password;
		}
	}
