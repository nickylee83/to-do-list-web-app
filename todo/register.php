<?php
// register.php

include('database_connection.php');
// fetch the data and store in variable
$form_data = json_decode(file_get_contents("php://input"));

$message = '';
$validation_error = '';

// form data validation
if(empty($form_data->name)){
	$error[] = 'Name is required';
} else{
	$data[':name'] = $form_data->name;
}

if(empty($form_data->email)){
	$error[] = 'Email is required';
} else{
	if(!filter_var($form_data->email, FILTER_VALIDATE_EMAIL)){
		$error[] = 'Invalid email format';
	} else{
		$data[':email'] = $form_data->email;
	}
}

if(empty($form_data->password)){
	$error[] = 'Password is required';
} else{
	// convert password to hash code
	$data[':password'] = password_hash($form_data->password, PASSWORD_DEFAULT);
}

if(empty($error)){
	// no errors found, we can write to database
	$query = "INSERT INTO register (name, email, password) VALUES (:name, :email, :password)";
	$statement = $connect->prepare($query);

	if($statement->execute($data)){
		$message = 'Registration Completed';
	}
} else{
	// convert error to message and store in variable
	$validation_error = implode(", ", $error);
}

$output = array(
	'error'		=> $validation_error,
	'message'	=> $message
);
echo json_encode($output);

?>