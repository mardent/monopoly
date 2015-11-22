<?php
require_once '../database/user.php';
require_once 'func_lib.php';
session_start();

if(is_array($_FILES)) {
	if(is_uploaded_file($_FILES['userImage']['tmp_name'])) {
		
		
		$targetFolder = "../../../images/avatars/";
		$fileName = generateRandomString();
		$sourcePath = $_FILES['userImage']['tmp_name'];
		$targetPath = $targetFolder.$fileName;
		
		if (filesize($sourcePath) > 1050000) {
			echo "<result>error</result>";
		} else {

			$user = unserialize($_SESSION["user"]);
			if ($user->avatar != 'Noavatar.png')
				unlink("../../../images/avatars/".$user->avatar);
			if(move_uploaded_file($sourcePath, $targetPath)) {
				Library::changeAvatar($user->login, $fileName);
				$user->avatar = $fileName;
				$_SESSION["user"] = serialize($user);
				echo "<result>$fileName</result>";
			}
		}
	}
}

function generateRandomString($length = 16) {
	$characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
	$charactersLength = strlen($characters);
	$randomString = '';
	for ($i = 0; $i < $length; $i++) {
		$randomString .= $characters[rand(0, $charactersLength - 1)];
	}
	return $randomString;
}


?>