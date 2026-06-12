<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@600;700&family=Open+Sans:wght@400&display=swap" rel="stylesheet">


    <style>
        body{
            display: grid;
            grid-template-rows: 500px, 500px;
            grid-template-columns: 100%;
            grid-template-areas:
            "na"
            "cabecera"
            "cuerpo1"
            "cuerpo2"
            "piepag"
            ;
        }
        header{
            padding: 600px;
            border-radius: 30px;
            grid-area: cabecera;
            background-size: 100%;
            background-position: center;
            background-image: url(Fondo1.png);
            background-repeat: no-repeat;
            transition: background-size 1.5s ease;
        }
        .texto-header {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            text-align: center;
            max-width: 900px;
            padding: 100px;
            color: white;
        }
        .texto-header p {
        font-family: 'Open Sans', sans-serif;
        font-size: 1.2rem;
        color: #f5f5f5;
        }
        .texto-header h1 {
            font-family: 'Poppins', sans-serif;
            font-weight: 700;
            font-size: 3rem;
            text-decoration: none;
            color: #ffffff;
        }

        .texto-header h1 {
            font-weight: bold;
            font-size: 3rem;
            text-decoration: underline;
        }
       
        .texto-header p {
            margin-top: 1rem;
            font-size: 1.25rem;
        }
                                                                     
        .productos{
            width: 400px;
            height: 800px;
            border-radius: 50px;
        }
       
        #b{
            grid-area: cuerpo2;
            padding-top: 80px;
            padding-bottom: 80px;
            display: flex;
            justify-content: center;
            flex-wrap: nowrap;
        }
        #cinco{
            background-color: black;
            border-radius: 60px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            width: 1200px;
            height: 600px;
            padding: 40px;
        }
        #bf{
            width:700px ;
            height: 680px;
            border-radius: 60px;
           
        }
        #bf img {
        margin-left: 40px;
        width: 100%;
        height: 100%;
        border-radius: 60px;
}
        .imagenes{
            border-radius: 50px;
            width: 400px;
        }
       
        .titulos{
            text-align: center;
            color: black;
            font-family: poppins, sans-serif;
           
        }
        #textocaja5{
            color: white;
            font-family: poppins, sans-serif;
            font-size: 40px;
            margin-bottom: 30px;
        }
        .texto5{
            color: white;
            margin-bottom: 20px;
            font-size: 20px;
            font-family: poppins, sans-serif;
        }
        footer{
            background-color: black;
            grid-area: piepag;
            padding-top: 80px;
            padding-bottom: 80px;
            font-family: poppins, sans-serif;
            color: white;
        }
        @media (max-width: 700px) {
            header{
            padding-bottom: 100px;
                }
                .texto-header {
                    top: 20%;
                    left: 50%;
                }
            .texto-header h1 {
                margin-top: 350px;
                    font-size: 30px;
                    text-decoration: underline;
                }

            .texto-header p {
                    margin-top: 1rem;
                    font-size: 20px;
                }

            #barra {
            position: fixed;
            width: 465px;
            margin: 0;
            border-radius: 0;
            }
            #links{
                    display: flex;
                    flex-direction:row;
                    justify-content: center;
                    font-size: 13px;
                    margin-top: 4px;
                
                }
            #orga{
            position: relative;
            font-size: 10px;
            left: 1px;
            bottom: 8px;
            margin-top: 10px;
            }
            #descu{
            background-color: rgba(172, 255, 47, 0.705);
            font-size: 14px;
            padding: 5px;
            padding-left: 20px;
            border-radius: 50px;
            margin-top: 25px;
            }
        #a, #b {
            flex-wrap: wrap;
            padding-left: 10px;
            padding-right: 10px;
            justify-content: center;
        }
        .productos {
            width: 90%;
            height: auto;
            margin-bottom: 20px;
        }
        .texto-header {
            padding: 20px;
        }
        #cinco {
            width: 95%;
            height: auto;
            flex-direction: column;
            padding: 20px;
        }
        #bf, #bf img {
            width: 100%;
            height: auto;
            margin-left: 0;
            border-radius: 30px;
        }
        address {
            flex-direction: column;
            gap: 20px;
            padding: 10px;
        }
        #direc, #cont, #mail {
            width: 100%;
            height: auto;
        }
        }


    </style>
</head>
<body>
    <nav>
         <?php 
        include("nav.php");
        ?>
    </nav>
    
    <header>
        <div class="fondo"></div>
        <div class="texto-header">
            
    </header>

    <section id="b" >
        <div id="cinco" >
            <div >
            <h1 id="textocaja5">Saborea la diferencia <br> con ingredientes <br>frescos y orgánicos</h1> <br>
            <p class="texto5"> En Organic Zone, creemos que las mejores hamburguesas <br>comienzan con los mejores ingredientes. Es por eso que <br>obtenemos nuestros productos de granjas orgánicas locales, <br>asegurando que cada bocado esté lleno de sabor y nutrientes. <br>¡Prueba la diferencia que hace la calidad!</p>
             <ul class="texto5" style="list-style:none;">
                <li>⸙ De origen local: Apoyamos a nuestros agricultores de la comunidad.</li>
                <li>⸙ Productos orgánicos: Más saludables y sabrosos.</li>
                <li>⸙ Prácticas sostenibles: Ambientalmente responsables.</li>
            </ul>
        </div>
        <div id="bf">
      <img src="img5.webp" alt="" >
    </section>
    <footer>
        <?php 
        include("footer.php");
        ?>
    </footer>
</body>
</html>
