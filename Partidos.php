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
  $insertSQL = sprintf("INSERT INTO equipos (id_equipo, nombre, lugar) VALUES (%s, %s, %s)",
                       GetSQLValueString($_POST['id_equipo'], "int"),
                       GetSQLValueString($_POST['nombre'], "text"),
                       GetSQLValueString($_POST['lugar'], "text"));

  mysql_select_db($database_conexion, $conexion);
  $Result1 = mysql_query($insertSQL, $conexion) or die(mysql_error());

  $insertGoTo = "Partidos.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $insertGoTo));
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
    <form method="post" name="form1" action="<?php echo $editFormAction; ?>">
      <table align="center">
        <tr valign="baseline">
          <td nowrap align="right">Id_equipo:</td>
          <td><input type="text" name="id_equipo" value="" size="32"></td>
        </tr>
        <tr valign="baseline">
          <td nowrap align="right">Nombre:</td>
          <td><input type="text" name="nombre" value="" size="32"></td>
        </tr>
        <tr valign="baseline">
          <td nowrap align="right">Lugar:</td>
          <td><input type="text" name="lugar" value="" size="32"></td>
        </tr>
        <tr valign="baseline">
          <td nowrap align="right">&nbsp;</td>
          <td><input type="submit" value="Insertar registro"></td>
        </tr>
      </table>
      <input type="hidden" name="MM_insert" value="form1">
    </form>
    <p>&nbsp;</p>
<button class="btnEnviar"> <a href="index.html">Regresar</a> </button>
</body>
</html>
<?php
mysql_free_result($Partidos);
?>
