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

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}



if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {
  $insertSQL = sprintf("INSERT INTO jugadores (id_jugador, numero_dorsal, nombre, posicion, equipo) VALUES (%s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['id_jugador'], "int"),
                       GetSQLValueString($_POST['numero_dorsal'], "int"),
                       GetSQLValueString($_POST['nombre'], "text"),
                       GetSQLValueString($_POST['posicion'], "text"),
                       GetSQLValueString($_POST['equipo'], "text"));

  mysql_select_db($database_conexion, $conexion);
  $Result1 = mysql_query($insertSQL, $conexion) or die(mysql_error());

  $insertGoTo = "Jugadores.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $insertGoTo));
}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {
  $insertSQL = sprintf("INSERT INTO jugadores (id_jugador, numero_dorsal, nombre, posicion, equipo) VALUES (%s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['id_jugador'], "int"),
                       GetSQLValueString($_POST['numero_dorsal'], "int"),
                       GetSQLValueString($_POST['nombre'], "text"),
                       GetSQLValueString($_POST['posicion'], "text"),
                       GetSQLValueString($_POST['equipo'], "text"));

  mysql_select_db($database_conexion, $conexion);
  $Result1 = mysql_query($insertSQL, $conexion) or die(mysql_error());

  $insertGoTo = "Jugadores.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $insertGoTo));
}

$maxRows_jugador = 3;
$pageNum_jugador = 0;
if (isset($_GET['pageNum_jugador'])) {
  $pageNum_jugador = $_GET['pageNum_jugador'];
}
$startRow_jugador = $pageNum_jugador * $maxRows_jugador;

mysql_select_db($database_conexion, $conexion);
$query_jugador = "SELECT * FROM jugadores";
$query_limit_jugador = sprintf("%s LIMIT %d, %d", $query_jugador, $startRow_jugador, $maxRows_jugador);
$jugador = mysql_query($query_limit_jugador, $conexion) or die(mysql_error());
$row_jugador = mysql_fetch_assoc($jugador);

if (isset($_GET['totalRows_jugador'])) {
  $totalRows_jugador = $_GET['totalRows_jugador'];
} else {
  $all_jugador = mysql_query($query_jugador);
  $totalRows_jugador = mysql_num_rows($all_jugador);
}
$totalPages_jugador = ceil($totalRows_jugador/$maxRows_jugador)-1;

mysql_select_db($database_conexion, $conexion);
$query_jugador2 = "SELECT * FROM jugadores ORDER BY id_jugador ASC";
$jugador2 = mysql_query($query_jugador2, $conexion) or die(mysql_error());
$row_jugador2 = mysql_fetch_assoc($jugador2);
$totalRows_jugador2 = mysql_num_rows($jugador2);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Jugadores</title>
    <link rel="stylesheet" href="./partidos.css">

</head>
<body>
    <header><h1>Jugadores</h1></header>


    <table class="Tabla">
       
        <thead> <tr>
            
         <th>id_jugador</th>
         <th>Nombre</th>
         <th>Numero_dorsal</th>
         <th>Posicion</th>
         <th>Equipo</th>
        
         
       </tr>
      
       </thead>
        <tbody> 
        <?php do{?>
        <tr>
         <td><?php echo $row_jugador2['id_jugador'] ?></td>
         <td><?php echo $row_jugador2['nombre'] ?></td>
         <td><?php echo $row_jugador2['numero_dorsal'] ?></td>
         <td><?php echo $row_jugador2['posicion'] ?></td>
         <td><?php echo $row_jugador2['equipo'] ?></td>         
       </tr>
       
       <?php } while ($row_jugador2 = mysql_fetch_assoc($jugador2));?>
       
      
      
    
    </tbody>
        
      </table>
    <form method="post" name="form1" action="<?php echo $editFormAction; ?>">
      <table align="center">
        <tr valign="baseline">
          <td nowrap align="right">Id_jugador:</td>
          <td><input type="text" name="id_jugador" value="" size="32"></td>
        </tr>
        <tr valign="baseline">
          <td nowrap align="right">Numero_dorsal:</td>
          <td><input type="text" name="numero_dorsal" value="" size="32"></td>
        </tr>
        <tr valign="baseline">
          <td nowrap align="right">Nombre:</td>
          <td><input type="text" name="nombre" value="" size="32"></td>
        </tr>
        <tr valign="baseline">
          <td nowrap align="right">Posicion:</td>
          <td><input type="text" name="posicion" value="" size="32"></td>
        </tr>
        <tr valign="baseline">
          <td nowrap align="right">Equipo:</td>
          <td><input type="text" name="equipo" value="" size="32"></td>
        </tr>
        <tr valign="baseline">
          <td nowrap align="right">&nbsp;</td>
          <td><input type="submit" value="Insertar registro"></td>
        </tr>
      </table>
      <input type="hidden" name="MM_insert" value="form1">
    </form>
    <p>&nbsp;</p>
<p>&nbsp;</p>
<button class="btnEnviar"> <a href="./index.html">Regresar</a> </button>
</body>
</html>
<?php
mysql_free_result($jugador);

mysql_free_result($jugador2);
?>
