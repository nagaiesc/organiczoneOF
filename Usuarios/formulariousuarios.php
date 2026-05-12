<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <form class="forma" action="usuarios.php" method="POST">

    <label>CI</label>
    <input type="text" name="CI" required><br>

    <label>Nombre</label>
    <input type="text" name="nombre" required><br>

    <label>Dirección</label>
    <input type="text" name="direccion" required><br>

    <label>Celular</label>
    <input type="text" name="celular" required><br>

    <label>Rol</label>
    <select name="rol" required>
        <option value="">Seleccione un rol</option>
        <option value="admin">Admin</option>
        <option value="usuario">Usuario</option>
    </select><br>

    <label>Estado</label>
    <select name="estado" required>
        <option value="">Seleccione un estado</option>
        <option value="activo">Activo</option>
        <option value="inactivo">Inactivo</option>
    </select><br>

    <button type="submit">Guardar Usuario</button>

</form>
</body>
</html>