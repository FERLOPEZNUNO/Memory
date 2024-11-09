<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>error</title>
    <link rel="stylesheet" href="css/estils.css">
    </style>
</head>

<body>

    <?php

    if (isset($_GET['falloBrutal'])) {
    ?>
        <div class="content">
            <h2>Usuari o contrasenya incorrectes.</h2>
            <a href="login.php"><strong>Tornar</strong></a>
        </div>
    <?php
    } else {
    ?>

        <div class="content">
            <h2>Has de passar abans per la pantalla de login.</h2>
            <a href="login.php"><strong>Tornar</strong></a>
        </div>

    <?php
    }
    ?>

</body>

</html>