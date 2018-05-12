<?php
require_once 'core/init.php';

if (Input::exists()) {
    if (Token::check(Input::get('token'))) {

        $validate = new Validate();
        $validation = $validate->check($_POST, array(
                'username' => array('required' => true),
                'password' => array('required' => true)
        ));

        if ($validation->passed()) {
            // Log user in
            $user = new User();
            // utilizing login user and after check it
            $login = $user->login(Input::get('username'), Input::get('password'));

            if($login) {
                echo 'Success';
            } else {
                echo '<p>Sorry, logging in failed.</p>';
            }

        } else {
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

    <title>Sign In</title>

    <!-- Bootstrap core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="css/signin.css" rel="stylesheet">
</head>

<body class="text-center">
<form class="form-signin" method="post" action="">

    <img class="mb-4" src="svg/drop.svg" alt="" width="72" height="72">
    <h1 class="h1 font-weight-bold">Sign in</h1>

    <label for="username" class="sr-only">Email address</label>
    <input type="text" class="form-control" id="username" name="username" placeholder="Username" autocomplete="off" autofocus>

    <label for="password" class="sr-only">Password</label>
    <input type="password" class="form-control" id="password" name="password" placeholder="Password" autocomplete="off">

    <div class="checkbox mb-3">
        <label class="check">
            <input type="checkbox" value="remember-me"> Remember me
        </label>
    </div>

    <input type="hidden" name="token" value="<?php echo Token::generate(); ?>">
    <input type="submit" class="btn btn-lg btn-primary btn-block" value="Log in">
    <input type="button" class="btn btn-lg btn-info btn-block" value="Register" onclick="document.location='login.php'">

    <p class="mt-5 mb-3 text-muted">&copy; Created by Alex Baer in 2018</p>
</form>
</body>
</html>
