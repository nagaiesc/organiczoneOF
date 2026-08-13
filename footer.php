<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Organic Zone - Footer</title>

    <style>

        @import url('https://fonts.googleapis.com/css2?family=Fredoka:wght@400;500;600;700&display=swap');

        #c{
            background-color:#000000;
            grid-area:piepag;
            padding-top:80px;
            padding-bottom:80px;
            font-family:'Fredoka', sans-serif;
            color:white;
        }

        address{
            width:100%;
            display:flex;
            gap:60px;
            justify-content:center;
            flex-wrap:nowrap;
        }

        #direc{
            width:450px;
            height:200px;
        }

        #cont{
            width:450px;
            height:200px;
        }

        #mail{
            width:450px;
            height:200px;
        }

        .imgfooter{
            border-radius:50px;
            width:40px;
        }

        #c h1{
            font-family:'Fredoka', sans-serif;
            font-weight:700;
        }

        #c p{
            font-family:'Fredoka', sans-serif;
            font-weight:400;
            line-height:1.5;
        }

        #c strong{
            font-weight:600;
        }

        @media(max-width:900px){

            address{
                flex-direction:column;
                align-items:center;
                gap:20px;
            }

            #direc,
            #cont,
            #mail{
                width:90%;
                height:auto;
                min-height:180px;
            }

        }

    </style>
</head>

<body>

<footer id="c">

    <center>

        <p><strong>VISÍTANOS</strong></p>

        <h1>
            <strong>
                Encuéntranos en el <br>
                Colegio Pedro Poveda
            </strong>
        </h1>

        <p>
            Ven a visitarnos en Colegio Pedro Poveda Plazuela Tarija,
            Av. América, Cochabamba y disfruta de nuestras hamburguesas
            <br>
            gourmet orgánicas en un ambiente acogedor.
        </p>

    </center>

    <br>

    <address>

        <div id="direc">

            <center>
                <img class="imgfooter" src="ubicacion.png" alt="Ubicación">
            </center>

            <center>
                <h1><strong>DIRECCIÓN</strong></h1>
            </center>

            <center>
                <p>
                    Colegio Pedro Poveda Plazuela Tarija,
                    Av. América, Cochabamba Bolivia
                </p>
            </center>

        </div>


        <div id="cont">

            <center>
                <img class="imgfooter" src="llamenos.png" alt="Contacto">
            </center>

            <center>
                <h1><strong>CONTACTO</strong></h1>
            </center>

            <center>
                <p>
                    +591 70376053
                    <br>
                    Llámanos para reservas o consultas.
                </p>
            </center>

        </div>


        <div id="mail">

            <center>
                <img class="imgfooter" src="contacto.jpg" alt="Correo electrónico">
            </center>

            <center>
                <h1><strong>CORREO ELECTRÓNICO</strong></h1>
            </center>

            <center>
                <p style="color:#11b348;">
                    organiczone@gmail.com
                </p>

                <p>
                    Esperamos tener noticias tuyas.
                </p>
            </center>

        </div>

    </address>

</footer>

</body>
</html>