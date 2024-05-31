function inicioResetpassword() {
    document.querySelector("#formResetClave")
        .addEventListener('submit', async (e) => {
            e.preventDefault();
            await guardarRegistro(e)
        })
}

async function guardarRegistro(event) {
    let form = new FormData(event.target)
    if ( validarCamposVacios()) {
        let data = await utilExeFetch(path_crud, form)
        if (data.error > 0) {
            customAlert(data.type, data.mensaje, 3000, 'toast-top-center', "Mensaje sistema");
            setTimeout(() => {
                location.href = '/dashboard/index'
            }, 5000)

        }
    }

}

const validarCamposVacios = () => {
    const oldClave = document.querySelector("#oldClave");
    const newClave = document.querySelector("#newClave");
    const repitClave = document.querySelector("#repitClave");

    if (oldClave.value === "") {
        customAlert('warning', "La Clave anterior no puede estar vacio", 3000, "toast-top-center", 'Mensaje del sistema');
        return false;
    }

    if (newClave.value === "") {
        customAlert('warning', "La nueva contraseña no puede estar vacio", 3000, "toast-top-center", 'Mensaje del sistema');
        return false;
    }

    if (repitClave.value === "") {
        customAlert('warning', "El Campo confirmar contraseña no puede estar vacio", 3000, "toast-top-center", 'Mensaje del sistema');
        return false;
    }


    if (newClave.value !== repitClave.value) {
        customAlert('warning', "Las contraseñas no coinciden", 3000, "toast-top-center", 'Mensaje del sistema');
        return false;
    }
    return true;
}