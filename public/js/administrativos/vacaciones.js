let contadorTeclas = 0;

const inicio = async () => {
    await listasAutoc('#cedula', 'nombre_usuario');
    document.querySelector("#cedula").focus()

}

const buscarVacaciones = async (e) => {
    e.preventDefault(); // Prevenir el envío del formulario por defecto

    contadorTeclas++;

    // Limpiar el valor del campo de entrada y permitir solo números
    e.target.querySelector("#cedula").value = e.target.querySelector("#cedula").value.replace(/[^0-9]/g, '');

    // Verificar si el campo de entrada contiene al menos 7 números
    if (e.target.querySelector("#cedula").value.length > 7 && contadorTeclas > 10) {
        // Mostrar una alerta personalizada si se cumplen las condiciones
        customAlert('info', 'Se han ingresado al menos 7 números después de 10 pulsaciones de teclas.', 2000, 'toast-top-center', 'Mensaje del sistema');
    }

    // Continuar con el proceso de búsqueda solo si hay texto en el campo
    if (e.target.querySelector("#cedula").value.trim() === "") {
        return;
    }

    const cedula = e.target.querySelector("#cedula").value;
    let forma = new FormData();
    forma.append('cedula', cedula);
    if (validarCampoCodigo()) {
        let data = await utilExeFetch('/administrativos/vacaciones/obtener_cedula', forma);
        if (data && data.length > 0) {
            ResponseCosultaCodigo(data);
        }else{
            Swal.fire({
                title: 'No se encontraron datos disponibles.',
                icon: 'success',
                confirmButtonText: 'Cerrar'
            });
        }
    }
}


const validarCampoCodigo = () => {
    let buscar = document.querySelector("#cedula");

    if (buscar.value === "") {
        customAlert('warning', "El campo buscar no puede estar vacio", 2000, "toast-top-center", 'Mensaje del sistema');
        return false;
    }
    return true;
}


const ResponseCosultaCodigo = (data) => {
    const tablaUsuarios = document.getElementById('tabla-usuarios');
    const tablaDatos = document.getElementById('tabla-datos');

    // Limpiar la tabla de datos
    tablaDatos.innerHTML = '';

    // Verificar si hay datos
    if (data.length > 0) {
        // Mostrar la tabla
        tablaUsuarios.classList.remove('d-none');

        // Crear una fila para cada dato
        data.forEach(usuario => {
            const fila = document.createElement('tr');
            fila.innerHTML = `
                <td>${usuario.id}</td>
                <td>${usuario.nombres}</td>
                <td>${usuario.email}</td>
                <td>${usuario.numero_id}</td>
                <td>
                    <button class="btn btn-primary" onclick="abrirEnlace(${usuario.id})">Abrir PDF</button>
                </td>
            `;
            tablaDatos.appendChild(fila);
        });
    } else {
        // Ocultar la tabla si no hay datos
        tablaUsuarios.classList.add('d-none');
    }
};

const abrirEnlace = (id) => {
    window.open(`/administrativos/vacaciones/generar_pdf/${id}`);
};
