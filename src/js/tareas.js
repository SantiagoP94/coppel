(function() {

    obtenerRegistros();
    let datos = [];
    // let filtradas = [];

    // Botón para mostrar el Modal de Agregar tarea
    const nuevaTareaBtn = document.querySelector('#agregar-dato');
    nuevaTareaBtn.addEventListener('click', function() {
        mostrarFormulario();
    });
    // Filtros de búsqueda
    const filtros = document.querySelectorAll('#filtros input[type="radio');
    filtros.forEach( radio => {
        radio.addEventListener('input', filtrarTareas);
    } )

    function filtrarTareas(e) {
        const filtro = e.target.value;

        if(filtro !== '') {
            filtradas = tareas.filter(tarea => tarea.estado === filtro);
        } else {
            filtradas = [];
        }

        mostrarTareas();
    }

    //Obtener tareas
    async function obtenerRegistros() {
        try {
            const id = obtenerCria();
            const url = `/api/tareas?id=${id}`;
            const respuesta = await fetch(url);
            const resultado = await respuesta.json();
            datos = resultado.datos;
            mostrarDatos();
        
        } catch (error) {
            console.log(error);
        }
    }

    function mostrarDatos() {
        limpiarDatos();
        // totalPendientes();
        // totalCompletas();

        // const arrayTareas = filtradas.length ? filtradas : tareas;
        if(datos.length === 0) {
            const contenedorDatos = document.querySelector('#listado-datos');
            const textoNoDatos = document.createElement('LI');
            textoNoDatos.textContent = 'No Hay Datos';
            textoNoDatos.classList.add('no-tareas');
            contenedorDatos.appendChild(textoNoDatos);
            return;
        }


        const estados = {
            0: 'Pendiente',
            1: 'Completa'
        }

        datos.forEach(dato => {
            const contenedordato = document.createElement('LI');
            contenedordato.dataset.datoId = dato.id;
            contenedordato.classList.add('tarea');

            const frecuenciaC = document.createElement('P');
            frecuenciaC.textContent = `Frecuencia Cardiaca: ${dato.frecuenciaC}`;
            const frecuenciaR = document.createElement('P');
            frecuenciaR.textContent = `Frecuencia Respiratoria: ${dato.frecuenciaR}`;
            const presionS = document.createElement('P');
            presionS.textContent = `Presion Sanguinea: ${dato.presionS}`;
            const temp = document.createElement('P');
            temp.textContent = `Temperatura: ${dato.tempe}`;
            // nombredato.ondblclick = function() {
            //     mostrarFormulario(editar = true, {...dato});
            // }


            const opcionesDiv = document.createElement('DIV');
            opcionesDiv.classList.add('opciones');

            // Botones
            // const btnEstadodato = document.createElement('BUTTON');
            // btnEstadodato.classList.add('estado-tarea');
            // btnEstadodato.classList.add(`${estados[dato.estado].toLowerCase()}`)
            // btnEstadodato.textContent = estados[dato.estado];
            // btnEstadodato.dataset.estadodato = dato.estado;
            // btnEstadodato.ondblclick = function() {
            //     cambiarEstadoTarea({...dato});
            // }

            const btnEliminardato = document.createElement('BUTTON');
            btnEliminardato.classList.add('eliminar-tarea');
            btnEliminardato.dataset.iddato = dato.id;
            btnEliminardato.textContent = 'Eliminar';
            btnEliminardato.ondblclick = function() {
                confirmarEliminarTarea({...dato});
            }

            // opcionesDiv.appendChild(btnEstadodato);
            opcionesDiv.appendChild(btnEliminardato);

            contenedordato.appendChild(frecuenciaC);
            contenedordato.appendChild(frecuenciaR);
            contenedordato.appendChild(presionS);
            contenedordato.appendChild(temp);
            contenedordato.appendChild(opcionesDiv);

            const listadodato = document.querySelector('#listado-datos');
            listadodato.appendChild(contenedordato);
        });
    }

    // function totalPendientes() {
    //     const totalPendientes = tareas.filter(tarea => tarea.estado === "0");
    //     const pendientesRadio = document.querySelector('#pendientes');

    //     if(totalPendientes.length === 0) {
    //         pendientesRadio.disabled = true;
    //     } else {
    //         pendientesRadio.disabled = false;
    //     }   
    // }

    // function totalCompletas() {
    //     const totalCompletas = tareas.filter(tarea => tarea.estado === "1");
    //     const completasRadio = document.querySelector('#completadas');

    //     if(totalCompletas.length === 0) {
    //         completasRadio.disabled = true;
    //     } else {
    //         completasRadio.disabled = false;
    //     }   
    // }

    function mostrarFormulario( editar = false, tarea = {} ) {
        const modal = document.createElement('DIV');
        modal.classList.add('modal');
        modal.innerHTML = `
            <form class="formulario nueva-tarea">
                <legend>${editar ? 'Editar Datos' : 'Registra Sensores'}</legend>
                <div class="campo">
                    <label for="frecuenciaC">Frecuencia Cardiaca</label>
                    <input 
                        type="number"
                        name="frecuenciaC"
                        placeholder="${tarea.nombre ? 'Edita la Tarea' : 'Añadir Frecuencia Cardiaca a la cria'}"
                        id="frecuenciaC"
                        value="${tarea.nombre ? tarea.nombre : ''}"
                    />
                </div>
                <div class="campo">
                    <label for="frecuenciaR">Frecuencia Respiratoria</label>
                    <input 
                        type="number"
                        name="frecuenciaR"
                        placeholder="Añadir Frecuencia Respiratoria a la cria"
                        id="frecuenciaR"
                        value="${tarea.nombre ? tarea.nombre : ''}"
                    />
                </div>
                <div class="campo">
                    <label for="presionS">Presion Sanguinea</label>
                    <input 
                        type="number"
                        name="presionS"
                        placeholder="Añadir Presion Sanguinea a la cria"
                        id="presionS"
                        value="${tarea.nombre ? tarea.nombre : ''}"
                    />
                </div>
                <div class="campo">
                    <label for="temp">Temperatura</label>
                    <input 
                        type="number"
                        name="temp"
                        placeholder="Añadir Temperatura a la cria"
                        id="temp"
                        value="${tarea.nombre ? tarea.nombre : ''}"
                    />
                </div>
                <div class="opciones">
                    <input 
                        type="submit" 
                        class="submit-nueva-cria" 
                        value="${tarea.nombre ? 'Guardar Cambios' : 'Registrar Datos'} " 
                    />
                    <button type="button" class="cerrar-modal">Cancelar</button>
                </div>
            </form>
        `;

        setTimeout(() => {
            const formulario = document.querySelector('.formulario');
            formulario.classList.add('animar');
        }, 10);

        modal.addEventListener('click', function(e) {
            e.preventDefault();
            if(e.target.classList.contains('cerrar-modal')) {
                const formulario = document.querySelector('.formulario');
                formulario.classList.add('cerrar');
                setTimeout(() => {
                    modal.remove();
                }, 500);
            } 
            if(e.target.classList.contains('submit-nueva-cria')) {
                const frecuenciaC = document.querySelector('#frecuenciaC').value.trim();
                const frecuenciaR = document.querySelector('#frecuenciaR').value.trim();
                const presionS = document.querySelector('#presionS').value.trim();
                const temp = document.querySelector('#temp').value.trim();
                
                if(frecuenciaC === '') {
                    // Mostrar una alerta de error
                    mostrarAlerta('La frecuencia Cardiaca de la cria es obligatoria', 'error', document.querySelector('.formulario legend'));
                    return;
                } else if(frecuenciaR === '') {
                    mostrarAlerta('La frecuencia Respiratoria de la cria es obligatoria', 'error', document.querySelector('.formulario legend'));
                    return;
                } else if(presionS === '') {
                    mostrarAlerta('La presion Sanguinea de la cria es obligatoria', 'error', document.querySelector('.formulario legend'));
                    return;
                } else if(temp === '') {
                    mostrarAlerta('La temperatura de la cria es obligatoria', 'error', document.querySelector('.formulario legend'));
                    return;
                }

                if(editar) {
                    tarea.nombre = nombreTarea;
                    actualizarTarea(tarea);
                } else {
                    agregarTarea(frecuenciaC,frecuenciaR,presionS,temp);
                }
                
            }
        })

        document.querySelector('.dashboard').appendChild(modal);
    }

    // Muestra un mensaje en la interfaz
    function mostrarAlerta(mensaje, tipo, referencia) {
        // Previene la creación de multiples alertas
        const alertaPrevia = document.querySelector('.alerta');
        if(alertaPrevia) {
            alertaPrevia.remove();
        }


        const alerta = document.createElement('DIV');
        alerta.classList.add('alerta', tipo);
        alerta.textContent = mensaje;

        // Inserta la alerta antes del legend
        referencia.parentElement.insertBefore(alerta, referencia.nextElementSibling);

        // Eliminar la alerta después de 5 segundos
        setTimeout(() => {
            alerta.remove();
        }, 5000);
    }

    // Consultar el Servidor para añadir una nueva tarea a la cria actual
    async function agregarTarea(frecuenciaC,frecuenciaR,presionS,temp) {
        // Construir la petición
        const datos = new FormData();
        datos.append('frecuenciaC', frecuenciaC);
        datos.append('frecuenciaR', frecuenciaR);
        datos.append('presionS', presionS);
        datos.append('tempe', temp);       
        datos.append('criaId', obtenerCria());

        try {
            const url = '/api/tarea';
            const respuesta = await fetch(url, {
                method: 'POST',
                body: datos
            });
            const resultado = await respuesta.json();
            mostrarAlerta(
                resultado.mensaje, 
                resultado.tipo, 
                document.querySelector('.formulario legend')
            );
            if(resultado.tipo === 'exito') {
                const modal = document.querySelector('.modal');
                setTimeout(() => {
                    modal.remove();
                }, 3000);

                // Agregar el objeto de registros al global de registros
                const datosObj = {
                    id: String(resultado.id),
                    frecuenciaC: frecuenciaC,
                    frecuenciaR: frecuenciaR,
                    presionS: presionS,
                    tempe: temp,
                    estado: "0",
                    criaId: resultado.criaId
                }
                datos = [...datos, datosObj];
                mostrarDatos();
            }
        } catch (error) {
            console.log(error);
        }
    }

    // function cambiarEstadoTarea(tarea) {
    //     const nuevoEstado = tarea.estado === "1" ? "0" : "1";
    //     tarea.estado = nuevoEstado;
    //     actualizarTarea(tarea);
    // }

    // async function actualizarTarea(tarea) {

    //     const {estado, id, nombre, proyectoId} = tarea;
        
    //     const datos = new FormData();
    //     datos.append('id', id);
    //     datos.append('nombre', nombre);
    //     datos.append('estado', estado);
    //     datos.append('proyectoId', obtenerCria());

    //     try {
    //         const url = 'http://localhost:3000/api/tarea/actualizar';

    //         const respuesta = await fetch(url, {
    //             method: 'POST',
    //             body: datos
    //         });
    //         const resultado = await respuesta.json();

    //         // console.log(resultado);

    //         if(resultado.respuesta.tipo === 'exito') {
    //             Swal.fire(
    //                 resultado.respuesta.mensaje,
    //                 resultado.respuesta.mensaje,
    //                 'success'
    //             );

    //             const modal = document.querySelector('.modal');
    //             if(modal) {
    //                 modal.remove();
    //             }
               
                

    //             tareas = tareas.map(tareaMemoria => {
    //                 if(tareaMemoria.id === id) {
    //                     tareaMemoria.estado = estado;
    //                     tareaMemoria.nombre = nombre;
    //                 } 

    //                 return tareaMemoria;
    //             });

    //             mostrarTareas();
    //         }
    //     } catch (error) {
    //         console.log(error);
    //     }
    // }

    function confirmarEliminarTarea(tarea) {
        Swal.fire({
            title: '¿Eliminar Tarea?',
            showCancelButton: true,
            confirmButtonText: 'Si',
            cancelButtonText: 'No'
        }).then((result) => {
            if (result.isConfirmed) {
                eliminarTarea(tarea);
            } 
        })
    }

    async function eliminarTarea(tarea) {

        const {estado, id, nombre} = tarea;
        
        const datos = new FormData();
        datos.append('id', id);
        datos.append('nombre', nombre);
        datos.append('estado', estado);
        datos.append('proyectoId', obtenerCria());

        try {
            const url = '/api/tarea/eliminar';
            const respuesta = await fetch(url, {
                method: 'POST',
                body: datos
            });

            const resultado = await respuesta.json();
            if(resultado.resultado) {
                // mostrarAlerta(
                //     resultado.mensaje, 
                //     resultado.tipo, 
                //     document.querySelector('.contenedor-nueva-tarea')
                // );

                Swal.fire('Eliminado!', resultado.mensaje, 'success');

                tareas = tareas.filter( tareaMemoria => tareaMemoria.id !== tarea.id);
                mostrarTareas();
            }
            
        } catch (error) {
            
        }
    }

    function obtenerCria() {
        const criaParams = new URLSearchParams(window.location.search);
        const cria = Object.fromEntries(criaParams.entries());
        return cria.id;
    }

    function limpiarDatos() {
        const listadoTareas = document.querySelector('#listado-datos');
        
        while(listadoTareas.firstChild) {
            listadoTareas.removeChild(listadoTareas.firstChild);
        }
    }

})();
