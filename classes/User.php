<?php

	class User
	{
		private $id;
		private $name;
		private $user;
    private $country;
		private $email;
		private $password;
		private $target;
		private $securityQuestion;
		private $securityAnswer;
		private $image;

		public function __construct($post)
		{
			$this->name = $post['name'];
			$this->user = $post['user'];
      $this->country = $post['country'];
			$this->email = $post['email'];
			$this->password = $post['password'];
      $this->target = $post['target'];
			$this->securityQuestion = $post['securityQuestion'];
			$this->securityAnswer = $post['securityAnswer'];
			$this->image = $post['image'];
		}

		public function setName($name)
		{
			$this->name = $name;
		}

		public function getName()
		{
			return $this->name;
		}

		public function setUserName($user)
		{
			$this->user = $user;
		}

		public function getUserName()
		{
			return $this->user;
		}

		public function setTarget($target)
		{
			$this->target = $target;
		}

		public function getTarget()
		{
			return $this->target;
		}

		public function setSecurityAnswer($securityAnswer)
		{
			$this->securityAnswer = $securityAnswer;
		}

		public function getSecurityAnswer()
		{
			return $this->securityAnswer;
		}

		public function setSecurityQuestion($securityQuestion)
		{
			$this->securityQuestion = $securityQuestion;
		}

		public function getSecurityQuestion()
		{
			return $this->securityQuestion;
		}

		public function setEmail($email)
		{
			$this->email = $email;
		}

		public function getEmail()
		{
			return $this->email;
		}

		public function getPassword()
		{
			return $this->password;
		}

		public function setPassword($password)
		{
			$this->password = $password;
		}

		public function getCountry()
		{
			return $this->country;
		}

		public function setCountry($country)
		{
			$this->country = $country;
		}

		public function getImage() {
			return $this->image;
		}

		public function setImage($image)
		{
			$this->image = $image;
		}

		public function getId(){
			return $this->id;
		}

		public function setId($id)
		{
			$this->id = $id;
		}

		public function hashPassword()
		{
			return password_hash($this->password, PASSWORD_DEFAULT);
		}

		public function exportUserData(){
			return [
				'id' => $this->id,
				'name' => $this->name,
        'user' => $this->user,
        'target' => $this->target,
        'securityQuestion' => $this->securityQuestion,
        'securityAnswer' => $this->securityAnswer,
				'email' => $this->email,
				'password' => $this->hashPassword($this->password),
				'country' => $this->country,
				'image' => $this->image,
			];
		}
	}
