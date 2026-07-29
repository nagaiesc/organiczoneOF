<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
     <script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>

<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Chango&family=Climate+Crisis:YEAR@1979&family=Luckiest+Guy&family=Vina+Sans&display=swap" rel="stylesheet">
    <style>
         #barra{
            position: fixed;
            width: 1300px;
            height: 65px;
            margin-left: 280px;
            margin-right: 100px;
            margin-top: 20px;
            background:none;
            border-radius: 50px;
            display:flex;
            justify-content: space-between;
            flex-wrap: nowrap;
        }      
       
        #barra.desliza{
            background-color: black;
            transition: 1s;
        }

        #orga{
            position: relative;
            left: 15px;
            bottom: 8px;
        }
        a{
            display: flex;
            text-decoration: none;
            color: white;
        }


        #links{
            display: flex;
            flex-direction: row;
        }
       
        #link1{
            margin-right: 10px;
        }
        #link2{
            margin-right: 20px;
            margin-left: 20px;
        }
       
        #link3{
            margin-left: 10px;
        }
        
        #linkprodu{
            background-color: rgba(172, 255, 47, 0.705);
            padding: 13px;
            padding-left: 20px;
            border-radius: 50px;
            position: relative;
            top: 7px;
            right: 8px;
            font-size: 20px;
        }
       
        #descu{
            background-color: rgba(172, 255, 47, 0.705);
            padding: 13px;
            padding-left: 20px;
            border-radius: 50px;
        }
       
        #descu2{
            position: relative;
            bottom: 11px;
            right: 8px;
        }
        #fondo{
            padding: 500px;
            border-radius: 30px;
            grid-area: cabecera;
            background-size: 100%;
            background-position: center;
            background-image: url(fondo2.png);
            background-repeat: no-repeat;
            transition: background-size 1.5s ease;
        }
         .productos{
            width: 400px;
            height: 800px;
            border-radius: 50px;
            font-family: "Luckiest Guy", cursive;
            font-weight: 400;
  font-style: normal;
  letter-spacing: 2px;
        }
        .titulos{
            
            color: black;
            font-family: poppins, sans-serif;
           
        }
        .imagenes{
            border-radius: 50px;
            width: 400px;
        }
        #a{
            padding-top: 80px;
            padding-bottom: 80px;
            display: flex;
            gap: 30px;
            justify-content: center;
            flex-wrap: nowrap;
        }
        .boton{
            padding: 30px;
            border-radius: 30px;
            margin-top: 1px;
            font-size: 20px;
            padding-left: 40px;
            padding-right: 40px;
            padding-top: 20px;
            padding-bottom: 20px;
            background-color: rgb(4, 93, 22);
            color: rgb(255, 255, 255);
            border: 0px;
            font-family: "Chango", sans-serif;
            font-weight: 400;
            font-style: normal;
            
        }
        .precio{
            font-size: 20px;
            position: relative;
            bottom: 50px;
            left: 320px;
            color: rgb(19, 188, 25);
            font-family: "Chango", sans-serif;
            font-style: normal;
            font-size: 22px;
            
        }
        #direc{
            width: 450px;
            height: 200px;
        }
        #c{
            background-color: black;
            grid-area: piepag;
            padding-top: 80px;
            padding-bottom: 80px;
            font-family: poppins, sans-serif;
            color: white;
        }
        address{
            width: 100%;
            display: flex;
            gap: 60px;
            justify-content: center;
            flex-wrap: nowrap;
           
        }
        #cont{
            width: 450px;
            height: 200px;
        }
        #mail{
            width: 450px;
            height: 200px;
        }
        .imgfooter{
            border-radius: 50px;
            width: 40px;
        }
        productos {
    width: 400px;
    height: auto;
    border-radius: 50px;
    padding: 15px;
    display: flex;
    flex-direction: column;
    justify-content: space-between;
}

.contenido {
    display: flex;
    flex-direction: column;
    gap: 10px;
}

/* CONTADOR */
.contador {
    display: flex;
    justify-content: center;
    align-items: center;
    gap: 15px;
    margin-top: 10px;
    background: yellowgreen;
}

.contador button { /* estilo bolitas */
    background: black;
    color: white;
    border: none;
    width: 40px;
    height: 40px;
    border-radius: 50%;
    font-size: 20px;
    cursor: pointer;
}

.contador span {
    font-size: 22px;
    font-weight: bold;
}

/* BOTÓN GRANDE */
.boton {
    width: 100%;
    margin-top: 20px;
    padding: 25px;
    font-size: 22px;
    border-radius: 25px;
    background-color: rgb(4, 93, 22);
    transition: 0.2s;
}

.boton:hover {
    background-color: rgb(6, 120, 30);
}

/* PRECIO mejor posicionado */
.precio {
    position: static;
    text-align: right;
    margin-top: -10px;
}
#carritoIcono{
    display: flex;
    align-items: center;
    position: relative;
    right:20px;
    top: 10px;
    gap: 8px;
    background-color: rgba(172, 255, 47, 0.705);
    color: black;
    padding: 10px 18px;
    border-radius: 50px;
    font-size: 18px;
    font-weight: bold;  
}
    </style>
</head>
<body>
    <script>
        document.addEventListener('scroll', () => {
        const header = document.querySelector('header');
        const scrollY = window.scrollY;
        const newSize = Math.min(120, 100 + scrollY / 15);
        header.style.backgroundSize = `${newSize}%`;
        });
        window.addEventListener('scroll', () => {
        const barra = document.getElementById('barra');
        if (window.scrollY > 50) {
        barra.classList.add('desliza');  // Aplica clase que reduce el menú
        } else {
        barra.classList.remove('desliza'); // Quita clase cuando vuelve arriba
        }
        });
    </script>  
<script>
// cambiar cantidad visual
function cambiarCantidad(id, cambio) {
    let span = document.getElementById('cantidad-' + id);
    let valor = parseInt(span.innerText);

    valor += cambio;
    if (valor < 0) valor = 0;

    span.innerText = valor;
}

// obtener carrito
function obtenerCarrito() {
    return JSON.parse(localStorage.getItem('carrito')) || [];
}

// guardar carrito
function guardarCarrito(carrito) {
    localStorage.setItem('carrito', JSON.stringify(carrito));
}

// agregar producto
function agregarAlCarrito(id, nombre, precio) {
    let cantidad = parseInt(document.getElementById('cantidad-' + id).innerText);

    if (cantidad <= 0) {
        Swal.fire({
  title: "No añadiste ningun producto",
  text: "seleccione al menos 1 producto",
  icon: "error"
});
        return;
    }

    let carrito = obtenerCarrito();

    let productoExistente = carrito.find(p => p.id === id);

    if (productoExistente) {
        productoExistente.cantidad += cantidad;
    } else {
        carrito.push({
            id: id,
            nombre: nombre,
            precio: precio,
            cantidad: cantidad
        });
    }

    guardarCarrito(carrito);
    actualizarContador();

    // reset cantidad visual
    document.getElementById('cantidad-' + id).innerText = 0;

  

Swal.fire({
  title: "Producto añadido al carrito ",
  icon: "success",
  draggable: true
});
            

   

}

// contador global
function actualizarContador() {
    let carrito = obtenerCarrito();
    let total = carrito.reduce((sum, p) => sum + p.cantidad, 0);

    document.getElementById('totalCarrito').innerText = total;
}

// inicializar
actualizarContador();
</script>

     <center>
    <nav id="barra">
    <div><a href="maquetadoOZ.html" id="orga"><h1>OrganicZone</h1></a></div>
    <section id="links">
    <a href="contacto.html" id="link2"><h3>Contacto</h3></a>
    <a href="sobreNosotros.html" id="link3"><h3>Sobre Nosotros</h3></a>
    </section>
    <section> <strong><a href="pedidos.php" id="linkprodu">Pide aquí</a></section></strong>
    <section><a href="Clientes/login.php" id="descu2"><h3 id="descu">Iniciar Sesion</h3></a></section>
    <section><a href="#" id="carritoIcono">
        🛒 <span id="totalCarrito">0</span
        ></a>
    </section>
    </nav>
    </center>

    <header>
        <section id="fondo"></section>
    </header>
     <section id="a" class="titulos">

<?php
$conexion = new mysqli("localhost", "root", "", "productosOZ");

if ($conexion->connect_error) {
    echo "Error en la conexión";
}

$sql = "SELECT * FROM productos";
$resultado = $conexion->query($sql);
if ($resultado->num_rows > 0) {

    while($fila = $resultado->fetch_assoc()) {

        $nombre = $fila['nombreproducto'];
        $precio = $fila['precioventa'];
        //nombre del posible archivo
        $nombreArchivo="P-".$fila['id'];
        $directorio = "Imagenes/";
        //lista de todas las extenciones posibles
        $extensiones = ["pdf", "jpg", "jpeg", "png", "gif", "webp"];
        //bandera para verificar todo tipo de archivo
        $archivoEncontrado = null;
        //verificar si el archivo se creo en alguna extension conocida
        foreach ($extensiones as $ext) {
            //nombre del archivo con cada extension
            $ruta = $directorio . $nombreArchivo . "." . $ext;
            //verifica
            if (file_exists($ruta)) {
                $archivoEncontrado = $ruta;
                // detenemos la búsqueda en cuanto lo encuentra
                break;
            }
        }
        if ($archivoEncontrado) {
       echo "
            <div class='productos'>

                <div class='contenido'>
                    <img class='imagenes' src='$archivoEncontrado' alt='$nombre'>
                    
                    <h1>$nombre</h1>
                    <p class='precio'>{$precio}Bs</p>

                    <div class='contador'>
                        <button onclick='cambiarCantidad({$fila['id']}, -1)'>-</button>
                        <span id='cantidad-{$fila['id']}'>0</span>
                        <button onclick='cambiarCantidad({$fila['id']}, 1)'>+</button>
                    </div>
                </div>
            <button class='boton'
                onclick=\"agregarAlCarrito({$fila['id']}, '$nombre', {$precio})\">
                Agregar al carrito
            </button>

            </div>
            
            ";
        }else{
            echo"
            <div class='productos'>

                <div class='contenido'>
                    <img class='imagenes' src='beyond burguer.jpeg' alt='$nombre'>
                    
                    <h1>$nombre</h1>
                    <p class='precio'>{$precio}Bs</p>

                    <div class='contador'>
                        <button onclick='cambiarCantidad({$fila['id']}, -1)'>-</button>
                        <span id='cantidad-{$fila['id']}'>0</span>
                        <button onclick='cambiarCantidad({$fila['id']}, 1)'>+</button>
                    </div>
                </div>

                <button class='boton'
                onclick=\"agregarAlCarrito({$fila['id']}, '$nombre', {$precio})\">
                Agregar al carrito
            </button>

            </div>
            
            ";
        }
    }
} else {
    echo "<p>No hay productos disponibles</p>";
}
?>

</section>

    <footer id="c" >
        <center>
        <p> <strong>VISITANOS</strong></p>
        <strong><h1>Encuéntranos en el <br> Colegio Pedro Poveda </h1></strong>
        <p>Ven a visitarnos en Colegio Pedro Poveda Plazuela Tarija, Av. América, Cochabamba y disfruta de nuestras hamburguesas <br> gourmet orgánicas en un ambiente acogedor.</p>
        </center><br>




        <address>
           
            <div id="direc">
                <center><img class="imgfooter" src="ubicacion.png" alt=""></center>
                <center><h1><strong>DIRECCION</strong></h1></center>
                <center><p>Colegio Pedro Poveda Plazuela Tarija, Av. América, Cochabamba Bolivia</p></center>




            </div>
            <div id="cont">
                <center><img class="imgfooter"  src="llamenos.png" alt=""></center>
                 <center><h1><strong>CONTACTO</strong></h1></center>
                 <center><p>+591 70376053 <br>Llámanos para reservas o consultas.</p></center>
            </div>
            <div id="mail">
                <center><img class="imgfooter"  src="contacto.jpg" alt=""></center>
                 <center><h1><strong>CORREO ELECTRONICO</strong></h1></center>
                 <center><p style="color: greenyellow;"> organiczone@gmail.com</p>Esperamos tener noticias tuyas.</p></center>
            </div>
        </address>
    </footer>
</body>
</html>