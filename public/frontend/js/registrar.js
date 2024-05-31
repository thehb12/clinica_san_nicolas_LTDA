async function guardarFormRegistrar(e) {
    e.preventDefault();
    const nombre = document.querySelector("#nombre").value;
    const correo = document.querySelector("#correo").value;
    const direccion = document.querySelector("#direccion").value;
    const telefono = document.querySelector("#telefono").value;
    const contrasena = document.querySelector("#contrasena").value;
    const confirmar_contrasena = document.querySelector("#confirmar_contrasena").value;
    const codval = document.querySelector("#codval").value;
    const forma = new FormData();
    forma.append('nombre', nombre);
    forma.append('correo', correo);
    forma.append('direccion', direccion);
    forma.append('telefono', telefono);
    forma.append('contrasena', contrasena);
    forma.append('confirmar_contrasena', confirmar_contrasena);
    forma.append('codval', codval);
    if (validarCamposVacios()) {
        const data = await utilExeFetch('/crud', forma);
        customAlert(data.type, data.mensaje, 3000, 'toast-top-center', "Mensaje sistema");
        if (data.error === 34) {
            setTimeout(() => {
                location.href = '/'
            }, 5000)
        }
    }

}

function validarCamposVacios() {

    const nombre = document.querySelector("#nombre");
    const telefono = document.querySelector("#telefono");
    const correo = document.querySelector("#correo");
    const direccion = document.querySelector("#direccion");
    const contrasena = document.querySelector("#contrasena");
    const confirmar_contrasena = document.querySelector("#confirmar_contrasena");
    const codval = document.querySelector("#codval");

    if (nombre.value === "") {
        customAlert('warning', "El campo nombre no puede estar vacio", 2000, "toast-top-center", 'Mensaje del sistema');
        return false;
    }

    if (correo.value === "") {
        customAlert('warning', "El campo correo no puede estar vacio", 2000, "toast-top-center", 'Mensaje del sistema');
        return false;
    }
    if (telefono.value === "") {
        customAlert('warning', "El campo telefono no puede estar vacio", 2000, "toast-top-center", 'Mensaje del sistema');
        return false;
    }
    if (direccion.value === "") {
        customAlert('warning', "El campo direccion no puede estar vacio", 2000, "toast-top-center", 'Mensaje del sistema');
        return false;
    }

    if (contrasena.value === "") {
        customAlert('warning', "El campo contrasena no puede estar vacio", 2000, "toast-top-center", 'Mensaje del sistema');
        return false;
    }
    if (confirmar_contrasena.value === "") {
        customAlert('warning', "El campo confirmar_contrasena no puede estar vacio", 2000, "toast-top-center", 'Mensaje del sistema');
        return false;
    }

    if (codval.value === "") {
        customAlert('warning', "El campo codigo validacion no puede estar vacio", 2000, "toast-top-center", 'Mensaje del sistema');
        return false;
    }

    return true;
}