<?php
// login.php
include('database_connection.php');

session_start();
$form_data = json_decode(file_get_contents("php://input"));
$validation_error = '';

// data validation checks
if(empty($form_data->email)){
	$error[] = 'Email is required';
}
else{
	if(!filter_var($form_data->email, FILTER_VALIDATE_EMAIL)){
		$error[] = 'Invalid email format';
	}
	else{
		$data[':email'] = $form_data->email;
	}
}

if(empty($form_data->password)){
	$error[] = 'Password is required';
}

if(empty($error)){
	// read data from db according to email
	$query = "SELECT * FROM register WHERE email = :email";
	$statement = $connect->prepare($query);

	if($statement->execute($data)){
		$result = $statement->fetchAll();
		if($statement->rowCount() > 0){
			foreach ($result as $row) {
				if(password_verify($form_data->password,$row["password"])){
					$_SESSION["name"] = $row["name"];
				}else{
					$validation_error = 'Wrong password';
				}
			}
		}
		// the requested email is not valid
		else{
			$validation_error = 'Wrong email';
		}
	}
} else{
	$validation_error = implode(", ", $error);
}

$output = array(
	'error'	=> $validation_error
);

echo json_encode($output);
?>