<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Registro de Usuarios</title>
<script src="https://code.jquery.com/jquery-3.6.3.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.5/jquery.validate.min.js"></script>

<style>

body {
    background: #969696;
    margin: 0;
    font-family: 'Inter', Arial, Helvetica, sans-serif;
    color: #111;
    min-height: 100vh;
    display: flex;
    justify-content: center;
    align-items: center;
}

/* CONTENEDOR PRINCIPAL */
.cajp {
    background: #fff;
    width: 100%;
    max-width: 750px;
    border-radius: 40px;
    box-shadow: 0 2px 32px rgba(0, 0, 0, 0.25);
    padding: 45px 60px;
    box-sizing: border-box;
}

/* ENCABEZADO */
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
    margin-bottom: 35px;
}

/* FORMULARIO */
.forma label {
    font-size: 15px;
    font-weight: 600;
    display: block;
    margin-bottom: 5px;
}

.forma input,
.forma select {
    border: none;
    border-bottom: 1px solid #ccc;
    font-size: 17px;
    margin-bottom: 22px;
    width: 100%;
    background: none;
    outline: none;
    padding: 10px 2px;
    transition: border-color 0.2s;
}

.forma input:focus,
.forma select:focus {
    border-bottom: 1.5px solid #111;
}

/* FILAS */
.forma .fil {
    display: flex;
    gap: 20px;
}

.forma .fil div {
    width: 100%;
}

/* BOTÓN */
.forma button {
    width: 100%;
    background: #111;
    color: #fff;
    border: none;
    border-radius: 12px;
    font-size: 16px;
    font-weight: 600;
    padding: 12px;
    cursor: pointer;
    transition: 0.3s;
    margin-top: 10px;
}

.forma button:hover {
    background: #2a2a2a;
    transform: scale(1.01);
}

/* PIE */
.pie {
    text-align: center;
    margin-top: 30px;
    font-size: 14px;
    opacity: 0.8;
}

/* RESPONSIVE */
@media (max-width: 700px) {

    .cajp {
        padding: 30px;
        margin: 20px;
    }

    .titu {
        font-size: 34px;
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

    <div class="titu">Registro de Usuario</div>

    <form class="forma" action="login.php" method="POST">

        <label>CI</label>
        <input type="number" name="CI" >

        <label>Nombre</label>
        <input type="text" name="nombre" >

        <div class="fil">

            <div>
                <label>Dirección</label>
                <input type="text" name="direccion">
            </div>

            <div>
                <label>Celular</label>
                <input type="number" name="celular" >
            </div>

        </div>

        <div class="fil">

            <div>
                <label>Rol</label>

                <select name="rol" >
                   
                    <option value="admin">Admin</option>
                    <option value="vendedor">Vendedor</option>
                </select>
            </div>

            <div>
                <label>Estado</label>

                <select name="estado" >
                    <option value="">Seleccione un estado</option>
                    <option value="activo">Activo</option>
                    <option value="inactivo">Inactivo</option>
                </select>
            </div>

        </div>

        <button type="submit">Guardar Usuario</button>

    </form>

    <div class="pie">
        Organic Zone - Cochabamba, Bolivia 2026
    </div>

</div>

<script>
    $("form").validate({
        rules:{
            CI:{
                required:true
            },
            nombre:{
                required:true
            },
            direccion:{
                required:true
            },
            celular:{
                required:true
            },
            rol:{
                required:true
            },
            estado:{
                required:true
            }

        },
        messages:{
            CI:{
                required:"este campo no puede estar vacio"
            },
            nombre:{
                required:"este campo no puede estar vacio"
            },
            direccion:{
                required:"este campo no puede estar vacio"
            },
            celular:{
                required:"este campo no puede estar vacio"
            },
            rol:{
                required:"este campo no puede estar vacio"
            },
            estado:{
                required:"este campo no puede estar vacio"
            }
        }
    })
</script>

</body>
</html>