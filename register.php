<?php
require_once 'core/init.php';

if (Input::exists()) {
    if (Token::check(Input::get('token'))) {

        $validate = new Validate();
        $validation = $validate->check($_POST, array(
            'username' => array(
                'required' => true,
                'min' => 2,
                'max' => 20,
                'unique' => 'users' //check if username already exists in DB
            ),
            'password' => array(
                'required' => true,
                'min' => 6,
            ),
            'password_again' => array(
                'required' => true,
                'matches' => 'password'
            ),
            'name' => array(
                'required' => true,
                'min' => 2,
                'max' =>50
            )
        ));

        if ($validation->passed()) {

            // register user
            //Session::flash('success', 'You have been registered successfully!');
            //header('Location: index.php');

            $user = new User();
            $salt = Hash::salt(32);

            try {
                // try to insert user, otherwise throw exception
                $user->create(array(
                        // fields to insert to DB
                        'username'    => Input::get('username'),
                        'password'    => Hash::make(Input::get('password'), $salt),
                        'email'       => Input::get('email'),
                        'salt'        => $salt,
                        'name'        => Input::get('name'),
                        'joined'      => date('Y-m-d H:i:s'),
                        'group'       => 1,
                ));

                Session::flash('home', 'You have been registered and can now log in!');
                Redirect::to('index.php');

            } catch (Exception $e) {
                die($e->getMessage());
            }
        } else {
            // output errors
            foreach ($validation->errors() as $error) {
                echo $error, '<br>';
            }
        }
    }
}
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="icons/favicon.ico">

    <title>Sign Up</title>

    <!-- Bootstrap core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="css/signin.css" rel="stylesheet">
</head>

<body class="text-center">
<form class="form-signin" method="post" action="">

    <img class="mb-4" src="svg/cactus.svg" alt="" width="72" height="72">
    <h1 class="h1 font-weight-bold">Sign Up</h1>


    <label for="email" class="sr-only"></label>
    <input type="email" class="form-control" id="email" name="email" placeholder="Your email" autofocus required>

    <label for="username" class="sr-only"></label>
    <input type="text" class="form-control" id="username" name="username" placeholder="Username" value="<?php echo escape(Input::get('username')); ?>" autocomplete="off" required>

    <label for="name" class="sr-only"></label>
    <input type="text" class="form-control" id="name" name="name" placeholder="Your name" value="<?php echo escape(Input::get('name')); ?>" autocomplete="off" required>

    <label for="password" class="sr-only"></label>
    <input type="password" class="form-control" id="password" name="password" placeholder="Choose password" required>

    <label for="password_again" class="sr-only"></label>
    <input type="password" class="form-control" id="password_again" name="password_again" placeholder="Enter password again" required>

    <!-- Generate token for session then user click submit -->
    <input type="hidden" name="token" value="<?php echo Token::generate(); ?>">

    <input type="submit" class="btn btn-lg btn-primary btn-block" value="Register">
    <input type="button" class="btn btn-lg btn-info btn-block" value="Log in" onclick="document.location='login.php'">

    <p class="mt-5 mb-3 text-muted">&copy; Created by Alex Baer in 2018</p>
</form>
</body>
</html>
