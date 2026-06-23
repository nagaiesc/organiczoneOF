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

            background-color: #60a04d8f;
            position: fixed;
            top:20px;
            left:50%;
            transform:translateX(-50%);
            width:90%;
            max-width:1300px;
            height:65px;
            border-radius:50px;
            display:flex;
            justify-content:space-between;
            align-items:center;
            padding:0 20px;
            box-sizing:border-box;
            z-index:1000;
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
        #barra a{
            display:flex;
            text-decoration:none;
            color:white;
        }

        #links{
            display:flex;
            flex-direction:row;
            align-items:center;
            gap:15px;
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
            background-color: rgba(23, 61, 33, 0.69);
            padding: 13px;
            padding-left: 20px;
            border-radius: 50px;
            position: relative;
            top: 7px;
            right: 8px;
            font-size: 20px;
        }
       
        #descu{
            background-color: rgba(23, 61, 33, 0.69);
            padding: 13px;
            padding-left: 20px;
            border-radius: 50px;
        }
       
        #descu2{
            position:relative;
            right:0;
            bottom:0;
        }
        
        
    </style>

    <style> /*ESTILOS SUBMENUS */
.menu{
position: relative;
display:flex;
justify-content: center;
top: 20px;
left: 50%;
transform: translateX(-50%);
display: flex;
gap: 25px;
align-items: center;
padding: 15px 30px;
background: rgba(39, 133, 30, 0.66);
backdrop-filter: blur(15px);
-webkit-backdrop-filter: blur(15px);
border: 1px solid rgba(80, 206, 69, 0.66);
border-radius: 50px;
box-shadow: 0 8px 32px rgba(65, 168, 55, 0.69);
z-index: 1000;
}
.item{
position: relative;
}
.item > a{
display:flex;
align-items:center;
gap:8px;
text-decoration:none;
color:rgb(255, 255, 255);
padding:12px 18px;
border-radius:12px;
background:rgba(99, 143, 95, 0.54);
transition:.3s;
}
.item > a:hover{
background:rgba(103, 236, 91, 0.35);
}
.submenu{
position:absolute;
top:110%;
left:0;
min-width:180px;
background:rgba(139, 189, 135, 0.59);
backdrop-filter:blur(15px);
border-radius:15px;
max-height:0;
overflow:hidden;
transition:max-height.5s ease;
}
.item:hover .submenu{
max-height:250px;
}
.submenu a{
display:block;
text-decoration:none;
color:rgb(255, 253, 253);
padding:12px 15px;
transition:.3s;
}
.submenu a:hover{
background:rgba(95, 202, 109, 0.88);
}
.flecha{
transition:.4s;
}
.item:hover .flecha{
transform:rotate(90deg);
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
    <div><a href="../paginaprincipal.php" id="orga" ><h1>OrganicZone</h1></a></div>
    <section id="links">
        <div class="item">
    <a href="#">
        Nosotros
        <span class="flecha">▶</span>
    </a>

    <div class="submenu">
        <a href="misionvision.php">Misión y Visión</a>
    </div>
</div>

<div class="item">
    <a href="#">
        About Us
        <span class="flecha">▶</span>
    </a>
    <div class="submenu">
        <a href="contacto.php">Contacto</a>
    </div>
</div>
<div class="item">
    <a href="#">
        Menú
        <span class="flecha">▶</span>
    </a>
    <div class="submenu">
        <a href="hamburguesas.php">Hamburguesas</a>
        <a href="refrescos.php">Refrescos</a>
    </div>
</div>

    </section>
    <section><a href="Usuarios/formulariosesion.php" id="descu2"><h3 id="descu"> Iniciar Sesion</h3></a></section>
    <section><a href='../Usuarios/cerrarse.php'  id="descu2"><h3 id="descu" >Cerrar Sesion</h3></a></section>
   
    </nav>
    </center>

</body>
</html>