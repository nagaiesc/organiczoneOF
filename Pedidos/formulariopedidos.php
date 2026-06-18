<?php 
    session_start();
    $nombrevendedor=$_SESSION['nombre'];
?>
<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Registro de Productos</title>

<style>
body {
  background-image: url(fondos);
  background-size: 100%;
  background-position: center;
  background-repeat: no-repeat;
  margin: 0;
  font-family: 'Inter', Arial, Helvetica, sans-serif;
  color: #111;
  min-height: 100vh;
}

.cajp {
  background: #fff;
  margin: 60px auto;
  max-width: 700px;
  border-radius: 60px;
  box-shadow: 0 2px 32px rgba(139, 66, 66, 0.53);
  padding: 40px 60px;
  box-sizing: border-box;
}

.nav {
  display: flex;
  justify-content: center;
  margin-bottom: 20px;
  font-weight: 700;
  letter-spacing: 2px;
}

.titu {
  font-size: 48px;
  font-weight: 900;
  text-align: center;
  margin-bottom: 30px;
}

.forma label {
  font-size: 15px;
  font-weight: 500;
}

.forma input {
  border: none;
  border-bottom: 1px solid #ccc;
  font-size: 17px;
  margin-bottom: 20px;
  width: 100%;
  background: none;
  outline: none;
  padding: 10px 2px;
  transition: border-color 0.2s;
}

.forma input:focus {
  border-bottom: 1.5px solid #111;
}

.forma .fil {
  display: flex;
  gap: 20px;
}

.forma .fil input {
  width: 100%;
}

.forma button {
  width: 100%;
  background: #111;
  color: #fff;
  border: none;
  border-radius: 12px;
  font-size: 16px;
  font-weight: 600;
  padding: 10px;
  cursor: pointer;
  transition: 0.2s;
}

.forma button:hover {
  background: #136901ff;
}

.pie {
  text-align: center;
  margin-top: 30px;
  font-size: 14px;
  opacity: 0.8;
}

@media (max-width: 600px) {
  .cajp {
    padding: 25px;
  }

  .titu {
    font-size: 32px;
  }

  .forma .fil {
    flex-direction: column;
  }
}
</style>
</head>

<body>

<div class="cajp">

  <div class="nav">ORGANIC ZONE</div>

  <div class="titu">Registro de Pedido</div>

  <form class="forma" action="pedidos.php" method="POST">
    <label>Nombre Cliente </label>
    <input type="text" name="nombre" >

    <div class="fil">
      <div>
        <label>Fecha</label>
        <input type="date" name="fecha" value="<?php echo date('Y-m.d'); ?>">
      </div>
      <div>
        <input type="hidden" name="estado" value="En Proceso">
      </div>
      <div>
        <label>Nombre del vendedor </label>
        <input type="text" name="nombrevendedor" value="<?php echo $nombrevendedor?>" >
      </div>    
      
    <button type="submit">Nuevo Pedido</button>

  </form>

  <div class="pie">
    Organic Zone - Cochabamba, Bolivia 2026
  </div>

</div>


</body>
</html>