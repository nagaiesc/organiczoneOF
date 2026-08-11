<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Registro de Productos</title>
<script src="https://code.jquery.com/jquery-3.6.3.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.5/jquery.validate.min.js"></script>

<style>
body {
  background-image: url("../Fondo1.png");
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
.fil {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 25px;
    width: 100%;
    margin-bottom: 25px;
}

.fil > div {
    display: flex;
    flex-direction: column;
    gap: 8px;
}

.fil label {
    font-family: 'Inter', Arial, sans-serif;
    font-size: 15px;
    font-weight: 600;
    color: #333;
}

.fil input {
    width: 100%;
    padding: 13px 15px;
    border: 2px solid #dce8d8;
    border-radius: 12px;
    background-color: #fff;
    font-family: 'Inter', Arial, sans-serif;
    font-size: 15px;
    box-sizing: border-box;
    outline: none;
    transition: 0.3s;
}

.fil input:focus {
    border-color: #0ba84a;
    box-shadow: 0 0 0 3px rgba(11, 168, 74, 0.12);
}

/* Campo de archivo */
.fil input[type="file"] {
    padding: 10px;
    cursor: pointer;
    background-color: #f8fcf6;
}

/* Botón */
button[type="submit"] {
    display: block;
    width: 100%;
    padding: 15px;
    border: none;
    border-radius: 14px;
    background-color: #000000;
    color: white;
    font-family: 'Inter', Arial, sans-serif;
    font-size: 16px;
    font-weight: 700;
    cursor: pointer;
    transition: 0.3s;
}

button[type="submit"]:hover {
    background-color: #000000;
    transform: translateY(-2px);
}
</style>
</head>

<body>

<div class="cajp">

  <div class="nav">ORGANIC ZONE</div>

  <div class="titu">Registro de Producto</div>

<form action="productos.php" method="post" enctype="multipart/form-data">
    <div class="fil">
        <div>
            <label>Nombre</label>
            <input type="text" name="nombre">
        </div>

        <div>
            <label>Descripción</label>
            <input type="text" name="descripcion">
        </div>

        <div>
            <label>Precio</label>
            <input type="number" name="precio" step="0.01">
        </div>

        <div>
            <label>Costo</label>
            <input type="number" name="costo" step="0.01">
        </div>

        <div>
            <label>Stock</label>
            <input type="number" name="stock">
        </div>

        <div>
            <label>Imagen del producto</label>
            <input 
                type="file" 
                name="imagen" 
                accept="image/jpeg,image/png,image/gif,image/webp"
            >
        </div>

    </div>

    <button type="submit">Guardar Producto</button>

</form>

  <div class="pie">
    Organic Zone - Cochabamba, Bolivia 2026
  </div>

</div>
<script>
  $("form").validate({
    rules:{
      nombre:{
            required:true
            },
      descripcion:{
           required:true
      },
      precio:{
           required:true
      },
      costo:{
          required:true
      },
      stock:{
          required:true
      },
    },
    messages:{
      nombre:{
           required:"Este campo no puede ir vacio"
      },
      descripcion:{
           required:"Este campo debe llenarse"
      },
      precio:{
           required:"Este campo no puede ir vacío"
      },
      costo:{
          required:"Este campo no puede ir vacío"
      },
      stock:{
          required:"Este campo no puede ir vacío"
      }
    }
  });
</script>

</body>
</html>