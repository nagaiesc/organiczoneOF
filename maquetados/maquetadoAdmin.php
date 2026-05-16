<!DOCTYPE html>
<html lang=es>
<head>
<meta charset=UTF-8>
<meta name=viewport content="width=device-width, initial-scale=1.0">
<title>Admin</title>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<style>
*{
  margin:0;
  padding:0;
  box-sizing:border-box;
  font-family:Arial;
}

body{
  background:#e8ecdf;
  padding:20px;
}

main{
  display:grid;
  grid-template-columns:2fr 1fr;
  gap:20px;
}

header{
  grid-column:1/3;
  display:flex;
  justify-content:space-between;
  align-items:center;
}

section{
  display:grid;
  gap:20px;
}

article{
  border-radius:25px;
  padding:20px;
}

nav{
  display:grid;
  grid-template-columns:repeat(3,1fr);
  gap:20px;
}

aside{
  background:#003d12;
  color:white;
  border-radius:25px;
  padding:20px;
}

button{
  border:none;
  border-radius:20px;
  padding:8px 18px;
  font-weight:bold;
}

table{
  width:100%;
}
.botonrN{
    display: inline-block;
    background-color: #f2b35d;
    color: black;
    text-decoration: none;
    padding: 6px 20px;
    border-radius: 25px;
    text-align: center;
    font-size: 15px;
}
.botonVC{
  display: inline-block;
  background-color: #d8e8b1;
  color: black;
  text-decoration: none;
  padding: 6px 20px;
  border-radius: 25px;
  text-align: center;
  font-size: 15px;
}
.botonVO{
  display: inline-block;
    background-color: #003d12;
    color: white;
    text-decoration: none;
    padding: 6px 20px;
    border-radius: 25px; 
    text-align: center;
    font-size: 15px;
}


@media(max-width:900px){

  main{
    grid-template-columns:1fr;
  }
  header{
    flex-direction:column;
    gap:20px;
  }
  nav{
    grid-template-columns:1fr;
  }
}
</style>
</head>

<body>
<main>
<header>
<article style=color:#118c2f;background:none;padding:0>
<h1 style=font-size:60px>
Hola!
</h1>
<h1 style=color:#2b120b;font-size:90px>
Admin
</h1>
</article>
<article style="display:flex;gap:15px;background:none">
<button style=background:#10b046;color:white>
Inicio
</button>
<button style=background:#003d12;color:white>
User
</button>
</article>
</header>
<section>
<nav>

<?php

$conexion = new mysqli(
    "localhost",
    "root",
    "",
    "organiczoneBD"
);

if($conexion->connect_error){
    die("Error de conexión");
}

$sql = "SELECT * FROM productos";

$resultado = $conexion->query($sql);

$i = 0;

if($resultado->num_rows > 0){

    while($fila = $resultado->fetch_assoc()){

        $i++;

        $color = "#10b046";

        if($i == 2){
            $color = "#003d12";
        }

        echo "

        <article style='
        background:$color;
        min-height:320px;
        
        color:white;
        text-align:center;
        border-radius:35px;
        padding:20px;
        '>

        <h2 style='margin-top:40px;font-size:35px'>
        ".$fila['nombre']."
        </h2>

        <br>

        <p>
        ".$fila['descripcion']."
        </p>

        <br>

        <h3>
        ".$fila['precio']." Bs
        </h3>
        <br>

        <h2>
        Stock: ".$fila['stock']."
        </h2>

        <br>";
         echo "<a href='../Productos/editarproducto.php?CI=".$fila['id']."' class='botonN' style=
          'display: inline-block;
          background-color: #f2b35d;
          color: black;
          text-decoration: none;
          margin-top:3px;
          padding: 6px 20px;
          border-radius: 25px;
          text-align: center;
          font-size: 15px;'> 
          <strong><p>Editar</p></strong></a> <br>";
        echo "<a href='../Productos/eliminarproducto.php?CI=".$fila['id']."' class='botonVC' style=
          'display: inline-block;
          background-color: #d8e8b1;
          margin-top:3px;
          color: black;
          text-decoration: none;
          padding: 6px 20px;
          border-radius: 25px;
          text-align: center;
          font-size: 15px;'> 
          <strong><p>Eliminar</p></strong></a> <br>";
        echo "<a href='../Productos/leerproductos.php?CI=".$fila['id']."' class='botonVC' style=
          'display: inline-block;
          background-color: #b6e75b;
          margin-top:3px;
          color: black;
          text-decoration: none;
          padding: 6px 20px;
          border-radius: 25px;
          text-align: center;
          font-size: 15px;'> 
          <strong><p>Mostrar</p></strong></a> <br>";
          echo "</article>";

    }

}else{

    echo "
    <h1 style='color:black'>
    No hay productos registrados
    </h1>
    ";

}

?>

</nav>
<h1 style=font-size:70px>



Usuarios
</h1>
</article>
<nav style="grid-template-columns:repeat(4,1fr)">
  <?php
    $nombreServidor = "localhost";
    $nombreUsuario = "root";
    $contraseñaBaseDeDatos = "";
    $nombreBaseDeDatos = "organiczoneBD";

    $conexion = new mysqli($nombreServidor, $nombreUsuario, $contraseñaBaseDeDatos, $nombreBaseDeDatos);

    if ($conexion->connect_error) {
        echo "<tr><td colspan='7'>Hubo un error en la conexión</td></tr>";
    }
    $i=0;
    $color="#54260d";
    $sql = "SELECT * FROM usuarios";
    $resultado = $conexion->query($sql);
    if ($resultado->num_rows > 0) {
      while($fila = $resultado->fetch_assoc()){
        $i=$i+1;
        if ($i==1){
            $color="#54260d";
        }
        if ($i==2){
            $color="#169f3d";
        }
        if ($i==3){
            $color="#003d12";
            $i=0;
        }
        echo "<article style='background:$color;color:white'>";
        echo "<h2>".$fila['nombre']."</h2>";
        echo "<h2>".$fila['direccion']."</h2>";
        echo "<h2>".$fila['celular']."</h2>";
        echo "<a href='../Usuarios/editarusuario.php?CI=".$fila['CI']."' class='botonN' style=
          'display: inline-block;
          background-color: #f2b35d;
          color: black;
          text-decoration: none;
          margin-top:3px;
          padding: 6px 20px;
          border-radius: 25px;
          text-align: center;
          font-size: 15px;'> 
          <strong><p>Editar</p></strong></a> <br>";
        echo "<a href='#' onclick='confirmarEliminacion(".$fila['CI'].")' class='botonVC' style=
          'display: inline-block;
          background-color: #d8e8b1;
          margin-top:3px;
          color: black;
          text-decoration: none;
          padding: 6px 20px;
          border-radius: 25px;
          text-align: center;
          font-size: 15px;'> 
          <strong><p>Eliminar</p></strong></a> <br>";
        echo "<a href='../Usuarios/leerusuarios.php?CI=".$fila['CI']."' class='botonVC' style=
          'display: inline-block;
          background-color: #b6e75b;
          margin-top:3px;
          color: black;
          text-decoration: none;
          padding: 6px 20px;
          border-radius: 25px;
          text-align: center;
          font-size: 15px;'> 
          <strong><p>Mostrar</p></strong></a> <br>";
          echo "</article>";

      }


    }

?>



</nav>
</section>
</section>
<aside>
<h1 style=font-size:60px>
Roles
</h1>
<br>
<?php
    $nombreServidor = "localhost";
    $nombreUsuario = "root";
    $contraseñaBaseDeDatos = "";
    $nombreBaseDeDatos = "organiczoneBD";

    $conexion = new mysqli($nombreServidor, $nombreUsuario, $contraseñaBaseDeDatos, $nombreBaseDeDatos);

    if ($conexion->connect_error) {
        echo "<tr><td colspan='7'>Hubo un error en la conexión</td></tr>";
    }
    $i=0;
    $color="#54260d";
    $sql = "SELECT * FROM usuarios";
    $resultado = $conexion->query($sql);
    if ($resultado->num_rows > 0) {
      while($fila = $resultado->fetch_assoc())
        {
          echo "<article style='background:none;color:white;padding:0'>";
          echo "<h2>".$fila['nombre']."</h2>";
          echo "<p
          style=
          'display: inline-block;
          background-color: #10b046;
          margin-top:3px;
          margin-left:10px;
          color: white;
          text-decoration: none;
          padding: 6px 20px;
          border-radius: 25px;
          text-align: center;
          font-size: 15px;'
          >".$fila['rol']."</p>";

          echo "<p style=
          'display: inline-block;
          background-color: #10b046;
          margin-top:3px;
          margin-left: 30px;
          color: white;
          text-decoration: none;
          padding: 6px 20px;
          border-radius: 25px;
          text-align: center;
          font-size: 15px;'
          >".$fila['estado']."</p>";
          echo "</article>";
        }
    }
    
?>

<article style="background:none;color:white;padding:0">
</article>
</article>
</aside>
</main>
<script>

function confirmarEliminacion(CI){

Swal.fire({
  title: "¿Estás seguro?",
  text: "No podrás revertir esto",
  icon: "warning",
  showCancelButton: true,
  confirmButtonColor: "#3085d6",
  cancelButtonColor: "#d33",
  confirmButtonText: "Sí, eliminar"
}).then((result) => {

  if (result.isConfirmed) {

    Swal.fire({
      title: "Eliminado!",
      text: "El usuario fue eliminado.",
      icon: "success"
    }).then(() => {

      window.location = "../Usuarios/eliminarusuario.php?CI=" + CI;

    });

  }

});

}

</script>
</body>
</html>

