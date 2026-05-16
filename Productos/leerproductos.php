<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Lista de Productos</title>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<style>
/* === MISMOS ESTILOS BASE === */
html, body {
    height: 100%;
    margin: 0;
    padding: 0;
    background: #969696;
    font-family: 'Inter', Arial, sans-serif;
}

body {
    display: flex;
    justify-content: center;
    align-items: center;
}

.principal-grid {
    display: grid;
    grid-template-columns: 440px 1fr;
    width: 96vw;
    max-width: 1600px;
    min-height: 820px;
    box-shadow: 0px 6px 40px rgba(88, 88, 88, 0.16);
    border-radius: 10px;
    overflow: hidden;
}

/* PANEL NEGRO */
.section-negro {
    background: #000;
    color: #fff;
    padding: 40px;
}

.nav-inner a {
    color: #e0e0e0;
    text-decoration: none;
    font-weight: 600;
}

.contrato-titulo {
    font-size: 2.6em;
    font-weight: 900;
    margin-top: 40px;
}

.desc {
    color: #bababa;
    margin-top: 20px;
}

/* PANEL BLANCO */
.section-blanco {
    background: #fff;
    padding: 40px;
}

.section-clientes {
    border-bottom: 1px solid #eee;
    margin-bottom: 20px;
}

/* TABLA */
table {
    width: 100%;
    border-collapse: collapse;
}

thead th {
    border-bottom: 3px solid #000;
    padding: 12px;
    text-align: left;
    font-weight: 900;
}

tbody td {
    border-bottom: 1px solid #ddd;
    padding: 12px;
}

/* BOTONES */
.acciones button {
    background: #000;
    color: #fff;
    border: none;
    padding: 6px 12px;
    margin-right: 5px;
    cursor: pointer;
    font-weight: 600;
}

.acciones button:hover {
    background: #222;
}

.acciones a {
    text-decoration: none;
}
#boton{
    display: flex;
    align-items: center;
    position: relative;
    gap: 8px;
    background-color: rgb(255, 255, 255);
    color: black;
    padding: 10px 20px;
    border-radius: 50px;
    font-size: 18px;
    font-weight: bold; 
}
</style>
</head>

<body>

<section class="principal-grid">

    <!-- PANEL IZQUIERDO -->
    <section class="section-negro">
        <nav class="nav-inner">
            <a href="../maquetados/maquetadoAdmin.php">INICIO</a>
        </nav>

        <h1 class="contrato-titulo">LISTA DE PRODUCTOS</h1>
        <a href="http://localhost/organiczoneOF/Productos/formularioproductos.php" id="boton">Registrar Producto</a>

        <p class="desc">
            Visualiza los productos registrados en el sistema.<br>
            Administra precios, stock y costos de forma rápida.
        </p>
    </section>

    <!-- PANEL DERECHO -->
    <section class="section-blanco">

        <section class="section-clientes">
            <h2>Productos Registrados</h2>

            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Descripcion</th>
                        <th>Precio</th>
                        <th>Costo</th>
                        <th>Stock</th>
                        
                    </tr>
                </thead>

                <tbody>
                <?php
                $conexion = new mysqli("localhost", "root", "", "organiczoneBD");

                if ($conexion->connect_error) {
                    echo "<tr><td colspan='6'>Error en la conexión</td></tr>";
                }

                $sql = "SELECT * FROM productos";
                $resultado = $conexion->query($sql);

                if ($resultado->num_rows > 0) {
                    while($fila = $resultado->fetch_assoc()){
                        $id = $fila['id'];

                        echo "<tr>";
                        echo "<td>{$fila['id']}</td>";
                        echo "<td>{$fila['nombre']}</td>";
                        echo "<td>{$fila['descripcion']}</td>";
                        echo "<td>{$fila['precio']}</td>";                        
                        echo "<td>{$fila['costo']}</td>";
                        echo "<td>{$fila['stock']}</td>";

                        echo "<td class='acciones'>
                                <a href='editarproducto.php?id=$id'><button>Editar</button></a>
                                <a href='#' onclick='confirmarEliminacion($id)'><button>Eliminar</button></a>
                                <a href='leerproducto.php?id=$id'><button>Mostrar</button></a>
                              </td>";

                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='6'>No hay productos registrados</td></tr>";
                }
                ?>
                </tbody>
            </table>

        </section>

    </section>

</section>
<script>

function confirmarEliminacion(id){

    Swal.fire({
        title: "¿Estás seguro?",
        text: "No podrás revertir esta acción",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Sí, eliminar",
        cancelButtonText: "Cancelar"
    }).then((result) => {

        if (result.isConfirmed) {
            /*Redirecciona de navegador a la página verdadera y agrega el id*/
            window.location = "eliminarproducto.php?id=" + id;

        }

    });
}
</script>
</body>
</html>