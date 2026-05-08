<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Login - Organic Zone</title>

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
  margin: 80px auto;
  max-width: 700px;
  border-radius: 60px;
  box-shadow: 0 2px 32px rgba(139, 66, 66, 0.53);
  padding: 40px 60px;
  box-sizing: border-box;
}

.nav {
  display: flex;
  justify-content: space-between;
  margin-bottom: 30px;
}

.nav .med {
  font-weight: 700;
  letter-spacing: 2px;
}

.titu {
  font-size: 64px;
  font-weight: 900;
  margin-bottom: 30px;
  text-align: center;
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
}

.forma input:focus {
  border-bottom: 1.5px solid #111;
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

.extra {
  text-align: center;
  margin-top: 15px;
  font-size: 14px;
}

.extra a {
  text-decoration: none;
  color: #136901ff;
  font-weight: 500;
}

.pie {
  text-align: center;
  margin-top: 40px;
  font-size: 14px;
  opacity: 0.8;
}

@media (max-width: 600px) {
  .cajp {
    padding: 25px;
  }

  .titu {
    font-size: 40px;
  }
}
</style>
</head>

<body>

<div class="cajp">

  <div class="nav">
    <div class="med">ORGANIC ZONE</div>
  </div>

  <div class="titu">Iniciar Sesión</div>

  <form class="forma" method="post" action="login2.php">

    <label>Nombre de usuario</label>
    <input type="text" name="usuario" placeholder="Ingresa tu usuario" required>

    <label>Contraseña</label>
    <input type="password" name="contrasena" placeholder="Ingresa tu contraseña" required>

    <button type="submit">Ingresar</button>

    <div class="extra">
      ¿No tienes cuenta? <a href="intento2.php">Regístrate</a>
    </div>

  </form>

  <div class="pie">
    Organic Zone - Cochabamba, Bolivia 2025
  </div>

</div>

</body>
</html>