<?php require_once('../Connections/conexion.php'); ?>
<?php
if (!function_exists("GetSQLValueString")) {
function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
{
  if (PHP_VERSION < 6) {
    $theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue;
  }

  $theValue = function_exists("mysql_real_escape_string") ? mysql_real_escape_string($theValue) : mysql_escape_string($theValue);

  switch ($theType) {
    case "text":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;    
    case "long":
    case "int":
      $theValue = ($theValue != "") ? intval($theValue) : "NULL";
      break;
    case "double":
      $theValue = ($theValue != "") ? doubleval($theValue) : "NULL";
      break;
    case "date":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;
    case "defined":
      $theValue = ($theValue != "") ? $theDefinedValue : $theNotDefinedValue;
      break;
  }
  return $theValue;
}
}

mysql_select_db($database_conexion, $conexion);
$query_Partidos = "SELECT * FROM equipos";
$Partidos = mysql_query($query_Partidos, $conexion) or die(mysql_error());
$row_Partidos = mysql_fetch_assoc($Partidos);
$totalRows_Partidos = mysql_num_rows($Partidos);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Partidos</title>
    <link rel="stylesheet" href="./partidos.css">
</head>
<body>
    <header><h1>Partidos</h1></header>
    <table class="Tabla">
       
        <thead> <tr>
            
         <th>id_equpio</th>
         <th>Nombre</th>
         <th>Lugar</th>

         
       </tr>
      
       </thead>
        <tbody> 
        <?php do{?>
        <tr>
         <td><?php echo $row_Partidos['id_equipo'] ?></td>
         <td><?php echo $row_Partidos['nombre'] ?></td>
         <td><?php echo $row_Partidos['lugar'] ?></td>
       </tr>
  <?php } while ($row_Partidos = mysql_fetch_assoc($Partidos));?>
    
    </tbody>
        
      </table>

      <button class="btnEnviar"> <a href="./index.html">Regresar</a> </button>
</body>
</html>
<?php
mysql_free_result($Partidos);
?>
