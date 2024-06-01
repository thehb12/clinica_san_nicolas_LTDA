var cacheSlt = {};


function utilLoad() {
    config_buscar();
}

const config_buscar = () => {
    const buscaruta = $('#buscaruta');
    buscaruta.autocomplete({
        minLength: 2,
        source: fixUrl() + 'autocomplete/Modulos',
        select: (event, ui) => {
            const path = ui.item.id;
            buscaruta.get(0).name = path;
            (path) && (location.href = location.origin + path);
            customAlert('error', 'El path del modulo no esta configurado', 3000, 'toast-top-center', "Mensaje sistema");
        }
    });
}

async function ComboDependienteDeOtroCombo(idLista, rutaCombo, idInicial, nmParametro, valorParametro) {
    let UR = fixUrl() + 'combos/';
    let parametros = "?" + nmParametro + "=" + valorParametro;
    let url = UR + rutaCombo + parametros;
    await genericCombo(url, idLista, idInicial, parametros);
}

async function ComboDependiente(idLista, rutaCombo, datoInicial, idInicial) {
    let url = fixUrl() + 'combos/' + rutaCombo;
    await genericCombo(url, idLista, idInicial);
}

const genericCombo = async (url, idLista, idInicial) => {
    let lista = document.querySelector('#' + idLista);
    lista.options.length = 0;
    lista.options[0] = new Option("Cargando opciones" + "...", '');
    if (typeof cacheSlt[url] === 'undefined') {
        cacheSlt[url] = await utilExeFetchJson(url, {});
    }
    lista.options.length = 0;
    lista.options[0] = new Option("Seleccionar opción", '');
    for (const [index, option] of cacheSlt[url].entries()) {
        lista.options[index + 1] = new Option(option.name, option.id);
    }
    (idInicial !== "" || idInicial !== null) && $("#" + idLista).val(idInicial);
}

const fixUrl = () => {
    let path = location.pathname.split('/')
    if (path.length === 1) {
        return "/";
    }
    let fix = "";
    for (let i = 0; i <= path.length - 2; i++) {
        fix += "../"
    }
    return fix;
}

async function utilExeFetchJson(url, datos) {
    try {
        let response = await fetch(url, {
            method: 'POST',
            body: JSON.stringify(datos),
            headers: {contentType: 'application/json'}
        });
        return await response.json();
    } catch (e) {
        console.error(e);
        customAlert("error", "Se ha presentado un error al realizar la solicitud", 3000, "toast-top-left", "Mensaje sistema");
        return false;
    }
}

async function utilExeFetch(url, datos = {}, log = false) {
    try {
        let response = await fetch(url, {
            method: 'POST',
            body: datos
        });

        if (log) {
            let debug = await response.json();
            console.log(debug)
            return debug
        }
        return await response.json();
    } catch (e) {
        customAlert("error", "Se ha presentado un error al realizar la solicitud", 3000, "toast-top-left", "Mensaje sistema");
        return false;
    } finally {
        // modal_load.hide()
    }
}


const formatt_campo_title_boostrap_table = (data = {}, total = false, debug = false) => {
    let campos = {}
    switch (data.type) {
        case 'id':
            let footerTotal = {};
            if (total) {
                footerTotal = {
                    footerFormatter: totalTextFormatter
                }
            }
            return {
                title: 'ID',
                field: 'id',
                align: 'center',
                valign: 'middle',
                sortable: true,
                ...footerTotal
            }
        case 'relation':
            campos.field = 'id_' + data.name;
            debug && (campos.title = 'id_' + data.name);
            campos.visible = debug
            return campos;
        case 'text':
            campos = {
                title: data.name.replace(/_/g, ' ').toUpperCase(),
                field: 'name_' + data.name,
                align: 'center',
                valign: 'middle',
                sortable: true
            }
            debug && (campos.title = 'name_' + data.name);
            return campos
        case 'operate':
            return {
                title: data.name.toUpperCase(),
                field: 'operate',
                align: 'center',
                valign: 'middle',
                clickToSelect: false,
                events: data.events,
                formatter: data.formatter

            }
        case 'totalTextFormatter':
        case 'totalCountFormatter':
        case 'totalSumaFormatter':
        case 'totalPromedioFormatter':
            let formatter = {footerFormatter: totalTextFormatter}
            if (data.type === 'totalCountFormatter') {
                formatter = {footerFormatter: totalCountFormatter}
            }
            if (data.type === 'totalSumaFormatter') {
                formatter = {footerFormatter: totalSumaFormatter}
            }
            if (data.type === 'totalPromedioFormatter') {
                formatter = {footerFormatter: totalPromedioFormatter}
            }
            campos = {
                title: data.name.replace(/_/g, ' ').toUpperCase(),
                field: 'name_' + data.name,
                align: 'center',
                valign: 'middle',
                sortable: true,
                ...formatter
            }
            debug && (campos.title = 'name_' + data.name);
            return campos
        case 'state':
            return {
                field: 'state',
                checkbox: true,
                align: 'center',
                valign: 'middle'
            }

    }
}


function totalTextFormatter() {
    return 'Total'
}

function totalCountFormatter(data) {
    return data.length
}

function totalSumaFormatter(data) {
    return data.map(row => +row[this.field]).reduce((sum, i) => sum + i, 0);
}

function totalPromedioFormatter(data) {
    let resul = data.map(row => +row[this.field]).reduce((sum, i) => sum + i, 0) / data.length;
    return resul.toFixed(1)
}


const crate_table_boostrap_table = (idTabla, spacific_config, custom_config = {}) => {
    const config = config_boostrap_table_generic(custom_config, spacific_config);
    return crate_table_boostrap_table_generic(idTabla, config);
}

const crate_table_boostrap_table_pagination = (idTabla, spacific_config) => {
    const custom_config = {
        pagination: true,
        pageSize: 15,
        pageList: [30, 50, 100, 'ALL'],
        method: 'post',
        sidePagination: 'server',
        ajax: spacific_config.ajax,
    }
    const config = config_boostrap_table_generic(custom_config, spacific_config);
    return crate_table_boostrap_table_generic(idTabla, config);
}

const config_boostrap_table_generic = (custom_config, spacific_config) => {
    let config = {
        height: 'auto',
        locale: "es-ES",
        uniqueId: "id",
        advancedSearch: true,
        advancedSearchIcon: 'fa fa-filter',
        idTable: "advancedTable",
        search: true,
        showColumns: true,
        showExport: true,
        exportDataType: 'selected',
        exportTypes: ['pdf', 'excel'],
        buttonsAlign: 'left'
    }

    for (const item in spacific_config) {
        config[item] = spacific_config[item];
    }

    for (const item in custom_config) {
        config[item] = custom_config[item];
    }
    return config;
}

const crate_table_boostrap_table_generic = (idTabla, config) => {
    let table_ = $('#' + idTabla)
    table_.bootstrapTable('destroy').bootstrapTable(config)
    return table_;
}


const ajaxRequestPaginador = async (ruta, params) => {
    const parameters = JSON.parse(params);
    let form = new FormData()
    form.append('search', parameters.search === '' ? null : parameters.search)
    form.append('offset', parameters.offset)
    form.append('limit', parameters.limit === undefined ? null : parameters.limit)
    form.append('filter', parameters.filter === undefined ? null : parameters.filter)
    form.append('sort', parameters.sort === undefined ? null : parameters.sort)
    form.append('order', parameters.order === undefined ? null : parameters.order)

    return await utilExeFetch(ruta, form)

}


function customAlert(tipo, mensaje, duracion, posicionCss, titulo) {

    console.log(tipo, mensaje, duracion, posicionCss, titulo)
    setTimeout(function () {
        toastr.options.positionClass = posicionCss;
        toastr.options.closeButton = true;
        toastr.options.allowHtml = true;
        toastr.options.progressBar = true;
        toastr.options.showMethod = 'slideDown';
        toastr.options.timeOut = duracion;
        toastr[tipo](mensaje, titulo);
    }, 1000);
}

const confirmar = (accion, mensaje = 'Esta seguro que desea eliminar el registro?') => {
    $.confirm({
        title: "Eliminar",
        content: mensaje,
        buttons: {
            confirm: {
                text: "Aceptar",
                btnClass: 'btn-primary',
                action: accion
            },
            cancel: {
                text: "Cancelar",
                btnClass: 'btn-danger',
                action: () => {
                }
            }
        }
    });
}

let abecedario = ['a', 'b', 'c', 'd', 'e', 'f', 'g', 'h', 'i', 'j', 'k', 'l', 'm', 'n', 'ñ', 'o',
    'p', 'q', 'r', 's', 't', 'u', 'v', 'w', 'x', 'y', 'z', '0', '1', '2', '3', '4', '5', '6', '7',
    '8', '9'];

function codigoAleatorio() {
    let cd = '';
    for (i = 1; i <= 10; i++) {
        cd += abecedario[(Math.random() * (abecedario.length - 1)).toFixed(0)];
    }
    return cd;
}

const getIdSelections = (_tabla) => {
    return $.map(_tabla.bootstrapTable('getSelections'), (row) => {
        return row.id
    })
}

function listasModalAuto(campo, ruta, appendTo = ".form-autocompleted") {
    campo = $(campo)
    campo.autocomplete({
        minLength: 2,
        source: fixUrl() + 'autocomplete/' + ruta,
        select: (event, ui) => {
            campo.get(0).dataset.value = ui.item.id;
        },
        appendTo: appendTo
    });
}

function listasAutoc(campo, ruta) {
    $(campo).autocomplete({
        minLength: 2,
        source: fixUrl() + 'autocomplete/' + ruta,
        select: function (event, ui) {
            $(campo).get(0).name = ui.item.id;
        }
    });
}

const isPermisoLectura = () => {
    return document.querySelector('#l').value > 0;
}
const isPermisoEscritura = () => {
    return document.querySelector('#e').value > 0;
}
const isPermisoBorrar = () => {
    return document.querySelector('#d').value > 0;
}
const isPermisoActualizar = () => {
    return document.querySelector('#u').value > 0;
}

function fInFiMes() {
    var date = new Date();
    var f1 = new Date(date.getFullYear(), date.getMonth(), 1);
    var f2 = new Date(date.getFullYear(), date.getMonth() + 1, 0);
    var f11 = f1.getFullYear() + "-" + (((f1.getMonth() + 1) > 9) ? (f1.getMonth() + 1) : "0" + (f1.getMonth() + 1)) + "-0" + f1.getDate();
    var f22 = f2.getFullYear() + "-" + (((f2.getMonth() + 1) > 9) ? (f2.getMonth() + 1) : "0" + (f2.getMonth() + 1)) + "-" + f2.getDate();
    return [f11, f22];
}

const fechaAcctual = () => {
    let date = new Date();
    return String(date.getDate()).padStart(2, '0') + '/' + String(date.getMonth() + 1).padStart(2, '0') + '/' + date.getFullYear();
}

const validarTamanioYTipoFoto = (inputFileId, maxSizeInBytes) => {
    const fileInput = document.querySelector(`#${inputFileId}`);

    if (!fileInput) {
        console.error(`Elemento con ID ${inputFileId} no encontrado.`);
        return;
    }

    fileInput.addEventListener("change", (e) => {
        const file = e.target.files[0];

        if (!file) {
            return; // No hay archivo seleccionado
        }

        const fileSize = file.size;

        // Validar tipo de archivo (solo imágenes)
        const allowedImageTypes = ["image/jpeg", "image/png", "image/gif"];
        if (!allowedImageTypes.includes(file.type)) {
            fileInput.value = "";
            customAlert('info', 'Por favor, selecciona un archivo de imagen válido (JPEG, PNG, GIF)', 3000, 'toast-top-center', "Mensaje sistema");
            return;
        }

        if (fileSize > maxSizeInBytes) {
            fileInput.value = "";
            customAlert('info', `El tamaño de la foto excede el permitido (${maxSizeInBytes / (1024 * 1024)} MB)`, 3000, 'toast-top-center', "Mensaje sistema");
        }
    });
};

