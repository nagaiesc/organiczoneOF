function agregarProducto(idProducto) {

    fetch("Cliente/iniciar_pedido.php", {
        method: "POST"
    })

    .then(response => response.json())

    .then(data => {

        if (data.ok) {

            fetch("Cliente/agregarcarrito.php", {
                method: "POST",
                headers: {
                    "Content-Type": "application/x-www-form-urlencoded"
                },
                body: "productos_id=" + idProducto
            })

            .then(response => response.json())

            .then(dataCarrito => {

                if (dataCarrito.ok) {

                    mostrarCarrito();

                } else {

                    alert(dataCarrito.mensaje);

                }

            });

        } else {

            alert(data.mensaje);

        }

    });

}


function mostrarCarrito() {

    fetch("Cliente/obtener_carrito.php")

    .then(response => response.json())

    .then(data => {

        const carrito = document.getElementById("lista-carrito");

        const total = document.getElementById("total-carrito");

        const contador = document.getElementById("contador-carrito");


        carrito.innerHTML = "";


        if (data.productos.length == 0) {

            carrito.innerHTML = `
                <p class="carrito-vacio">
                    Tu carrito está vacío
                </p>
            `;

            total.textContent = "Bs. 0";

            contador.textContent = "0";

            return;

        }


        let cantidadProductos = 0;


        data.productos.forEach(producto => {

            cantidadProductos += parseInt(producto.cantidad);


            carrito.innerHTML += `

                <div class="producto-carrito">

                    <div>
                        <strong>${producto.nombre}</strong>

                        <p>
                            Bs. ${producto.precio}
                            × ${producto.cantidad}
                        </p>
                    </div>

                    <strong>
                        Bs. ${producto.costototal}
                    </strong>

                </div>

            `;

        });


        total.textContent = "Bs. " + data.total;

        contador.textContent = cantidadProductos;

    });

}