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
    fila.innerHTML = `<td id="${id}" class="text-center">${hora}</td><td id="${id}d" class="text-center">${disponibilidad}</td>`;
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
            // Almacenamos la ID del usuario en una variable
            const idUsuario = data.idUsuario;

            // Obtenemos la fecha seleccionada
            var fechaSeleccionada = inputFecha.value;

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
                        } else {
                            // Si no es la reserva del usuario actual, dejamos el color en rojo
                            fila.style.background = "red";
                        }

                        filad.innerHTML = "NO";
                    });
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

