//Variable Globales
let M_;
let modalTrabajador;

//Inicio de sistema JavaScript
const inicioCrud_trabajadores = async () => {
    modalTrabajador = new bootstrap.Modal("#modal_trabajador", {backdrop: 'static'})
    document.querySelector("#modal_trabajador").addEventListener('hidden.bs.modal', () => {
        const formTrabajador = document.querySelector("#trabajadores_form");
        document.querySelector("#id").value = 0;
        document.querySelector("#estado_accion").classList.remove('bg-success', 'bg-danger');
        document.querySelector("#btn_reset_form").disabled = false;
        document.querySelector("#btn_guardar_form").classList.remove('btn-outline-success');
        document.querySelector("#btn_guardar_form").classList.remove('btn-outline-secondary');
        formTrabajador.reset()
        formTrabajador.classList.remove('was-validated');
    })

    validarTamanioYTipoFoto("foto", 2097152);
}


//Datos para Crear la tabla
const inicioTrabajadores = async () => {
    const M_ = {
        qs: name => document.querySelector(name),
        server: utilExeFetch,
        serverPaginador: ajaxRequestPaginador,
        name_remove_all_trabajadores: '#btn_remove_all_trabajadores',
        name_tabla_trabajadores: 'table_trabajadores',
        name_toolbar_tabla: '#toolbar_trabajadores',
        tabla_trabajadores: null
    }
    return {
        ...M_,
        borrarTrabajador: async data => M_.server('/administrativos/trabajadores/delete', data),
        borrarTrabajadores: async data => M_.server('/administrativos/trabajadores/deletes', data),
    };
}

//lista de la base datos
const ajaxRequest = async (params) => {
    let form = new FormData()
    let response = await utilExeFetch('/administrativos/trabajadores/paginacion', form);
    responseHandler(response)
    params.success(response)
}

//tabla compuesta por la base de datos
const initTabla_trabajadores = async () => {
    M_ = await inicioTrabajadores();
    let spacific_config = {
        ajax: ajaxRequest,
        columns: [
            formatt_campo_title_boostrap_table({type: 'state'}),
            formatt_campo_title_boostrap_table({type: 'id'}),
            formatt_campo_title_boostrap_table({type: 'text', name: 'nombres'}),
            formatt_campo_title_boostrap_table({type: 'text', name: 'email'}),
            formatt_campo_title_boostrap_table({type: 'text', name: 'direccion'}),
            formatt_campo_title_boostrap_table({type: 'text', name: 'telefono'}),
            formatt_campo_title_boostrap_table({type: 'text', name: 'tipo_documento'}),
            formatt_campo_title_boostrap_table({type: 'text', name: 'numero_id'}),
            formatt_campo_title_boostrap_table({type: 'text', name: 'cargo'}),
            formatt_campo_title_boostrap_table({type: 'text', name: 'lugar_expedicion'}),
            formatt_campo_title_boostrap_table({type: 'text', name: 'fecha_inicial'}),
            formatt_campo_title_boostrap_table({type: 'text', name: 'fecha_final'}),
            formatt_campo_title_boostrap_table({type: 'text', name: 'saldo'}),
            formatt_campo_title_boostrap_table({type: 'text', name: 'auxilio_transporte'}),
            formatt_campo_title_boostrap_table({type: 'relation', name: 'estado'}),
            formatt_campo_title_boostrap_table({type: 'text', name: 'estado'}),
            formatt_campo_title_boostrap_table({
                type: 'operate',
                name: 'operate',
                events: window.operateEvents,
                formatter: btns_formatter
            })],
        toolbar: M_.name_toolbar_tabla,
        buttons: btn_nuevo_trabajador,
    }
    M_.tabla_trabajadores = crate_table_boostrap_table(M_.name_tabla_trabajadores, spacific_config, {
        showFooter: true,
        pagination: true,
        buttonsClass: "primary",
        pageSize: 30,
        pageList: [30, 50, 100, 'ALL'],
        showRefresh: true
    })
    M_.tabla_trabajadores.on('check.bs.table uncheck.bs.table check-all.bs.table uncheck-all.bs.table', () => {
        M_.qs(M_.name_remove_all_trabajadores).disabled = !getIdSelections(M_.tabla_trabajadores).length
    })

}

function responseHandler(res) {
    return res.rows
}

//Botón Editar
window.operateEvents = {
    'click .editar': async (e, value, row, index) => {
        document.querySelector("#id").value = row.id;
        document.querySelector("#nombres").value = row.name_nombres;
        document.querySelector("#email").value = row.name_email;
        document.querySelector("#direccion").value = row.name_direccion;
        document.querySelector("#tipo").value = row.name_tipo_documento;
        document.querySelector("#telefono").value = row.name_telefono;
        document.querySelector("#numero_id").value = row.name_numero_id;
        document.querySelector("#lugar_expedicion").value = row.name_lugar_expedicion;
        document.querySelector("#cargo").value = row.name_cargo;
        document.querySelector("#fecha_inicial").value = row.name_fecha_inicial;
        document.querySelector("#fecha_final").value = row.name_fecha_final;
        document.querySelector("#saldo").value = row.name_saldo;
        document.querySelector("#auxt").value = row.name_auxilio_transporte;
        row.name_foto_formulario === null ? document.querySelector("#imagen_trabajador").src = path_foto_default : document.querySelector("#imagen_trabajador").src = row.name_foto_formulario;
        document.querySelector("#estado").value = row.id_estado;
        document.querySelector("#estado_accion").classList.add('bg-primary');
        document.querySelector("#btn_guardar_form").classList.add('btn-outline-primary');
        document.querySelector("#btn_reset_form").disabled = true;
        modalTrabajador.show();

    },
//Botón Borrar
    'click .remover': async (e, value, row, index) => {
        const accion = async () => {
            let data = new FormData()
            data.append('id', row.id)
            let response = await M_.borrarTrabajador(data);
            M_.tabla_trabajadores.bootstrapTable('refresh');
            customAlert(response.type, response.mensaje, 3000, 'toast-top-center', "Mensaje sistema");

        }
        confirmar(accion);
    }
}

//Crear Botones en la tabla
const btns_formatter = (value, row, index) => {
    let botones = [];
    botones.push('<a class="editar m-1" href="javascript:void(0)" title="Editar"><small><i class="ri-edit-2-line ri text-primary">Editar</i></small></a>')
    botones.push('<a class="remover m-1" href="javascript:void(0)" title="Borrar"><small><i class="ri-delete-bin-6-line ri text-danger">Borrar</i></small></a>')
    return botones.join('')
}

//Guardar Datos
async function guardarFormTrabajadores(e) {
    e.preventDefault();
    const id = document.querySelector("#id").value;
    const nombres = document.querySelector("#nombres").value;
    const email = document.querySelector("#email").value;
    const direccion = document.querySelector("#direccion").value;
    const telefono = document.querySelector("#telefono").value;
    const tipo_documento = document.querySelector("#tipo").value;
    const numero_id = document.querySelector("#numero_id").value;
    const lugar_expedicion = document.querySelector("#lugar_expedicion").value;
    const cargo = document.querySelector("#cargo").value;
    const fecha_inicial = document.querySelector("#fecha_inicial").value;
    const fecha_final = document.querySelector("#fecha_final").value;
    const saldo = document.querySelector("#saldo").value;
    const auxt = document.querySelector("#auxt").value;
    const estado = document.querySelector("#estado").value;
    const foto = document.querySelector("#foto").files;

    const formData = new FormData();
    formData.append('id', id);
    formData.append('nombres', nombres);
    formData.append('email', email);
    formData.append('direccion', direccion);
    formData.append('telefono', telefono);
    formData.append('tipo_documento', tipo_documento);
    formData.append('numero_id', numero_id);
    formData.append('lugar_expedicion', lugar_expedicion);
    formData.append('cargo', cargo);
    formData.append('fecha_inicial', fecha_inicial);
    formData.append('fecha_final', fecha_final);
    formData.append('saldo', saldo);
    formData.append('auxt', auxt);
    formData.append('foto', foto[0]);
    formData.append('estado', estado);

    if (validarCamposVacios()) {
        let data = await utilExeFetch('/administrativos/trabajadores/create_update', formData);

        console.log('respuesta del servidor',data)

        if (data.error === 34) {
            customAlert(data.type, data.mensaje, 3000, 'toast-top-center', "Mensaje sistema");
            modalTrabajador.hide();
            M_.tabla_trabajadores.bootstrapTable('refresh');
        }
        if (data.error === -34) {
            customAlert(data.type, data.mensaje, 3000, 'toast-top-center', "Mensaje sistema");
            modalTrabajador.hide();
            M_.tabla_trabajadores.bootstrapTable('refresh');
        }
    }
}

//Validar Datos
function validarCamposVacios() {
    const nombres = document.querySelector("#nombres");
    const email = document.querySelector("#email");
    const direccion = document.querySelector("#direccion");
    const telefono = document.querySelector("#telefono");
    const tipo_documento = document.querySelector("#tipo");
    const numero_id = document.querySelector("#numero_id");
    const lugar_expedicion = document.querySelector("#lugar_expedicion");
    const cargo = document.querySelector("#cargo");
    const saldo = document.querySelector("#saldo");
    const estado = document.querySelector("#estado");

    if (nombres.value === "") {
        customAlert('warning', "El campo nombres no puede estar vacío", 2000, "toast-top-center", 'Mensaje del sistema');
        return false;
    }
    if (email.value === "") {
        customAlert('warning', "El campo email no puede estar vacío", 2000, "toast-top-center", 'Mensaje del sistema');
        return false;
    }
    if (direccion.value === "") {
        customAlert('warning', "El campo dirección no puede estar vacío", 2000, "toast-top-center", 'Mensaje del sistema');
        return false;
    }
    if (telefono.value === "") {
        customAlert('warning', "El campo teléfono no puede estar vacío", 2000, "toast-top-center", 'Mensaje del sistema');
        return false;
    }
    if (tipo_documento.value === "") {
        customAlert('warning', "El campo tipo de documento no puede estar vacío", 2000, "toast-top-center", 'Mensaje del sistema');
        return false;
    }
    if (numero_id.value === "") {
        customAlert('warning', "El campo número de ID no puede estar vacío", 2000, "toast-top-center", 'Mensaje del sistema');
        return false;
    }
    if (lugar_expedicion.value === "") {
        customAlert('warning', "El campo lugar de expedición no puede estar vacío", 2000, "toast-top-center", 'Mensaje del sistema');
        return false;
    }
    if (cargo.value === "") {
        customAlert('warning', "El campo cargo no puede estar vacío", 2000, "toast-top-center", 'Mensaje del sistema');
        return false;
    }

    if (saldo.value === "") {
        customAlert('warning', "El campo saldo no puede estar vacío", 2000, "toast-top-center", 'Mensaje del sistema');
        return false;
    }

    if (estado.value === "") {
        customAlert('warning', "El campo estado no puede estar vacío", 2000, "toast-top-center", 'Mensaje del sistema');
        return false;
    }

    return true;
}

//Botones de la tabla
const btn_nuevo_trabajador = () => {
    return {
        btnAddNuevo: {
            text: '', icon: 'fa fa-plus-circle', event: async () => {
                document.querySelector('#estado_accion').classList.add('bg-success');
                document.querySelector('#btn_guardar_form').classList.add('btn-outline-success');
                document.querySelector("#imagen_trabajador").src = path_foto_default
                modalTrabajador.show();
            }, attributes: {
                title: 'Nuevo', class: 'btn btn-success', id: 'btn_nuevo_trabajador'
            }
        }, btnRemoveAll: {
            text: '', icon: 'fa fa-trash', event: () => {
                let ids = getIdSelections(M_.tabla_trabajadores)
                const accion = async () => {
                    let data = new FormData();
                    data.append('ids', JSON.stringify(ids));
                    let response = await M_.borrarTrabajadores(data);
                    M_.tabla_trabajadores.bootstrapTable('refresh');
                    customAlert(response.type, response.mensaje, 3000, 'toast-top-center', "Mensaje sistema");
                    M_.qs(M_.name_remove_all_trabajadores).disabled = true
                }
                confirmar(accion, `Esta seguro que desea eliminar ${ids.length} registros?`);
            }, attributes: {
                title: 'eliminar Registros', class: 'btn btn-danger', id: 'btn_remove_all_trabajadores', disabled: true
            }
        }
    }
}