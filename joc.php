<?php
session_start();

//si NO hay sesión iniciada te envía al error que indica que hay que pasar por la pag de login:
if (!isset($_SESSION["nombre"])) {
    header("Location:error.php");

    //en caso contrario imprime el juego:
} else {
    //incluimos las funciones
    include "funciones.php";

    //guardamos el string que será "record_nombredeusuario"

    $nombrerecord = "record_".$_SESSION["nombre"];

    if ((!isset($_SESSION["tablero"])) || (isset($_POST["resetear"]))) {

        //variable llamada "fichas" en la que guardamos el array resultante del método creataula:
        $_SESSION["tablero"] = creaTaula();
        //esto crea 1 array llamado "visible" con 20 posiciones de boleanos "false":
        $_SESSION["visible"] = array_fill(0, 20, false);
        //variable que usaremos para contar los giros de cartas:
        $_SESSION["movimientos"] = 0;
        $_SESSION["carta1"] = null;
        $_SESSION["carta2"] = null;
        //para guardar el indice de la ficha que hemos giraedo en 1a y 2a jugada:
        $_SESSION["indice1"] = null;
        $_SESSION["indice2"] = null;

        //para contabilizar jugadas para el récord:
        $_SESSION["contadorJugadas"] = 0;
    }
    if (isset($_POST["girar"])) {

        $indice = $_POST["girar"];

        //comprobamos si la carta ya es visible o no. si ya lo es, no se hace nada:
        if ($_SESSION["visible"][$indice]) {

            //si aun no es visible (mano), se comprueba lo que se va a tener que hacer según el nº de movimiento en el que estemos:
        } else {

            //sumamos 1 a "movimientos"
            $_SESSION["movimientos"]++;

            //si estamos en la 1a jugada...
            if ($_SESSION["movimientos"] == 1) {

                //nos guardamos en "carta1" la posicón del tablero, que será = al animal que contiene (&#120....ettc):
                $_SESSION["carta1"] = $_SESSION["tablero"][$indice];

                //guardamos el ind. del 1er movimiento para poder usarlo en otros movimientos:
                $_SESSION["indice1"] = $indice;

                //hacemos que la carta se haga visible:
                $_SESSION["visible"][$indice] = true;


            //si estamos en la 2a jugada...
            } elseif ($_SESSION["movimientos"] == 2) {

                //nos guardamos en carta2 la posición:
                $_SESSION["carta2"] = $_SESSION["tablero"][$indice];

                //guardamos indice del 2º movimiento:
                $_SESSION["indice2"] = $indice;

                //hacemos que la carta sea visible:
                $_SESSION["visible"][$indice] = true;


                $_SESSION["contadorJugadas"]++;


                //se comprueba si la carta 1 y la 2 son iguales:
                if ($_SESSION["carta1"] == $_SESSION["carta2"]) {

                    //si lo son, se resetean las variables:
                    $_SESSION["carta1"] = null;
                    $_SESSION["carta2"] = null;

                    //reseteamos los movimientos: empieza una nueva jugada
                    $_SESSION["movimientos"] = 0;
                }


                //en caso de que no sean iguales, volvemos a girar las cartas
            } 
            
            elseif ($_SESSION["movimientos"] == 3) {

                //se "giran" las cartas si no son iguales (vuelven a "mano")
                $_SESSION["visible"][$_SESSION["indice1"]] = false;
                $_SESSION["visible"][$_SESSION["indice2"]] = false;

                //ponemos en "carta1" e "indice1" la nueva chapa elegida, y la giramos (true):
                $_SESSION["carta1"] = $_SESSION["tablero"][$indice];
                $_SESSION["indice1"] = $indice;
                $_SESSION["visible"][$indice] = true;

                //se resetea movimientos a 1 (es la 1a jugada, no la "0") y se vacía carta2 y su index:
                $_SESSION["movimientos"] = 1;
                $_SESSION["carta2"] = null;
                $_SESSION["indice2"] = null;
            }
        }
    }

    //en caso de que: 1- gana()=true (es decir, que todas las cartas estén giradas) 2- no exista cookie de record o 3-exista, pero sea menor que la jugada actual,
    //creamos nueva cookie con la jugada actual y le damos una durabilidad de 1 mes:
    if (gana() && (!isset($_COOKIE[$nombrerecord]) || $_SESSION["contadorJugadas"] < $_COOKIE[$nombrerecord])) {

        setcookie($nombrerecord, $_SESSION["contadorJugadas"], time() + (30 * 24 * 60 * 60), "/");
    }

?>
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>JOC</title>
        <link rel="stylesheet" href="css/estilsJoc.css">
    </head>

    <body>
    
        <h1>🐙BENVINGUT AL JOC DE LES PARELLES🐙</h1>
        <?php
        //llamamos a mostrarTaula (que genera la tabla de 20 chapas) y le enviamos como param. la variable $fichas (que es 1 array):
        mostraTaula();
        ?>
        <!-- form/botón de resetear partida; action vacía porque lleva a la misma página (ver abajo) -->
        <form action="" method="post">
            <button class="resetear" type="submit" name="resetear">Nova partida</button>
        </form>
        <h1>Portes <?php echo isset($_SESSION["contadorJugadas"]) ? $_SESSION["contadorJugadas"] : 0; ?> jugades.</h1>
        <h1>Record:  <?php echo isset($_COOKIE[$nombrerecord]) ?$_COOKIE[$nombrerecord] : 0; ?> jugades.</h1>
    </body>

    </html>
<?php
}
?>