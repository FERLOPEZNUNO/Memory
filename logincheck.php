<?php

//si existe contenido en "enviarform" (name del botón submit del form de login) se inicia sesión y se inicia la verificación de passwords
if (isset($_POST["enviarForm"])) {

    session_start();

    //nombre y pw se recogen del POST del form de login.php:
    $nombre = $_POST["nom"];
    $pass = $_POST["pw"];
    $sortir = false;

    //se guarda en la variable $fitxer el archivo usuaris.txt:
    $fitxer = fopen("usuaris.txt", "r");

    //mientras exista una nueva línea en fitxer y el boleano "sortir" sea falso iremos guardando en el array "$usuario" cada línea.
    //las líneas se separan por el "/", es decir en el array habrá 2 posiciones: 0=nombre 1=password:
    while ((($linea = fgets($fitxer)) && !$sortir)) {

        $usuario = explode("/", trim($linea));

        //se comprueba que el nombre (posición[0] del array) y la pass ([1]) coincidan con los recogidos por POST del form de login.php:
        if ($usuario[0] == $nombre && $usuario[1] == $pass) {

            //si coinciden, creamos 1 variable de sesión llamada nombre que usaremos en joc.php para verificar que hay sesión iniciada,
            //y ponemos "sortir" en falso para que salga del while.
            $_SESSION["nombre"] = $nombre;
            $sortir = true;
        }
    }

    //cerramos fichero (HACER SIEMPRE!!)
    fclose($fitxer);

    //una vez acabado el while, si "sortir" es true te envía a joc.php
    if ($sortir) {
        header("Location:joc.php");
    } 

    //si no, te envía a error.php en la variante falloBrutal (credenciales incorrectas)
    else {
        header("Location:error.php?falloBrutal=ERROR_DE_LOGIN");
    }

//si no existe contenido en el post, es decir, si no se ha hecho el login, te envía al error "hay que pasar x la página de login":
} else {
    header("Location:error.php");
}
