<?php
	define('PASSWORD_SALT_A', '1yA2&BFZL81Z');
	define('PASSWORD_SALT_B', '2H*A#lv8NF40');

	function createPassword($rawPassword) {
		return strlen($rawPassword) > 0 ? sha1(md5(PASSWORD_SALT_A . $rawPassword . PASSWORD_SALT_B)) : null;
	}
	function checkPassword($rawPassword, $encryptedPassword) {
		return createPassword($rawPassword) == $encryptedPassword;
	}

	if(isset($_REQUEST["passwordEncode"])) {
		echo createPassword($_REQUEST["passwordEncode"]);
	}
?>