//Input de la fecha
let inputFecha = document.getElementById('fechaInput');

//Tabla donde se mostrarán los tramos
let tablaTramos = document.getElementById('tablaTramos');

// Función para limpiar la tabla
function limpiarTabla() {
    // Limpiamos la tabla eliminando su contenido
    tablaTramos.innerHTML = '';

    // Creamos los encabezados y los agregamos a la tabla
    let encabezados = document.createElement('thead');
    encabezados.innerHTML = '<tr><th class="text-center">Hora</th><th class="text-center">Disponibilidad</th></tr>';
    tablaTramos.appendChild(encabezados);

    // Creamos y devolvemos un nuevo cuerpo de tabla
    return document.createElement('tbody');
}

// Función para crear una fila
function crearFila(id, hora, disponibilidad) {
    // Creamos una nueva fila con las celdas correspondientes
    let fila = document.createElement('tr');
    let celda1 = document.createElement('td');
    celda1.id = id;
    celda1.className = "text-center";
    celda1.textContent = hora;

    // Añadimos el evento click a la celda1
    celda1.addEventListener('click', crearReserva);

    let celda2 = document.createElement('td');
    celda2.id = id + "d";
    celda2.className = "text-center";
    celda2.textContent = disponibilidad;

    // Concatenamos las celdas a la fila
    fila.appendChild(celda1);
    fila.appendChild(celda2);

    return fila;
}


// Función para obtener tramos y reservas
function obtenerTramosYReservas(fechaSeleccionada) {
    return fetch(`index.php?accion=tramos`)
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.json();
        })
        .then(data => {
            // Limpiamos la tabla y obtenemos un nuevo cuerpo de tabla
            let cuerpoTabla = limpiarTabla();

            // Iteramos sobre los tramos y creamos filas para la tabla
            data.forEach(tramo => {
                cuerpoTabla.appendChild(crearFila(tramo.id, tramo.hora, 'SI'));
            });

            // Agregamos el cuerpo de tabla a la tabla
            tablaTramos.appendChild(cuerpoTabla);

            // Devolvemos la promesa de obtener reservas
            return fetch(`index.php?accion=obtenerReservas&fecha=${fechaSeleccionada}`);
        })
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.json();
        });
}

// Evento al seleccionar una fecha
inputFecha.addEventListener('change', function () {
    // Realizamos una solicitud para obtener la ID del usuario
    fetch(`index.php?accion=obtenerUsuario`)
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.json();
        })
        .then(data => {
            //Mostrar preloader
            $("#overlay").fadeIn();

            // Almacenamos la ID del usuario en una variable
            var idUsuario = data.idUsuario;
            //Añadimos el idUsuario al boton de crear
            document.getElementById('botonCrear').setAttribute("data-idUsuario", idUsuario);

            // Obtenemos la fecha seleccionada
            var fechaSeleccionada = inputFecha.value;
            //Añadimos la fecha al boton de crear
            document.getElementById('botonCrear').setAttribute("data-fecha", fechaSeleccionada);

            // Llamamos a la función para obtener tramos y reservas
            obtenerTramosYReservas(fechaSeleccionada, idUsuario)
                .then(data => {
                    // Iteramos sobre las reservas y actualizamos la tabla
                    data.forEach(reserva => {
                        let fila = document.getElementById(reserva.idTramo);
                        let filad = document.getElementById(reserva.idTramo + "d");

                        // Comparamos la ID del usuario con la ID del usuario asociada a la reserva
                        if (idUsuario === reserva.idUsuario) {
                            // Si es la reserva del usuario actual, cambiamos el color a azul
                            fila.style.background = "blue";
                            fila.style.fontWeight = "bold";
                            fila.removeEventListener('click', crearReserva);
                            fila.addEventListener('click', borrarReserva);
                            fila.setAttribute("data-idReserva", reserva.idReserva);
                        } else {
                            // Si no es la reserva del usuario actual, dejamos el color en rojo
                            fila.style.background = "red";
                            fila.removeEventListener('click', crearReserva);
                        }

                        filad.innerHTML = "NO";
                    });

                    //Ocultar preloader
                    $("#overlay").fadeOut();
                })
                .catch(error => {
                    // Manejamos errores en la consola
                    console.error('Error fetching data:', error);
                });
        })
        .catch(error => {
            // Manejamos errores en la consola
            console.error('Error fetching data:', error);
        });
});

function borrarReserva() {
    // Mostrar el modal al hacer clic en el botón
    document.getElementById('confirmModal').style.display = 'block';

    //Id de la celda
    var celda = this.id;

    //Id de la reserva
    var reserva = this.getAttribute('data-idReserva');

    //Le añadimos el id de la celda y el id de la reserva al boton
    document.getElementById('botonBorrar').setAttribute("data-idCelda", celda);
    document.getElementById('botonBorrar').setAttribute("data-idReserva", reserva);
}

function cerrarModal() {
    // Cerrar el modal al hacer clic en la "x" o en el área exterior
    document.getElementById('confirmModal').style.display = 'none';
}

function confirmarEliminacion() {
    //Mostrar el preloader
    $("#overlay").fadeIn();

    //Obtenemos el id de la reserva que esta guardado en el boton como un data- y la id de celda
    let idReserva = document.getElementById('botonBorrar').getAttribute('data-idReserva');
    let idCelda = document.getElementById('botonBorrar').getAttribute('data-idCelda');

    //LLamamos al script del servidor que borra la reserva pasandole el idReserva
    fetch(`index.php?accion=borrarReserva&idReserva=${idReserva}`)
        .then(datos => datos.json())
        .then(respuesta => {
            if (respuesta.respuesta == 'ok') {
                //Cambiar las celdas de color
                document.getElementById(idCelda).style.background = "white";
                document.getElementById(idCelda).style.fontWeight = "normal";

                //Añadimos SI en disponibilidad
                document.getElementById(idCelda + "d").innerHTML = "SI";

                //Quitamos la id de la reserva
                document.getElementById(idCelda).removeAttribute('data-idReserva');

                //Le añadimos el evento de crear reserva
                document.getElementById(idCelda).addEventListener('click', crearReserva);
                //Le borramos el evento de eliminar reserva
                document.getElementById(idCelda).removeEventListener('click', borrarReserva);

                //Mensaje de exito
                mensaje = document.createElement('div');
                mensaje.id = "mensajeCorrecto"
                mensaje.classList.add("correcto");
                mensaje.innerHTML = "Reserva cancelada con éxito";

                document.body.appendChild(mensaje);

                // Muestra el mensaje de correcto al cargar la página
                $(document).ready(function () {
                    $(".correcto").fadeIn().delay(5000).fadeOut();
                });

                //Ocultar el preloader
                $("#overlay").fadeOut();
            } else {
                alert("No se ha encontrado la tarea en el servidor");
            }
        });

    cerrarModal();
}

function crearReserva() {
    // Mostrar el modal al hacer clic en el botón
    document.getElementById('confirmReservaModal').style.display = 'block';

    //Id de la celda
    var celda = this.id;

    //Le añadimos el id de la celda y el id de la reserva al boton
    document.getElementById('botonCrear').setAttribute("data-idCelda", celda);
}

function cerrarReservaModal() {
    // Cerrar el modal al hacer clic en la "x" o en el área exterior
    document.getElementById('confirmReservaModal').style.display = 'none';
}

function confirmarReserva() {
    //Muestro el preloader
    $("#overlay").fadeIn();

    //Obtenemos el id de la reserva que esta guardado en el boton como un data- y la id de celda
    let fecha = document.getElementById('botonCrear').getAttribute('data-fecha');
    let idUsuario = document.getElementById('botonCrear').getAttribute('data-idUsuario');
    let idCelda = document.getElementById('botonCrear').getAttribute('data-idCelda');

    //LLamamos al script del servidor que crea la reserva pasandole el idReserva
    fetch(`index.php?accion=crearReserva&fecha=${fecha}&idUsuario=${idUsuario}&idTramo=${idCelda}`)
        .then(datos => datos.json())
        .then(respuesta => {
            if (respuesta.respuesta == 'ok') {
                //Cambiar las celdas de color
                document.getElementById(idCelda).style.background = "blue";
                document.getElementById(idCelda).style.fontWeight = "bold";

                //Añadir NO en disponibilidad
                document.getElementById(idCelda + "d").innerHTML = "NO";

                //Añadir el idReserva a la celda
                document.getElementById(idCelda).setAttribute("data-idReserva", respuesta.idReserva);

                //Le eliminamos el evento de crear reserva
                document.getElementById(idCelda).removeEventListener('click', crearReserva);
                //Le añadimos el evento de eliminar reserva
                document.getElementById(idCelda).addEventListener('click', borrarReserva);

                //Mensaje de exito
                mensaje = document.createElement('div');
                mensaje.id = "mensajeCorrecto"
                mensaje.classList.add("correcto");
                mensaje.innerHTML = "Reserva realizada con éxito";

                document.body.appendChild(mensaje);

                // Muestra el mensaje de correcto al cargar la página
                $(document).ready(function () {
                    $(".correcto").fadeIn().delay(5000).fadeOut();
                });

                //Esconder preloader
                $("#overlay").fadeOut();
            } else {
                alert("No se ha encontrado la tarea en el servidor");
            }
        });

    // Cerrar el modal después de confirmar la reserva
    cerrarReservaModal();
}


