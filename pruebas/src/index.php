<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <?php 
    define("PI", 3.1416);
        $name="pepe";
        $year = 2021;
        $birthDate = new DateTime("2000-10-21 20:25:15");
        echo "Tipo de birthDate: " . gettype($birthDate) . "<br>";
        echo "Isset year"  . isset($year) . "<br>";
        echo $name . "<br>" . $birthDate->format("Y-m-d H:i:s") . "<br>" . $year;

        $miArray = [1 => "Lunes", 2=> "Martes", 3=>"Miercoles",4=>"Jueves", 5=> "Viernes"];  

        echo "Array empty: " . empty($miArray). "<br>";
        echo "Array isset: " . isset($miArray). "<br>";

        echo "Constante PI: " . PI . "<br>";
        echo "miArray: " . print_r($miArray). "<br>";
    ?> 
</body>
</html>