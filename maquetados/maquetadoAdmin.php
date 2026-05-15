<!DOCTYPE html>
<html lang=es>
<head>
<meta charset=UTF-8>
<meta name=viewport content="width=device-width, initial-scale=1.0">


<title>Admin</title>


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
<article style="background:#10b046;height:280px;color:white;text-align:center">
<h2 style=margin-top:70px>
Hamburguesa
</h2>
<br><br><br>
<button style=background:#003d12;color:white>
Editar
</button>

<button style=background:#d8e8b1>
Eliminar
</button>
</article>
<article style="background:#003d12;height:280px;color:white;text-align:center">
<h2 style=margin-top:70px>
Papas
</h2>
<br><br><br>
<button style=background:#10b046;color:white>
Editar
</button>
<button style=background:#d8e8b1>
Eliminar
</button>
</article>
<article style="background:#2f0d06;height:280px;color:white;text-align:center">
<h2 style=margin-top:70px>
Combo
</h2>
<br><br><br>
<button style=background:#f2b35d>
Editar
</button>
<button style=background:#d8e8b1>
Eliminar
</button>
</article>
</nav>
<section style="background:#10b046;border-radius:25px;padding:20px">
<article style="background:none;color:white;padding:0">
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
        echo "<p>Criox00</p><br>";
        echo "<a href='../Usuarios/editarusuario.php?CI=".$fila['CI']."' class='botonN'> <strong><p>Editar</p></strong></a>";
        echo "<button style='background:#d8e8b1'>
                Eliminar
                </button>
                <button style='background:#003d12;color:white'>
                Mostrar
              </button>
              </article>";
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
<article style="background:none;color:white;padding:0">
<h2>Carlos Rivera</h2>
<p>Admin - Vendedor</p>
<br>
<button style=background:#10b046;color:white>
</button>
</article>
<br>
<article style="background:none;color:white;padding:0">
<h2>Laura Lopez</h2>
<p>Admin - Vendedor</p>
<br>
<button style=background:#10b046;color:white>
</button>
</article>
</aside>
</main>
</body>
</html>
