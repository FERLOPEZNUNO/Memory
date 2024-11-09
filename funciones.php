<?php

//este método devolverá un array con 20 cartas (10 duplicadas):
function creaTaula()
{

    $fichas = [];
    $fichasFinal = [];
    $indice = 0;
    $indice2 = 10;

    //se dan 60 vueltas para generar un array ($fichas) en que cada ficha será un dibujo distinto:
    for ($i = 128000; $i < 128060; $i++) {
        $fichas[$indice] = "&#" . $i;
        $indice++;
    }

    //se baraja el array:
    shuffle($fichas);

    //se dan 10 vueltas: la 1a línea (posiciones 0-9 de $fichasFinal) guarda 10 chapas cogiendo las 10 primeras posiciones de $fichas 
    //y la 2a las duplica asignando la misma chapa ($i) a las posiciones 10-19 de $fichasFinal:
    for ($i = 0; $i < 10; $i++) {

        $fichasFinal[$i] = $fichas[$i];
        $fichasFinal[$indice2] = $fichas[$i];
        $indice2++;
    }

    shuffle($fichasFinal);
    //returneamos el array con 20 cartas
    return $fichasFinal;
}

function mostraTaula()
{

$contador=0;

//creamos la tabla
?><table style="font-size:70px">
        <?php
        for ($i = 0; $i < 4; $i++) {
            echo "<tr>";
            for ($j = 0; $j < 5; $j++) {

                $ficha=$_SESSION["tablero"][$contador];

                //si "visible" es false, imprimirá manos:
                if(!$_SESSION["visible"][$contador]){
                echo "<td><form action='' method='post'><button class='carta' type='submit' name='girar' value='$contador'>&#128070</button></form></td>";  
                }

                //si no, animales. el contador es la posición del array $conenidoTabla que aparecerá en cada celda (20 vueltas):
                else{
                    echo "<td><form action='' method='post'><button class='carta' type='submit' name='girar' value='$contador'>$ficha</button></form></td>";
                }
                $contador++;
            }
            echo "</tr>"; 
        }
        ?>
    </table>
<?php
}

//esta func devuelve false si 1 sola carta no es visible, es decir, si no se ha ganado; true en caso contrario.
function gana()
{
    foreach ($_SESSION["visible"] as $cartaVisible) {

        //si cualquier carta NO es visible, NO se gana
        if (!$cartaVisible) {
            return false;
        }
    }

    //si TODAS las cartas están visibles, o sea, no ha habido ningún falsed en el if de arriba, se returnea true (se ha ganado):
    return true;
}

?>