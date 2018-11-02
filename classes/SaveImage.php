<?php
	abstract class SaveImage
	{
		public function uploadImage($files)
		{
			$imgName = $files['name'];
			$ext = pathinfo($imgName, PATHINFO_EXTENSION);

			$theOriginalFile = $files['tmp_name'];

			$finalName = uniqid('user_img_') .  '.' . $ext;

			$theFinalFile = USER_IMAGE_PATH . $finalName;

			move_uploaded_file($theOriginalFile, $theFinalFile);

			return $finalName;
		}
	}
