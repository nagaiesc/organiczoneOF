<!DOCTYPE html>
<html lang="en">
<head>
 <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
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
      margin: 60px auto 0 auto;
      max-width: 1050px;
      border-radius: 60px;
      box-shadow: 0 2px 32px rgba(139, 66, 66, 0.53);
      padding: 40px 60px 0 60px;
      box-sizing: border-box;
    }
    .nav {
      display: flex;
      align-items: center;
      justify-content: space-between;
      padding-bottom: 18px;
      font-size: 16px;
    }
    .nav .izq {
      display: flex;
      gap: 32px;
    }
    .nav .izq a {
      text-decoration: none;
      color: #111;
      opacity: 0.7;
      font-weight: 400;
      transition: opacity 0.15s;
    }
    .nav .izq a.inic {
      font-weight: 700;
      opacity: 1;
    }
    .nav .med {
      font-weight: 700;
      letter-spacing: 2px;
    }
    .nav .der {
      display: flex;
      align-items: center;
      gap: 15px;
    }
    .nav .cart {
      font-size: 18px;
      padding-right: 5px;
    }
    .nav button,
    .nav .sesion {
      padding: 5px 18px;
      border-radius: 20px;
      border: 1px solid #111;
      background: #fff;
      font-weight: 500;
      cursor: pointer;
      font-size: 14px;
      margin-left: 8px;
    }
    .nav .sesion {
      background: #ffffffff;
      border: none;
    }
    .nav .reg {
      background: #136901ff;
      color: #fff;
      border: none;
    }
    .titu {
      font-size: 92px;
      font-weight: 900;
      letter-spacing: -3px;
      margin: 36px 0 28px 0;
      line-height: 1.02;
    }
    .conm {
      display: flex;
      gap: 60px;
      margin-bottom: 56px;
    }
    .conmd,
    .comi { flex: 1; }
    .info {
      font-size: 15px;
      opacity: 0.85;
      margin-bottom: 22px;
    }
    .info strong {
      font-size: 17px;
      display: block;
      margin-bottom: 10px;
      color: #111;
      opacity: 1;
    }
    .forma label {
      font-size: 15px;
      font-weight: 500;
      margin-bottom: 4px;
      display: inline-block;
    }
    .forma input,
    .forma select,
    .forma textarea {
      border: none;
      border-bottom: 1px solid #ffffffff;
      font-size: 17px;
      margin-bottom: 16px;
      width: 98%;
      background: none;
      outline: none;
      padding: 10px 2px 5px 0;
      transition: border-color 0.2s;
    }
    .forma input:focus,
    .forma select:focus,
    .forma textarea:focus {
      border-bottom: 1.5px solid #111;
    }
    .forma .fil {
      display: flex;
      gap: 18px;
    }
    .forma .fil input {
      width: 100%;
      min-width: 0;
    }
    .forma .checkbox-fil {
      margin: 8px 0 19px 0;
      font-size: 14px;
      display: flex;
      align-items: center;
      gap: 8px;
    }
    .forma .checkbox-fil input[type="checkbox"] {
      width: 16px;
      height: 16px;
    }
    .forma button {
      background: #111;
      color: #fff;
      border: none;
      border-radius: 12px;
      font-size: 16px;
      font-weight: 600;
      padding: 7px 26px;
      margin-top: 12px;
      cursor: pointer;
      transition: background 0.18s;
    }
    .forma button:hover {
      background: #ffffffff;
    }
    .pie {
      background-color: #ffffff;
      width: 100%;
      display: flex;
      justify-content: space-between;
      align-items: flex-end;
      margin-top: 52px;
      padding-bottom: 24px;
      font-size: 15px;
      box-sizing: border-box;
    }
    .pie .correo {
     font-size: 29px;
      font-weight: 800;
      letter-spacing: 0.8px;
      display: flex;
      gap: 50px;
      margin-bottom: 60px;
    }
    .pie .deta {
      font-size: 14px;
      opacity: 0.87;
    }
    .pie .pielin {
      display: flex;
      align-items: center;
      gap: 10px;
      font-size: 14px;
      opacity: 0.8;
    }
    .pie .pielin a {
      text-decoration: none;
      color: #111;
      opacity: 0.8;
      margin-right: 7px;
    }
    .pie .pielin span {
      margin: 0 7px;
      opacity: 0.6;
    }
    @media (max-width: 900px) {
      .cajp { padding: 20px; }
      .titu { font-size: 56px; }
      .conm { flex-direction: column; gap: 40px; }
      .pie { flex-direction: column; align-items: flex-start; gap: 20px; }
      .footer .correo { font-size: 19px; gap: 12px; }
    }
  </style>
</head>
<body>
  <img src="" alt="">

  <div class="cajp">
    <nav class="nav">
      <div class="izq">
        <a href="http://localhost/OrganicZone/sobreNosotros.html">Sobre Nosotros</a>
        <a href="../maquetadoOZ.html" class="inic">Inicio</a>
        <a href="http://localhost/OrganicZone/Clientes/leerclientes.php">Regristros de Usuarios</a>
      </div>
      <div class="med">ORGANIC ZONE</div>
      <div class="der">
        <span class="cart">🛒</span>
        <button class="sesion">Iniciar Sesion</button>
        <button class="reg" >Regitrarse</button>
      </div>
    </nav>
    <div class="titu">Bienvenido a Organic Zone</div>
    <div class="conm">
      <div class="conmd">
        <div class="info">
          <strong>Bolivia, Cochabamba<br>2025</strong>
          Horas de Atención<br>
          LUNES - VIERNES<br>
          11 AM - 2 PM
        </div>
      </div>
      <div class="comi">
        <form class="forma" method="post" action="clientes.php">
          <div class="fil">
            <div>
              <label for="nombre">Nombre del cliente</label><br>
              <input type="text" name="nombre" placeholder="Nombre del cliente" required >
            </div>
            <div>
              <label for="apellido" style="visibility:hidden">Apellido del cliente</label><br>
              <input type="text" name="apellido" placeholder="Apellido" required>
            </div>
          </div>
           <label  for="nombreusuario">Nombre de usuario</label><br>
              <input type="text" name="nombreusuario" placeholder="Nombre de usauario" required><br>
          </select><br>
          <label for="correo">Correo-Email </label><br>
          <input type="email" name="correo" required><br>
           <label for="fechanacimento">Fecha de nacimiento</label><br>
          <input type="date" name="fechanacimiento" required><br>
          <div class="checkbox-fil">
            <input type="checkbox" id="news" name="news">
            <label for="news">Inicia Sesion para no perderte de nada!!</label> 
          </div>
          <label>Contraseña</label><br>
          <input type="password" name="contrasena" required><br>
          <button type="submit" value="Enviar">Enviar</button>
        </form>
      </div>
    </div>
    <div class="pie">
      <div>
        <div class="correo">
        <span>theorganiczone23@gmail.com</span>
          <span>(+591) 70376053</span>
        </div>
        <div class="deta">
          Bolivia, Cochabamba 2025<br>
        </div>
      </div>
      <div class="pielin">
        <a href="#">HI ORGANIC</a>
        <span>|</span>
        <a href="#">CONTACTOS PERSONALES</a>
        <span>|</span>
        <a href="https://www.instagram.com/the_organic_zone_?utm_source=ig_web_button_share_sheet&igsh=ZDNlZDc0MzIxNw==">IG</a>
      </div>
    </div>
  </div>
</body>
</html>


