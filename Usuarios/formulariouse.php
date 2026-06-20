<!DOCTYPE html>
<html lang="es">

<head>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Registro de Usuarios</title>

<script src="https://code.jquery.com/jquery-3.6.3.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.5/jquery.validate.min.js"></script>

<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

<link href="https://fonts.googleapis.com/css2?family=Fredoka:wght@400;500;600;700&display=swap" rel="stylesheet">

<style>

*{
    margin:0;
    padding:0;
    box-sizing:border-box;
}

body{

    background:#E8EEE2;
    font-family:'Fredoka',sans-serif;
    overflow-x:hidden;

}
.pagina{

    width:100%;
    min-height:100vh;
    position:relative;

}
.encabezado{

position:absolute;

left:70px;

top:45px;

z-index:1;

width:500px;

}
.titulo{

    z-index:1;
    line-height:.88;

}

.registro{

    display:block;

    font-size:60px;

    font-weight:700;

    color:#2B120C;

}

.usuarios{

    display:block;

    font-size:92px;

    font-weight:700;

    color:#11A83A;

    margin-top:-6px;

}
.contenedor{

    width: 790px;

    height:620px;

    background: #0ba84a;

    border-radius:42px 42px 0 0;

    padding:55px;

    position:absolute;

    top:180px;

    left:50%;

    transform:translateX(-50%);

}

.forma{

width:100%;

margin-top:5px;

}
.fila{

display:flex;

justify-content:space-between;

align-items:flex-start;

gap:28px;

margin-bottom:28px;

}

.campo{

flex:1;

}

.campo label{

    display:block;

    color:#ffffff;

    font-size:17px;

    font-weight:600;

    margin-bottom:10px;

}
.campo input,
.campo select{

width:100%;

height:50px;

background:#E7ECE4;

border:none;

border-radius:12px;

padding-left:18px;

font-size:18px;

font-family:'Fredoka',sans-serif;

}

.opciones{

    display:flex;

    gap:14px;

    margin-top:2px;

}

.opciones input{

    display:none;

}

.opciones span{

    display:flex;

    justify-content:center;

    align-items:center;

    width:102px;

    height:42px;

    border-radius:13px;

    font-size:17px;

    font-weight:600;

    cursor:pointer;

    transition:.25s;

}

.btn-admin span{

    background:#2C1008;

    color:#FFD56A;

}

.btn-vendedor span{

    background:#F6CB69;

    color:#2C1008;

}

.btn-activo span{

    background:#168C2E;

    color:white;

}

.btn-inactivo span{

    background:#E6ECE2;

    color:#2C1008;

}

.opciones span:hover{

    transform:translateY(-2px);

}
.guardar{

display:block;

width:260px;

height:58px;

margin:25px auto 0;

background:#34170F;

border-radius:18px;

font-size:22px;

font-weight:700;

color:white;

border:none;

cursor:pointer;

}
.guardar:hover{

    transform:scale(1.02);

}

@media(max-width:900px){

.encabezado{

left:25px;

top:25px;

}

.registro{

font-size:62px;

}

.usuarios{

font-size:90px;

margin-top:-8px;

}
.contenedor{

position:relative;

left:auto;

top:180px;

width:92%;

margin:auto;

height:auto;

padding:35px;

border-radius:35px;

}

.fila{

flex-direction:column;

gap:20px;

}

.campo{

width:100%;

}

.opciones{

flex-wrap:wrap;

}

}

</style>

</head>

<body>

<main class="pagina">
    <header class="encabezado">

        <h1 class="titulo">

            <span class="registro">
                Registro de
            </span>

            <span class="usuarios">
                Usuarios
            </span>

        </h1>

    </header>
    <section class="contenedor">

        <article class="panel">

            <form
                class="forma"
                action="usuarios.php"
                method="POST">

                <section class="fila">

                    <article class="campo">

                        <label>
 Carnet de Identidad:
                        </label>

                        <input
                            type="number"
                            name="CI">

                    </article>

                    <article class="campo">

                        <label>
      Celular
                        </label>

                        <input
                            type="number"
                            name="celular">

                    </article>

                </section>

                <section class="fila">

                    <article class="campo">

                        <label>
      Nombre
                        </label>

                        <input
                            type="text"
                            name="nombre">

                    </article>

                    <article class="campo">

                        <label>
                            Rol
                        </label>

                        <section class="opciones">
                                                    <section class="opciones">

                            <label class="btn-admin">

                                <input
                                    type="radio"
                                    name="rol"
                                    value="admin">

                                <span>Admin</span>

                            </label>

                            <label class="btn-vendedor">

                                <input
                                    type="radio"
                                    name="rol"
                                    value="vendedor">

                                <span>Vendedor</span>

                            </label>

                        </section>

                    </article>

                </section>

                <section class="fila">

                    <article class="campo">

                        <label>
                            Dirección
                        </label>

                        <input
                            type="text"
                            name="direccion">

                    </article>

                    <article class="campo">

                        <label>
                            Estado
                        </label>

                        <section class="opciones">

                            <label class="btn-activo">

                                <input
                                    type="radio"
                                    name="estado"
                                    value="activo">

                                <span>Activo</span>

                            </label>

                            <label class="btn-inactivo">

                                <input
                                    type="radio"
                                    name="estado"
                                    value="inactivo">

                                <span>Inactivo</span>

                            </label>

                        </section>

                    </article>

                </section>

<button type="submit" class="guardar">Guardar Usuario</button>
</form>
</article>
</section>
</main>

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
            required:"Este campo no puede estar vacío"
        },

        nombre:{
            required:"Este campo no puede estar vacío"
        },

        direccion:{
            required:"Este campo no puede estar vacío"
        },

        celular:{
            required:"Este campo no puede estar vacío"
        },

        rol:{
            required:"Seleccione un rol"
        },

        estado:{
            required:"Seleccione un estado"
        }

    },

    errorElement:"small",

    errorPlacement:function(error,element){

        error.css({

            color:"#FFD56A",
            display:"block",
            marginTop:"6px",
            fontSize:"14px",
            fontFamily:"Fredoka"

        });

        error.insertAfter(element);
     }

});

</script>
</body>
</html>