<?php

$servidor = "localhost";
$usuario = "root";
$contrasena = "";
$bd = "organiczoneBD";

$conn = new mysqli($servidor, $usuario, $contrasena, $bd);

if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}
$idPedido = isset($_GET['pedidos_id']) ? $_GET['pedidos_id'] : 0;

?>

<style>

body {
  background-image: url(fondos);
  background-size: cover;
  background-position: center;
  background-repeat: no-repeat;
  margin:0;
  font-family:'Inter', Arial, Helvetica, sans-serif;
  min-height:100vh;
}


.caja {

  background:white;
  max-width:1000px;
  margin:60px auto;
  padding:40px 50px;
  border-radius:60px;
  box-shadow:0 2px 32px rgba(139,66,66,.53);

}


.marca {

 text-align:center;
 font-weight:700;
 letter-spacing:2px;
 margin-bottom:15px;

}


.titulo {

 text-align:center;
 font-size:45px;
 font-weight:900;
 margin-bottom:30px;

}


table {

 width:100%;
 border-collapse:collapse;

}


th {

 background:#111;
 color:white;
 padding:15px;

}


td {

 padding:15px;
 text-align:center;
 border-bottom:1px solid #ddd;

}


input[type="number"] {

 width:70px;
 border:none;
 border-bottom:1px solid #ccc;
 outline:none;
 text-align:center;
 font-size:16px;

}



input[type="submit"] {

 background:#111;
 color:white;
 border:none;
 border-radius:12px;
 padding:10px 20px;
 cursor:pointer;
 font-weight:600;

}


input[type="submit"]:hover {

 background:#136901;

}


.total {

 text-align:right;
 font-size:25px;
 font-weight:800;
 margin-top:25px;

}


</style>


<?php

$sql = "SELECT * FROM productos";

$resultado = $conn->query($sql);

$sqlTotal = "SELECT SUM(costototal) FROM carrito
WHERE pedidos_id='$idPedido' ";

$resultadoTotal=$conn->query($sqlTotal);

$res=$resultadoTotal ->fetch_assoc();
$total = $res['SUM(costototal)'];

if($total == NULL){
    $total = 0;
}

echo "<div class='caja'>";


echo "<div class='marca'>
ORGANIC ZONE
</div>";


echo "<div class='titulo'>
Carrito de Pedido
</div>";


echo "<table>";

echo "<tr>

    <th>ID</th>
    <th>Nombre</th>
    <th>Precio</th>
    <th>Descripcion</th>
    <th>Cantidad</th>
    <th>Agregar</th>

    </tr>";

while($fila = $resultado->fetch_assoc()){

    echo "<tr>";

    echo "<form action='crearcarrito.php' method='POST'>";

    echo "<td>".$fila['id']."</td>";
    echo "<td>".$fila['nombre']."</td>";
    echo "<td>".$fila['precio']."</td>";
    echo "<td>".$fila['descripcion']."</td>";

    
echo "<input type='hidden'
    name='productos_id'
    value='".$fila['id']."'>";

echo "<input type='hidden'
        name='pedidos_id'
        value='".$idPedido."'>";

echo "<input type='hidden'
        name='precio'
        value='".$fila['precio']."'>";

echo "<td>
            <input
                type='number'
                name='cantidad'
                value='1'
                min='1'>
          </td>";

echo "<td>
            <input
                type='submit'
                value='Agregar'>
          </td>";

echo "</tr>";
echo "</form>";
}

echo "</table>";

echo "<br>";
echo "<a href='mostrarcarrito.php?pedidos_id=".$idPedido."'> Ver carrito </a>";
echo "<a href='../Usuarios/cerrarse.php'>Cerrar Sesion</a>";

echo "

<div class='total'>

Total: Bs. $total

</div>
";

echo "</div>";
?>
