const config = window.ORGANIC_ZONE || { pedidoId: 0, pedidoConfirmado: false };
let pedidoId = Number(config.pedidoId || 0);
let pedidoConfirmado = Boolean(config.pedidoConfirmado);

const modalPedido = document.getElementById('modalPedido');
const formPedido = document.getElementById('formPedido');
const mensajePedido = document.getElementById('mensajePedido');
const carritoPanel = document.getElementById('carritoPanel');
const carritoOverlay = document.getElementById('carritoOverlay');
const carritoContenido = document.getElementById('carritoContenido');
const totalCarrito = document.getElementById('totalCarrito');
const contadorCarrito = document.getElementById('contadorCarrito');
const finalizarPedido = document.getElementById('finalizarPedido');

function abrirModalPedido() {
    modalPedido?.classList.add('visible');
}

function cerrarModalPedido() {
    modalPedido?.classList.remove('visible');
}

function abrirCarrito() {
    carritoPanel?.classList.add('visible');
    carritoOverlay?.classList.add('visible');
    cargarCarrito();
}

function cerrarCarrito() {
    carritoPanel?.classList.remove('visible');
    carritoOverlay?.classList.remove('visible');
}

function mostrarMensaje(texto, error = false) {
    if (!mensajePedido) return;

    mensajePedido.textContent = texto;
    mensajePedido.style.color = error ? '#b3261e' : '#0A4A1B';
}

function mostrarAlerta(titulo, mensaje, tipo = 'success') {
    const alertaAnterior = document.getElementById('ozAlerta');

    if (alertaAnterior) {
        alertaAnterior.remove();
    }

    let icono = '✓';
    let clase = 'success';

    if (tipo === 'error') {
        icono = '!';
        clase = 'error';
    }

    if (tipo === 'warning') {
        icono = '!';
        clase = 'warning';
    }

    const alerta = document.createElement('div');

    alerta.id = 'ozAlerta';

    alerta.innerHTML = `
        <div class="oz-alerta-fondo">
            <div class="oz-alerta-caja ${clase}">

                <button
                    type="button"
                    class="oz-alerta-cerrar"
                    aria-label="Cerrar">
                    ×
                </button>

                <div class="oz-alerta-icono">
                    ${icono}
                </div>

                <h2>${escaparHtml(titulo)}</h2>

                <p>${escaparHtml(mensaje)}</p>

                <button
                    type="button"
                    class="oz-alerta-boton">
                    Aceptar
                </button>

            </div>
        </div>
    `;

    document.body.appendChild(alerta);

    const botonAceptar = alerta.querySelector('.oz-alerta-boton');
    const botonCerrar = alerta.querySelector('.oz-alerta-cerrar');

    botonAceptar.addEventListener('click', cerrarAlerta);
    botonCerrar.addEventListener('click', cerrarAlerta);

    alerta.querySelector('.oz-alerta-fondo').addEventListener('click', (evento) => {
        if (evento.target.classList.contains('oz-alerta-fondo')) {
            cerrarAlerta();
        }
    });

    function cerrarAlerta() {
        alerta.classList.add('oz-alerta-saliendo');

        setTimeout(() => {
            alerta.remove();
        }, 250);
    }
}

async function enviar(url, opciones = {}) {
    const respuesta = await fetch(url, {
        ...opciones,
        headers: {
            'X-Requested-With': 'XMLHttpRequest',
            ...(opciones.headers || {})
        }
    });

    const texto = await respuesta.text();
    let datos;

    try {
        datos = JSON.parse(texto);
    } catch (error) {
        throw new Error('El servidor devolvió una respuesta inesperada. Revisa el archivo PHP correspondiente.');
    }

    if (!respuesta.ok || datos.ok === false) {
        throw new Error(datos.mensaje || 'No se pudo completar la operación.');
    }

    return datos;
}

async function crearPedido(evento) {
    evento.preventDefault();

    const boton = formPedido.querySelector('button[type="submit"]');
    const datos = new FormData(formPedido);

    boton.disabled = true;
    mostrarMensaje('Creando tu pedido...');

    try {
        const respuesta = await enviar('ajax/crear_pedido.php', {
            method: 'POST',
            body: datos
        });

        pedidoId = Number(respuesta.pedido_id);
        pedidoConfirmado = false;

        cerrarModalPedido();
        formPedido.reset();

        document.querySelectorAll('.boton-agregar').forEach((botonAgregar) => {
            const tieneStock = !botonAgregar.closest('.producto-card')?.querySelector('.sin-stock');
            botonAgregar.disabled = !tieneStock;
        });

        actualizarEstadoVisual();
        await cargarCarrito();

        mostrarAlerta(
            '¡Pedido creado!',
            'Pedido #' + pedidoId + ' creado correctamente. Ya puedes agregar productos.',
            'success'
        );

    } catch (error) {
        mostrarMensaje(error.message, true);
    } finally {
        boton.disabled = false;
    }
}

function actualizarEstadoVisual() {
    const estadoCompra = document.getElementById('estadoCompra');

    if (estadoCompra) {
        if (pedidoId > 0) {
            estadoCompra.classList.add('activo');

            estadoCompra.innerHTML =
                '<span class="punto"></span> Pedido #' +
                pedidoId +
                ' listo para agregar productos';

        } else {
            estadoCompra.classList.remove('activo');

            estadoCompra.innerHTML =
                '<span class="punto bloqueado"></span> Genera un pedido para comprar';
        }
    }
}

async function agregarProducto(productoId) {
    if (!pedidoId) {
        abrirModalPedido();
        return;
    }

    if (pedidoConfirmado) {
        mostrarAlerta(
            'Pedido finalizado',
            'Este pedido ya fue finalizado. Crea una nueva compra para agregar productos.',
            'warning'
        );

        return;
    }

    try {
        const datos = new FormData();

        datos.append('productos_id', productoId);
        datos.append('cantidad', '1');

        const respuesta = await enviar('ajax/agregar_carrito.php', {
            method: 'POST',
            body: datos
        });

        await cargarCarrito();
        abrirCarrito();

        if (respuesta.mensaje) {
            console.log(respuesta.mensaje);
        }

    } catch (error) {
        mostrarAlerta(
            'No se pudo agregar',
            error.message,
            'error'
        );
    }
}

async function actualizarCantidad(productoId, cantidad) {
    if (!pedidoId || pedidoConfirmado) return;

    try {
        const datos = new FormData();

        datos.append('productos_id', productoId);
        datos.append('cantidad', cantidad);

        await enviar('ajax/actualizar_carrito.php', {
            method: 'POST',
            body: datos
        });

        await cargarCarrito();

    } catch (error) {
        mostrarAlerta(
            'Error',
            error.message,
            'error'
        );
    }
}

async function eliminarProducto(productoId) {
    if (!pedidoId || pedidoConfirmado) return;

    try {
        const datos = new FormData();

        datos.append('productos_id', productoId);

        await enviar('ajax/eliminar_carrito.php', {
            method: 'POST',
            body: datos
        });

        await cargarCarrito();

    } catch (error) {
        mostrarAlerta(
            'Error',
            error.message,
            'error'
        );
    }
}

async function cargarCarrito() {
    if (!pedidoId) {
        renderCarrito([], 0);
        return;
    }

    try {
        const respuesta = await enviar('ajax/obtener_carrito.php');

        renderCarrito(
            respuesta.items || [],
            Number(respuesta.total || 0)
        );

    } catch (error) {
        console.error(error);
    }
}

function renderCarrito(items, total) {
    contadorCarrito.textContent = items.reduce(
        (suma, item) => suma + Number(item.cantidad),
        0
    );

    totalCarrito.textContent =
        'Bs. ' + formatearNumero(total);

    finalizarPedido.disabled =
        items.length === 0 || pedidoConfirmado;

    if (items.length === 0) {
        carritoContenido.innerHTML = `
            <div class="carrito-vacio">
                <span>🛒</span>
                <h3>Tu carrito está vacío</h3>
                <p>Agrega productos para verlos aquí.</p>
            </div>
        `;

        return;
    }

    carritoContenido.innerHTML = items.map((item) => `
        <div class="item-carrito">

            <div class="item-superior">

                <h3>
                    ${escaparHtml(item.nombre)}
                </h3>

                <span class="item-precio">
                    Bs. ${formatearNumero(item.costototal)}
                </span>

            </div>

            <p class="item-detalle">
                Bs. ${formatearNumero(item.precio)} cada uno
            </p>

            <div class="controles-cantidad">

                <button
                    type="button"
                    onclick="actualizarCantidad(
                        ${item.productos_id},
                        ${Number(item.cantidad) - 1}
                    )">
                    −
                </button>

                <span>
                    ${item.cantidad}
                </span>

                <button
                    type="button"
                    onclick="actualizarCantidad(
                        ${item.productos_id},
                        ${Number(item.cantidad) + 1}
                    )">
                    +
                </button>

                <button
                    type="button"
                    class="eliminar-item"
                    onclick="eliminarProducto(${item.productos_id})">
                    Eliminar
                </button>

            </div>

        </div>
    `).join('');
}

function formatearNumero(numero) {
    return Number(numero).toLocaleString('es-BO', {
        minimumFractionDigits: 0,
        maximumFractionDigits: 0
    });
}

function escaparHtml(texto) {
    return String(texto)
        .replaceAll('&', '&amp;')
        .replaceAll('<', '&lt;')
        .replaceAll('>', '&gt;')
        .replaceAll('"', '&quot;')
        .replaceAll("'", '&#039;');
}

async function finalizarCompra() {
    if (!pedidoId) {
        abrirModalPedido();
        return;
    }

    try {
        const respuesta = await enviar(
            'ajax/finalizar_pedido.php',
            {
                method: 'POST'
            }
        );

        pedidoConfirmado = true;

        cerrarCarrito();

        window.location.href =
            'recibo.php?id=' + respuesta.pedido_id;

    } catch (error) {
        mostrarAlerta(
            'No se pudo finalizar',
            error.message,
            'error'
        );
    }
}

document
    .getElementById('abrirPedido')
    ?.addEventListener(
        'click',
        abrirModalPedido
    );

document
    .getElementById('abrirCarrito')
    ?.addEventListener(
        'click',
        abrirCarrito
    );

document
    .getElementById('cerrarCarrito')
    ?.addEventListener(
        'click',
        cerrarCarrito
    );

carritoOverlay?.addEventListener(
    'click',
    cerrarCarrito
);

formPedido?.addEventListener(
    'submit',
    crearPedido
);

finalizarPedido?.addEventListener(
    'click',
    finalizarCompra
);

document
    .querySelectorAll('[data-cerrar-modal]')
    .forEach((boton) => {

        boton.addEventListener('click', () => {

            const id =
                boton.getAttribute('data-cerrar-modal');

            document
                .getElementById(id)
                ?.classList.remove('visible');

        });

    });

document
    .querySelectorAll('.boton-agregar')
    .forEach((boton) => {

        boton.addEventListener('click', () => {

            agregarProducto(
                Number(boton.dataset.productoId)
            );

        });

    });

modalPedido?.addEventListener(
    'click',
    (evento) => {

        if (evento.target === modalPedido) {
            cerrarModalPedido();
        }

    }
);

cargarCarrito();
