<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

    <style>
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
        #direc{
            width: 450px;
            height: 200px;
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
    </style>
</head>
<body>
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