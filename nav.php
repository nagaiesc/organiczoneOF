<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

    <style>
     
        #a{
            grid-area: cuerpo1;
            padding-top: 80px;
            padding-bottom: 80px;
            display: flex;
            gap: 30px;
            justify-content: center;
            flex-wrap: nowrap;
        }

        #barra{
            background-color: rgb(1, 34, 12);
            position: fixed;
            width: 1300px;
            height: 65px;
            margin-left: 280px;
            margin-right: 100px;
            margin-top: 20px;
            border-radius: 50px;
            display:flex;
            justify-content: space-between;
            flex-wrap: nowrap;
        }      
       
        #barra.desliza{
            background-color: black;
            transition: 1s;
        }

        #orga{
            position: relative;
            left: 15px;
            bottom: 8px;
        }
        a{
            display: flex;
            text-decoration: none;
            color: white;
        }


        #links{
            display: flex;
            flex-direction: row;
        }
       
        #link1{
            margin-right: 10px;
        }
        #link2{
            margin-right: 20px;
            margin-left: 20px;
        }
       
        #link3{
            margin-left: 10px;
        }
        
        #linkprodu{
            background-color: rgba(172, 255, 47, 0.705);
            padding: 13px;
            padding-left: 20px;
            border-radius: 50px;
            position: relative;
            top: 7px;
            right: 8px;
            font-size: 20px;
        }
       
        #descu{
            background-color: rgba(172, 255, 47, 0.705);
            padding: 13px;
            padding-left: 20px;
            border-radius: 50px;
        }
       
        #descu2{
            position: relative;
            bottom: 11px;
            right: 8px;
        }
        .menu-desplegable{
            position: relative;
        }

        .submenu{
            display: none;
            position: absolute;
            top: 100%;
            left: 0;
            min-width: 220px;
            background: black;
            border-radius: 15px;
            overflow: visible;
            z-index: 1000;
        }

        .menu-desplegable:hover .submenu{
            display: block;
        }

        .submenu-item{
            position: relative;
            display: block;
            padding: 20px;
            color: white;
            text-decoration: none;
            background: black;
            border-radius: 30px;
            background-color: rgba(172,255,47,0.7);
        }

        .submenu a:hover{
            background: rgba(172,255,47,0.7);
            color: black;
        }


        .submenu-lateral{
            display: none;
            position: absolute;
            top: 0;
            left: 100%;
            min-width: 220px;
            background: black;
            border-radius: 15px;
            overflow: hidden;
        }

        .submenu-item:hover .submenu-lateral{
            display: block;
        }
    </style>

</head>
<body>
    <script>
        document.addEventListener('scroll', () => {
        const header = document.querySelector('header');
        const scrollY = window.scrollY;
        const newSize = Math.min(120, 100 + scrollY / 15);
        header.style.backgroundSize = `${newSize}%`;
        });
        window.addEventListener('scroll', () => {
        const barra = document.getElementById('barra');
        if (window.scrollY > 50) {
        barra.classList.add('desliza');  // Aplica clase que reduce el menú
        } else {
        barra.classList.remove('desliza'); // Quita clase cuando vuelve arriba
        }
        });
    </script>  

    <script>
        document.addEventListener('scroll', () => {
        const header = document.querySelector('header');
        const scrollY = window.scrollY;
        const newSize = Math.min(120, 100 + scrollY / 15);
        header.style.backgroundSize = `${newSize}%`;
        });
        </script>  

   
    <center>
    <nav id="barra">
    <div><a href="" id="orga"><h1>OrganicZone</h1></a></div>
    <section id="links">
    <a href="contacto.html" id="link2"><h3>Contacto</h3></a>
    <a href="sobreNosotros.html" id="link3"><h3>Sobre Nosotros</h3></a>
    </section>
    <section> <strong><a href="pedidos.php" id="linkprodu">Pide aquí</a></section></strong>
    <section><a href="Clientes/login.php" id="descu2"><h3 id="descu"> Iniciar Sesion</h3></a></section>
    <div class="menu-desplegable">
    <a href="#"><h3>Menú ▼</h3></a>

    <div class="submenu">

        <div class="submenu-item">
            <a href="#">🍔 Hamburguesas</a>
        </div>

        <div class="submenu-item">
            <a href="#">🥤 Refrescos</a>
        </div>

        <div class="submenu-item">
            <a href="#">🥛 Mi Leche</a>
        </div>

    </div>
</div>
    </nav>
    </center>

</body>
</html>