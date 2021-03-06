<?php
require_once 'loader.php';

$errors = array();

if (isset($_SESSION['email'])) {
    rediret('index.php');
} else if ($_POST) {
    $avatar = 'default.jpeg';
    $user = new User($_POST['email'], $_POST['password'], $_POST['first_name'], $_POST['last_name'], $avatar);
    // valida el usuario, haciendo uso del metodo validate de la class Validator
    $errors = $validator->validate($user, $_POST['cpassword']);
    // Busca si el mail ya se encuntra registrado
    if (MYSQL::searchUser($user->getEmail(), $pdo) != null) {
        $errors['email'] = 'Este email ya se encuentra registrado';
    }

    if (count($errors) == 0) {
        $userArray = $factory->create($user);
        MYSQL::saveUser($userArray, $pdo);
        rediret('login.php');
    }
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Registrate | techHUB</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/css?family=Raleway:300,400,500,700" rel="stylesheet">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css" integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous">
    <link rel="stylesheet" href="css/styles-login-register.css">
</head>

<body>
    <header class="container_header">
        <a href="index.php"><img class="img_logo" src="img/logo_techhub_5.png" alt="logo"></a>
    </header>
    <main>
        <div class="container_signup">
            <div class="form_header">
                <div class="signup_title">
                    Regístrate
                </div>
                <div class="already_user">
                    ¿Ya tienes una cuenta techHub?
                    <a href="login.php">Iniciar Sesión</a>
                </div>
            </div>
            <div class="signup_section">
                <div class="form_content">
                    <form class="form_signup" action="" method="post">
                        <div class="nombre-apellido">
                            <div class="name">
                                <input class="input_change" type="text" name="first_name" required value="<?= (isset($errors["first_name"])) ? "" : $validator->persist("first_name") ?>" autofocus>
                                <label>Nombre</label>

                                <span class="errores">
                                    <?php
                                    if (isset($errors["first_name"])) : ?>
                                        <?= "*" . $errors["first_name"]; ?>
                                    <?php endif; ?>
                                </span>

                            </div>
                            <div class="apellido">
                                <input class="input_change" type="text" name="last_name" required value="<?= (isset($errors["last_name"])) ? "" : $validator->persist("last_name") ?>">
                                <label>Apellido</label>

                                <span class="errores">
                                    <?php
                                    if (isset($errors["last_name"])) : ?>
                                        <?= "*" . $errors["last_name"]; ?>
                                    <?php endif; ?>
                                </span>

                            </div>
                        </div>
                        <div class="email">
                            <input class="input_change" type="email" name="email" required value="<?= (isset($errors["email"])) ? "" : $validator->persist("email") ?>">
                            <label>Email</label>

                            <span class="errores">
                                <?php
                                if (isset($errors["email"])) : ?>
                                    <?= "*" . $errors["email"]; ?>
                                <?php endif; ?>
                            </span>

                        </div>
                        <div class="pass">
                            <input class="input_change" type="password" name="password" required value="">
                            <label>Contraseña</label>

                            <span class="errores">
                                <?php
                                if (isset($errors["password"])) : ?>
                                    <?= "*" . $errors["password"]; ?>
                                <?php endif; ?>
                            </span>

                        </div>
                        <div class="pass_again">
                            <input class="input_change" type="password" name="cpassword" required value="">
                            <label>Escribe tu contraseña de nuevo</label>

                            <span class="errores">
                                <?php
                                if (isset($errors["cpassword"])) : ?>
                                    <?= "*" . $errors["cpassword"]; ?>
                                <?php endif; ?>
                            </span>

                        </div>
                        <input class="submit_button" type="submit" name="" value="Regístrate">
                    </form>
                </div>
                <div class="divider">
                    <!-- linea vertical -->
                </div>
                <div class="o-xs-register d-lg-none">
                    <div class="separador_horizontal"></div>
                    <div class="texto-separador">O utiliza</div>
                    <div class="separador_horizontal"></div>
                </div>
                <div class="signup_social">
                    <a class="href_facebook" href="#">
                        <div class="facebook">
                            <div class="facebook_icon">
                                <i class="fab fa-facebook-f"></i>
                            </div>
                            Continuar con Facebook
                        </div>
                    </a>
                    <a class="href_google" href="#">
                        <div class="google">
                            <div class="google_icon">
                                <i class="fab fa-google"></i>
                            </div>
                            Continuar con Google
                        </div>
                    </a>
                </div>
            </div>
            <!-- <div class="signup_social_focus">
            <div class="facebook_mini_icon">
            <i class="fab fa-facebook-f"></i>
            </div>
            <div class="google_mini_icon">
            <i class="fab fa-google"></i>
            </div>
        </div> -->
        </div>
    </main>
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
</body>

</html>