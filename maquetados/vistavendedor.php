<?php
session_start();
?>

<?php
// suma stock 
$conexion = new mysqli("localhost", "root", "", "organiczoneBD");
$total_stock = 0;



if (!$conexion->connect_error) {
    $sql_stock = "SELECT SUM(stock) as total FROM productos";
    $res_stock = $conexion->query($sql_stock);
    if ($res_stock && $fila = $res_stock->fetch_assoc()) {
        $total_stock = $fila['total'] ?? 0;
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Panel de Control - Vendedor</title>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Fredoka:wght@400;500;600;700&display=swap" rel="stylesheet">
<style>

body {
    background:#EAF7EC;
    margin:0;
    padding-top:100px;
    font-family: 'Fredoka', sans-serif;
    color: #111;
    min-height: 100vh;
    display: flex;
    justify-content: center;
    align-items: center;
    padding: 20px;
    box-sizing: border-box;
}

/* caja padre */
.caja-principal {
    background: #EAF7EC;
    width: 100%;
    max-width: 1150px;
    margin-top:80px;  
    display: grid;
    grid-template-columns: 340px 1fr;
    gap:45px;
    align-items:center;

}

/*section izquierda*/
.caja-imagen {
    width: 100%;
    aspect-ratio: 941 / 1672;
    max-height: 580px;
    border-radius: 24px;
    overflow: hidden;
    box-shadow: 0 10px 25px rgba(0,0,0,0.15);
}

.caja-imagen img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    display: block;
}

/*section derecha*/
.caja-derecha {
    display: flex;
    flex-direction: column;
}

.caja-titulos {
    margin-bottom: 25px;
}

.texto-saludo {
    font-size: 46px;
    color: #12A33C;
    margin: 0;
    font-weight: 700;
}

.texto-rol {
    font-size: 72px;
    color: #2B140D;
    margin: -10px 0 0 0;
    font-weight: 700;
}

/* paneles*/
.caja-fondo-verde {
    background: #12A33C;
    border-radius: 45px;
    padding: 45px;
    display: grid;
    grid-template-columns: 180px 1fr;
    gap: 25px;
    box-sizing: border-box;
}

/* contendeores generales */
.enlace-tarjeta {
    text-decoration: none;
    color: inherit;
    display: block;
    transition: transform 0.2s ease, box-shadow 0.2s ease;
}

.enlace-tarjeta:hover {
    transform: translateY(-4px);
}

/* caja stock*/
.caja-stock {
    background: #2B140D;
    color: #FCD09F;
    border-radius: 30px;
    padding: 25px 20px;
    text-align: center;
    box-sizing: border-box;
}

.titulo-stock {
    font-size: 28px;
    font-weight: 700;
    margin: 0;
    display: block;
    line-height: 1;
}

.numero-stock {
    font-size: 64px;
    font-weight: 700;
    display: block;
    line-height: 1.1;
    margin: 5px 0;
}

.sub-stock {
    font-size: 14px;
    font-weight: 500;
    color: #fff;
    opacity: 0.9;
}

/* pedidos contenedor  */
.caja-pedidos {
    background: #0A4A1B;
    color: #fff;
    border-radius: 35px;
    padding: 30px;
    position: relative;
    box-sizing: border-box;
    display: flex;
    flex-direction: column;
    justify-content: space-between;
}

.sub-pedidos {
    font-size: 20px;
    font-weight: 500;
    color: #EAF7EC;
    opacity: 0.95;
    margin: 0;
}

.titulo-pedidos {
    font-size: 42px;
    font-weight: 700;
    margin: 0 0 20px 0;
    line-height: 1;
}

/* boton producros */
.boton1 {
    background: #12A33C;
    color: #fff;
    font-size: 16px;
    font-weight: 600;
    padding: 10px 25px;
    border-radius: 25px;
    border: none;
    align-self: flex-end;
    cursor: pointer;
}

/* productos */
.caja-productos {
    grid-column: 1 / -1;
    background: #FCD09F;
    color: #2B140D;
    border-radius: 35px;
    padding: 30px 40px;
    display: flex;
    justify-content: space-between;
    align-items: center;
    box-sizing: border-box;
}

.grupo-texto-productos {
    display: flex;
    flex-direction: column;
}

.sub-productos {
    font-size: 22px;
    font-weight: 500;
    margin: 0;
}

.titulo-productos {
    font-size: 46px;
    font-weight: 700;
    margin: -5px 0 0 0;
    line-height: 1;
}

/* boton cafe*/
.boton2 {
    background: #2B140D;
    color: #fff;
    font-size: 18px;
    font-weight: 600;
    padding: 12px 35px;
    border-radius: 25px;
    border: none;
    cursor: pointer;
}


@media (max-width: 900px) {
    .caja-principal {
        grid-template-columns: 1fr;
        gap: 20px;
    }
    .caja-imagen {
        max-height: 340px;
    }
    .caja-fondo-verde {
        grid-template-columns: 1fr;
        padding: 25px;
    }
    .caja-productos {
        flex-direction: column;
        align-items: flex-start;
        gap: 20px;
    }
    .boton2 {
        width: 100%;
    }
}


</style>
</head>
<body>
        <?php include("../nav.php"); ?>


<article class="caja-principal">

    <section class="caja-imagen">
        <img src="/organiczoneOF/beyondft.png" alt="Beyond Burger - Organic Zone">
    </section>

    <section class="caja-derecha">
        
        <header class="caja-titulos">
            <h2 class="texto-saludo">Hola!</h2>
            <h1 class="texto-rol"><?php echo $_SESSION['nombre']; ?></h1>
        </header>

        <section class="caja-fondo-verde">

            <section class="caja-stock">
                <span class="titulo-stock">Stock</span>
                <span class="numero-stock"><?php echo $total_stock; ?></span>
                <span class="sub-stock">Productos</span>
            </section>

            <a href="../Pedidos/formulariopedidos.php" class="enlace-tarjeta caja-pedidos">
                <header>
                    <h3 class="sub-pedidos">Registra tus</h3>
                    <h2 class="titulo-pedidos">Pedidos!</h2>
                </header>
                <button type="button" class="boton1">
                    Registrar
                </button>
            </a>

            <a href="http://localhost/organiczoneOF/Productos/formularioproductos.php" class="enlace-tarjeta caja-productos">
                <section class="grupo-texto-productos">
                    <h3 class="sub-productos">Registra tus</h3>
                    <h2 class="titulo-productos">Productos</h2>
                </section>
                <button type="button" class="boton2">Registrar</button>
            </a>

        </section>

    </section>

</article>

</body>
</html>