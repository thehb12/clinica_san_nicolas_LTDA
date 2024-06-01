// Función genérica para agregar eventos a elementos del formulario
const addValidationEvents = (formName, selector, validationFunction) => {
    const form = document.getElementById(formName);

    if (form) {
        const elements = form.querySelectorAll(selector);
        elements.forEach((element) => {
            element.addEventListener('keyup', validationFunction);
            element.addEventListener('blur', validationFunction);
        });
    } else {
        console.error(`Formulario con ID '${formName}' no encontrado.`);
    }
}

const camposConErrores = new Set();
const validarCampo = (campo, valor, expresion, mensajeValido, mensajeInvalido) => {
    const mensaje = document.getElementById(`${campo}Mensaje`);
    const clase = expresion.test(valor) ? 'valid-feedback' : 'invalid-feedback';
    const textoMensaje = expresion.test(valor) ? mensajeValido : mensajeInvalido;

    if (mensaje !== null) {
        mensaje.classList.remove(...mensaje.classList);
        mensaje.classList.add(clase);
        mensaje.innerText = textoMensaje;
        mensaje.style.display = valor.trim() !== '' ? 'block' : 'none'; // Ocultar si el valor está vacío
    }

    if (valor.trim() === '') {
        camposConErrores.delete(campo);
        return true;
    }

    if (!expresion.test(valor)) {
        if (!camposConErrores.has(campo)) {
            customAlert('error', `Error ${campo}: ${mensajeInvalido}`, 3000, 'toast-top-center', 'Mensaje del sistema');
            camposConErrores.add(campo);
        }
        return false;
    } else {
        camposConErrores.delete(campo);
    }

    return true;
};

const validacion = (e) => {
    let name = e.target.name;
    let valor = e.target.value.trim();

    console.log(name)

    if (valor === '') {
        const mensaje = document.getElementById(`${name}Mensaje`);
        if (mensaje !== null) {
            mensaje.style.display = 'none';
        }
        return;
    }
    if (valor === '') return;

    switch (name) {
        case "empresa":
            validarCampo(name, valor, expresiones.cualquierTexto, 'Empresa insertado correctamente.', 'La empresa tiene que ser de 1 a 50  de texto y caracteres.');
            break;

        case "nit":
            validarCampo(name, valor, expresiones.cualquierTexto, 'NIT insertado correctamente.', 'El nit tiene que ser de 1 a 50  de texto y caracteres.');
            break;

        case "dni":
            validarCampo(name, valor, expresiones.usuario, 'NIT insertado correctamente.', 'El dni tiene que ser de 4 a 16 números, letras, números, puntos, guiones y guion bajo.');
            break;

        case "cedula":
            validarCampo(name, valor, expresiones.numeros, 'Cédula insertado correctamente.', 'La cédula tiene que ser de 7 a 14 números.');
            break;

        case "username":
            validarCampo(name, valor, expresiones.usuario, 'Usuario insertado correctamente.', 'El usuario tiene que ser de 4 a 16 números, letras, números, puntos, guiones y guion bajo.');
            break;

        case "codigo":
            validarCampo(name, valor, expresiones.cualquierTexto, 'Código insertado correctamente.', 'El código tiene que ser de 1 a 40 Letras y espacios, pueden llevar acentos.');
            break;

        case "contrasena":
            validarCampo(name, valor, expresiones.password, 'Contraseña insertada correctamente.', 'La contraseña debe tener entre 4 y 12 dígitos.');
            break;

        case "confirmar_contrasena":
            validarCampo(name, valor, expresiones.password, 'Contraseña confirmada correctamente.', 'La contraseña debe tener entre 4 y 12 dígitos.');
            break;

        case "nombre":
            validarCampo(name, valor, expresiones.cualquierTexto, 'Nombre insertado correctamente.', 'El nombre debe tener entre 1 y 40 letras y espacios, pueden llevar acentos.');
            break;

        case "correo":
            validarCampo(name, valor, expresiones.correo, 'Correo insertado correctamente.', 'El correo solo puede contener letras, números, puntos, guiones y guion bajo.');
            break;

        case "telefono":
            validarCampo(name, valor, expresiones.numeros, 'Teléfono insertado correctamente.', 'El teléfono debe tener entre 7 y 14 números.');
            break;

        case "direccion":
            validarCampo(name, valor, expresiones.cualquierTexto, 'Dirección insertada correctamente.', 'La dirección debe tener entre 1 y 40 letras y espacios, pueden llevar acentos.');
            break;

        case "precio_compra":
            validarCampo(name, valor, expresiones.cualquierTexto, 'Precio de compra insertado correctamente.', 'Ingrese un valor válido.');
            break;

        case "precio_venta":
            validarCampo(name, valor, expresiones.cualquierTexto, 'Precio de venta insertado correctamente.', 'Ingrese un valor válido.');
            break;

        case "email":
            validarCampo(name, valor, expresiones.correo, 'Correo insertado correctamente.', 'El correo solo puede contener letras, números, puntos, guiones y guion bajo.');
            break;
        case "razon_social":
            validarCampo(name, valor, expresiones.cualquierTexto, 'Razon Social insertado correctamente.', 'El correo solo puede contener letras, números, puntos, guiones y guion bajo.');
            break;
        case "cantidad":
            validarCampo(name, valor, expresiones.numerosDecimales, 'Cantidad insertado correctamente.', 'Ingrese un valor válido para la cantidad.');
            break;

        case "proveedor":
            validarCampo(name, valor, expresiones.cualquierTexto, 'Proveedor insertado correctamente.', 'Ingrese un valor válido para el proveedor.');
            break;

        case "medida":
            validarCampo(name, valor, expresiones.cualquierTexto, 'Medida insertado correctamente.', 'Ingrese un valor válido para la medida.');
            break;

        case "categoria":
            validarCampo(name, valor, expresiones.cualquierTexto, 'Categoría insertado correctamente.', 'Ingrese un valor válido para la categoría.');
            break;

        case "estado":
            validarCampo(name, valor, expresiones.cualquierTexto, 'Estado insertado correctamente.', 'Ingrese un valor válido para el estado.');
            break;

        case "tipo_cliente":
            validarCampo(name, valor, expresiones.textosLargos, 'Tipo Cliente insertado correctamente.', 'Ingrese un valor válido para el tipo de cliente.');
            break;

        case "razon_baja":
            validarCampo(name, valor, expresiones.usuario, 'Tipo Cliente insertado correctamente.', 'Ingrese un valor válido para la razón de baja.');
            break;

        case "agregar_cantidad":
            validarCampo(name, valor, expresiones.numerosLargos, 'Cantidad insertado correctamente.', 'La cantidad debe ser de 1 a 50 números.');
            break;

        case "quitar_cantidad":
            validarCampo(name, valor, expresiones.numerosLargos, 'Cantidad insertado correctamente.', 'La cantidad debe ser de 1 a 50 números.');
            break;

        case "importe":
            validarCampo(name, valor, expresiones.cualquierTexto, 'Importe insertado correctamente.', 'Ingrese un valor válido para el importe.');
            break;

        case "oldClave":
            validarCampo(name, valor, expresiones.password, 'Clave anterior insertado correctamente.', 'La clave anterior debe tener de 4 a 12 dígitos.');
            break;

        case "newClave":
            validarCampo(name, valor, expresiones.password, 'Nueva contraseña insertado correctamente.', 'La nueva contraseña debe tener de 4 a 12 dígitos.');
            break;

        case "repitClave":
            validarCampo(name, valor, expresiones.password, 'Confirmar contraseña insertado correctamente.', 'La contraseña debe tener de 4 a 12 dígitos.');
            break;

        case "genero":
            validarCampo(name, valor, expresiones.cualquierTexto, 'Genero insertado correctamente.', 'Ingrese un valor válido para el estado.');
            break;

        case "rh":
            validarCampo(name, valor, expresiones.cualquierTexto, 'RH insertado correctamente.', 'Ingrese un valor válido para el estado.');
            break;

        case "estado_civil":
            validarCampo(name, valor, expresiones.cualquierTexto, 'Estado civil insertado correctamente.', 'Ingrese un valor válido para el estado.');
            break;

        case "monto_inicial":
            validarCampo(name, valor, expresiones.cualquierTexto, 'Monto Inicial insertado correctamente.', 'Ingrese un valor válido para el Monto Inicial.');
            break;

        case "monto_entregado":
            validarCampo(name, valor, expresiones.cualquierTexto, 'Monto Entregado insertado correctamente.', 'Ingrese un valor válido para el Monto Entregado.');
            break;

        default:
            break;
    }
};


const expresiones = {
    cualquierTexto: /^[\s\S]{1,50}$/, // Cualquier tipo de texto y caracteres, de 1 a 50 caracteres.
    usuario: /^[a-zA-Z0-9_\-]{4,16}$/, // Letras, numeros, guion y guion_bajo
    textos: /^[a-zA-ZÀ-ÿ\s]{1,50}$/, // Letras y espacios, pueden llevar acentos. Ampliado a 50 caracteres.
    password: /^.{4,12}$/, // 4 a 12 caracteres.
    correo: /^[a-zA-Z0-9_.+-]+@[a-zA-Z0-9-]+\.[a-zA-Z0-9-.]+$/, // Correo electrónico válido
    direccion: /^[A-Za-z][A-Za-z0-9@#%&*]*$/, // Dirección alfanumérica permitiendo algunos caracteres especiales al inicio
    numeros: /^\d{7,14}$/, // 7 a 14 dígitos numéricos
    telefono: /^\d{10,15}$/, // Número de teléfono de 10 a 15 dígitos
    fecha: /^\d{4}-(0[1-9]|1[0-2])-(0[1-9]|[12][0-9]|3[01])$/, // Fecha en formato YYYY-MM-DD
    url: /^(ftp|http|https):\/\/[^ "]+$/, // URL válida
    hexColor: /^#([0-9A-Fa-f]{3}){1,2}$/, // Color hexadecimal válido
    tarjetaCredito: /^\d{4}-\d{4}-\d{4}-\d{4}$/, // Número de tarjeta de crédito en formato XXXX-XXXX-XXXX-XXXX
    codigoPostal: /^\d{5}(-\d{4})?$/, // Código postal en formato válido (opcional - extensión)
    textosLargos: /^[a-zA-ZÀ-ÿ\s]{1,50}$/, // Letras y espacios, pueden llevar acentos. Ampliado a 50 caracteres.
    numerosLargos: /^\d{1,50}$/, // De 1 a 50 dígitos numéricos.
    numerosDecimales: /^(\d*\.)?\d+$/ //Números decimales
}