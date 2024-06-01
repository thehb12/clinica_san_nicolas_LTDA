const inicioPerfil = async () => {
    let data = await utilExeFetch(ListarPerfil)
    if (data.length > 0) {
        var row = data[0];
        document.querySelector('#id').value = row.id;
        document.querySelector('#nombre').value = row.name_nombres;
        document.querySelector('#correo').value = row.name_email;
        document.querySelector('#telefono').value = row.name_telefono;
        document.querySelector('#direccion').value = row.name_direccion;
        row.name_foto_formulario === null ? document.querySelector("#imagen_trabajador").src = path_foto_default : document.querySelector("#imagen_trabajador").src = row.name_foto_formulario;
    }
    validarTamanioYTipoFoto("foto", 2097152);
}
async function guardarRegistro(e) {
    e.preventDefault();
    const id = document.querySelector("#id").value;
    const nombre = document.querySelector("#nombre").value;
    const telefono = document.querySelector("#telefono").value;
    const direccion = document.querySelector("#direccion").value;
    const correo = document.querySelector("#correo").value;
    const foto = document.querySelector("#foto").files;
    const forma = new FormData();
    forma.append('id', id);
    forma.append('nombre', nombre);
    forma.append('correo', correo);
    forma.append('telefono', telefono);
    forma.append('direccion', direccion);
    forma.append('foto', foto[0]);
    if (validarCamposFormPerfil()) {
        const data = await utilExeFetch(path_crud, forma)
        if (data.error === 42) {
            customAlert(data.type, data.mensaje, 3000, 'toast-top-center', "Mensaje sistema");
            setTimeout(() => {
                location.href = path_redirect
            }, 5000)
        }
    }
}

function validarCamposFormPerfil() {
    let nombre = document.querySelector("#nombre");
    let correo = document.querySelector("#correo");
    let telefono = document.querySelector("#telefono");
    let direccion = document.querySelector("#direccion");

    if (nombre.value === "") {
        customAlert('warning', "El campo nombre no puede estar vacio", 2000, "toast-top-center", 'Mensaje del sistema');
        return false;
    }
    if (correo.value === "") {
        customAlert('warning', "El campo correo no puede estar vacio", 2000, "toast-top-center", 'Mensaje del sistema');
        return false;
    }
    if (telefono.value === "") {
        customAlert('warning', "El campo teléfono no puede estar vacio", 2000, "toast-top-center", 'Mensaje del sistema');
        return false;
    }
    if (direccion.value === "") {
        customAlert('warning', "El campo dirección no puede estar vacio", 2000, "toast-top-center", 'Mensaje del sistema');
        return false;
    }
    return true;
}