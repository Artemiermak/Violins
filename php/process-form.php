<?php

if (empty($_POST)) {
	print "<p>No data was submitted.</p>";
	print "</body></html>";
	exit();
}

function clear_user_input($value) {
	if (get_magic_quotes_gpc()) $value=stripslashes($value);
	$value= str_replace( "\n", '', trim($value));
	$value= str_replace( "\r", '', $value);
	return $value;
}


$body ="Here is the data that was submitted:\n";

foreach ($_POST as $key => $value) {
	$key = clear_user_input($key);
	$value = clear_user_input($value);
	
	if ($key == 'email') { 
		if (is_array($_POST['email'])) {
			$body .= "$key: ";
			$counter =1;
			
			foreach ($_POST['email'] as $value) {
				
				if (sizeof($_POST['email']) == $counter) {
					$body .= "$value\n";
					break;
				} else {
					$body .= "$value, ";
					$counter += 1;
				}
			} // end foreach
		} else {
			$body .= "$key: $value\n";
		}
	} else { 
		$body .= "$key: $value\n";
	}
} // end foreach

extract($_POST);


if(isset($_FILES['picture'])) {


	$picture_name = $_FILES['picture']['name'];


	if ($picture_name != '') {

		$body .= "picture: $picture_name\n";
	}
}



$email = clear_user_input($email);
$fname = clear_user_input($fname);


$from='From: '. $email . "(" . $fname . ")" . "\r\n" . 'Bcc: outpacer@meta.ua' . "\r\n";


$subject = 'New Profile from Web Site';


mail ('outpacer@meta.ua', $subject, $body, $from);
?>