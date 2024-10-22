<?php
// Método para mostrar el país y su capital.
function script_1() {
    $ceu = array(
        "Italy" => "Rome", "Luxembourg" => "Luxembourg", "Belgium" => "Brussels", "Denmark" => "Copenhagen",
        "Finland" => "Helsinki", "France" => "Paris", "Slovakia" => "Bratislava", "Slovenia" => "Ljubljana",
        "Germany" => "Berlin", "Greece" => "Athens", "Ireland" => "Dublin", "Netherlands" => "Amsterdam",
        "Portugal" => "Lisbon", "Spain" => "Madrid", "Sweden" => "Stockholm", "United Kingdom" => "London",
        "Cyprus" => "Nicosia", "Lithuania" => "Vilnius", "Czech Republic" => "Prague", "Estonia" => "Tallin",
        "Hungary" => "Budapest", "Latvia" => "Riga", "Malta" => "Valetta", "Austria" => "Vienna", "Poland" => "Warsaw"
    );

    // ksort ordena por la clave del array
    ksort($ceu);

    foreach ($ceu as $pais => $capital) {
        echo "The capital of $pais is $capital\n";
    }
}

// Método para mostrar la temperatura promedio, las 5 más bajas y altas
function script_2() {
    $lista_temperaturas = array(78, 60, 62, 68, 71, 68, 73, 85, 66, 64, 76, 63, 75, 76, 73, 68, 62, 73, 72, 65, 74, 62, 62, 65, 64, 68, 73, 75, 79, 73);

    // promedio:
    $promedio = array_sum($lista_temperaturas) / count($lista_temperaturas);
    echo "Average Temperature is : " . round($promedio, 1) . "\n";

    // ordena las temperaturas quitando duplicados
    $temperaturas = array_unique($lista_temperaturas);
    sort($temperaturas);

    // temperaturas más bajas
    $temperaturasBajas = array_slice($temperaturas, 0, 5);
    echo "List of 5 lowest temperatures: " . implode(", ", $temperaturasBajas) . "\n";

    // temperaturas más altas
    $temperaturasAltas = array_slice($temperaturas, -5);
    echo "List of 5 highest temperatures: " . implode(", ", $temperaturasAltas) . "\n";
}

// Función para mostrar un menú principal
function showMenu() {
    echo "1. Script 1 (Paises y sus capitales)\n";
    echo "2. Script 2 (Temperaturas)\n";
    echo "Opcion: ";
    
    $opcion = trim(fgets(STDIN));

    switch ($opcion) {
        case 1:
            script_1();
            break;
        case 2:
            script_2();
            break;
        default:
            echo "Opcion no valida\n";
            break;
    }
}

showMenu();
?>
