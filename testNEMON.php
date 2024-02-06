<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Calculadora</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f7f7f7;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 600px;
            margin: 100px auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        h1 {
            text-align: center;
        }

        form {
            display: flex;
            flex-direction: column;
        }

        label {
            margin-top: 10px;
            font-weight: bold;
        }

        input[type="text"],
        input[type="submit"] {
            padding: 10px;
            margin-top: 5px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        input[type="submit"] {
            background-color: #007bff;
            color: #fff;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        input[type="submit"]:hover {
            background-color: #0056b3;
        }

        p.error {
            color: red;
            text-align: center;
            margin-top: 10px;
        }

        p.success {
            color: green;
            text-align: center;
            margin-top: 10px;
        }
    </style>
</head>

<body>
    <div class="container">
        <h1>Calculadora</h1>
        <form method="post">
            <input type="submit" name="esborrar" value="Resetejar">
        </form>
        <form class="formulari" method="post">
            <label for="Usuari">Usuari</label>
            <input type="text" id="Usuari" name="Usuari" required>
            <label for="Operand_1">Operand_1</label>
            <input type="text" id="Operand_1" name="Operand_1" required>
            <label for="Operand_2">Operand_2</label>
            <input type="text" id="Operand_2" name="Operand_2" required>
            <label for="Operand_3">Operand_3</label>
            <input type="text" id="Operand_3" name="Operand_3">
            <input type="submit" name="afegir" value="Calcular">
        </form>
        <?php
    $servername = "db5015175849.hosting-data.io";
    $username = "dbu3994052";
    $password = "nemonyelko1234";
  	$database = "dbs12553895";

    $conn = mysqli_connect($servername, $username, $password, $database);

    if (isset($_POST['esborrar'])) {
        resertejarBaseDeDades($conn);
    }
  
    if(isset($_POST['afegir'])){
      if (isset($_POST['Usuari']) && !empty($_POST["Usuari"])) {
        if (isset($_POST['Operand_1']) && !empty($_POST["Operand_1"]) && isset($_POST['Operand_2']) && !empty($_POST["Operand_2"])) {
            comprovarIMostrar($conn);
        } else {
            echo "<p style='text-align:center'>Els camps Operand_1 i Operand_2 són obligatoris</p>";
          }
  	} else {
        echo "<p style='text-align:center'>El camp Usuari és obligatori</p>";
    	  }
        }

    function resertejarBaseDeDades($conn)
    {
 
        $sql = "USE dbs12553895";
        $result = mysqli_query($conn, $sql);

        $sql = "TRUNCATE TABLE operacions";
        $result = mysqli_query($conn, $sql);

        if ($result) {
            echo "<p style=text-align:center;>base de dades reiniciada correctament</p>";
        }
    }

    function comprovarIMostrar($conn){
        $usuari = $_POST['Usuari'];
        $operand1 = $_POST['Operand_1'];
        $operand2 = $_POST['Operand_2'];
        $operand3 = $_POST['Operand_3'];

        if(empty($_POST['Operand_3'])){
            $operand3 = null;
        }
	    
            if (is_numeric($operand1) && is_numeric($operand2) && ((is_numeric($operand3)) || $operand3 == null)) {
                $operacio = "$operand1 + $operand2 + $operand3";
                echo "<p style=text-align:center;> El resultat és " . ($operand1 + $operand2 + $operand3) . "</p>";

            } else {
                $operacio = "$operand1$operand2$operand3";
                echo "<p style='text-align:center'> El resultat és " . $operand1 . $operand2 . $operand3 . "</p>";
            }
    
            $sql = "USE dbs12553895";
            $result = mysqli_query($conn, $sql);
    
            $sql = "SELECT nom FROM operacions WHERE operacio = '$operacio'";
            $result = mysqli_query($conn, $sql);
            if (mysqli_num_rows($result) > 0) {
                if (mysqli_num_rows($result) > 0) {
                    echo "<div style=text-align:center>";
                    while ($row = mysqli_fetch_assoc($result)) {
                        echo "L'usuari " . $row["nom"] . " ha fet aquesta operació amb anterioritat.<br>";
                    }
                    echo "</div>";
                }
            }
            else {
                $sql = "INSERT INTO operacions(nom, operacio) VALUES ('$usuari', '$operacio')";
                $result = mysqli_query($conn, $sql);
            }
    }

    ?>
    </div>
</body>

</html>
