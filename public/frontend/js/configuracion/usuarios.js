let M_;
let modal_boostrap_usuario;



const inicioCrud_usuarios = async () => {
    modal_boostrap_usuario = new bootstrap.Modal(M_.name_modal, {backdrop: 'static'})
    M_.modal_usuario.addEventListener('hidden.bs.modal', () => {
        M_.input_id.value = 0;
        M_.modal_footer.classList.remove('bg-success', 'bg-danger')
        M_.btn_reset.disabled = false;
        M_.btn_guardar.classList.remove('btn-outline-success')
        M_.btn_guardar.classList.remove('btn-outline-secondary')
        M_.usuarios_form.reset()
        M_.usuarios_form.classList.remove('was-validated')
    })
}


const iniciarModulo = () => {
    const M_ = {
        qs: name => document.querySelector(name),
        server: utilExeFetch,
        serverPaginador: ajaxRequestPaginador,
        name_modal: '#modal_usuario',
        name_remove_all_usuarios: '#btn_remove_all_usuarios',
        name_tabla_usuarios: 'table_usuarios',
        name_toolbar_tabla: '#toolbar_usuarios',
        tabla_usuarios: null
    }
    return {
        ...M_,
        usuarios_form: M_.qs('#usuarios_form'),
        input_id: M_.qs('#id'),
        input_name_nombre: M_.qs('#nombre'),
        input_name_correo: M_.qs('#correo'),
        input_name_telefono: M_.qs('#telefono'),
        input_name_direccion: M_.qs('#direccion'),
        input_name_contrasena: M_.qs('#contrasena'),
        input_name_confirmar_contrasena: M_.qs('#confirmar_contrasena'),
        select_id_estado: M_.qs('#estado'),
        btn_reset: M_.qs('#btn_reset_form'),
        btn_guardar: M_.qs('#btn_guardar_form'),
        modal_footer: M_.qs('#estado_accion'),
        modal_usuario: M_.qs(M_.name_modal),
        borrarusuario: async data => M_.server('/Configuracion/Usuarios/delate', data),
        borrarUsuarios: async data => M_.server('/Configuracion/Usuarios/delates', data),
    };
}


const ajaxRequest = async (params) => {
    let form = new FormData()
    let response = await utilExeFetch('/Configuracion/Usuarios/paginacion', form);
    responseHandler(response)
    params.success(response)
}


const initTabla_usuarios = () => {
    M_ = iniciarModulo();
    let spacific_config = {
        ajax: ajaxRequest,
        columns:
            [
                formatt_campo_title_boostrap_table({type: 'state'}),
                formatt_campo_title_boostrap_table({type: 'id'}),
                formatt_campo_title_boostrap_table({type: 'text', name: 'nombres'}),
                formatt_campo_title_boostrap_table({type: 'text', name: 'email'}),
                formatt_campo_title_boostrap_table({type: 'relation', name: 'estado'}),
                formatt_campo_title_boostrap_table({type: 'text', name: 'estado'}),
                formatt_campo_title_boostrap_table({
                    type: 'operate',
                    name: 'operate',
                    events: window.operateEvents,
                    formatter: btns_formatter
                })
            ],
        toolbar: M_.name_toolbar_tabla,
        buttons: btn_nuevo_usuario,
    }
    M_.tabla_usuarios = crate_table_boostrap_table(M_.name_tabla_usuarios, spacific_config, {
        showFooter: true,
        pagination: true,
        buttonsClass: "primary",
        pageSize: 30,
        pageList: [30, 50, 100, 'ALL'],
        showRefresh: true
    })
    M_.tabla_usuarios.on('check.bs.table uncheck.bs.table check-all.bs.table uncheck-all.bs.table', () => {
        M_.qs(M_.name_remove_all_usuarios).disabled = !getIdSelections(M_.tabla_usuarios).length
    })
}

function responseHandler(res) {
    return res.rows
}


window.operateEvents = {
    'click .editar': async (e, value, row, index) => {
        M_.input_id.value = row.id;
        M_.input_name_nombre.value = row.name_nombres;
        M_.input_name_correo.value = row.name_email;
        M_.input_name_contrasena.value = '';
        M_.input_name_confirmar_contrasena.value = '';
        M_.select_id_estado.value = row.id_estado;
        M_.modal_footer.classList.add('bg-primary')
        M_.btn_guardar.classList.add('btn-outline-primary')
        M_.btn_reset.disabled = true;
        modal_boostrap_usuario.show();
    },
    'click .remover': async (e, value, row, index) => {
        const accion = async () => {
            let data = new FormData()
            data.append('id', row.id)
            let response =  await M_.borrarusuario(data);
            M_.tabla_usuarios.bootstrapTable('refresh');
            customAlert(response.type, response.mensaje, 3000, 'toast-top-center', "Mensaje sistema");
        }
        confirmar(accion);
    }
}

const btns_formatter = (value, row, index) => {
    let botones = [];
    botones.push('<a class="editar m-1" href="javascript:void(0)" title="Editar"><i class="fa fa-edit text-primary"></i></a>')
    // botones.push('<a class="remover m-1" href="javascript:void(0)" title="Remove"><i class="fa fa-trash text-danger"></i></a>')
    return botones.join('')
}

async function guardarFormUsuarios(e) {
    e.preventDefault();
    let id = document.querySelector("#id").value;
    let nombre = document.querySelector("#nombre").value;
    let correo = document.querySelector("#correo").value;
    let contrasena = document.querySelector("#contrasena").value;
    let confirmar_contrasena = document.querySelector("#confirmar_contrasena").value;
    let estado = document.querySelector("#estado").value;
    let forma = new FormData();
    forma.append('id', id);
    forma.append('nombre', nombre);
    forma.append('correo', correo);
    forma.append('contrasena', contrasena);
    forma.append('confirmar_contrasena', confirmar_contrasena);
    forma.append('estado', estado);
    if (validarCamposFormUsuario()) {
        let data = await utilExeFetch('/Configuracion/Usuarios/create_update', forma);
        if (data.error === 34) {
            customAlert(data.type, data.mensaje, 3000, 'toast-top-center', "Mensaje sistema");
            modal_boostrap_usuario.hide();
            M_.tabla_usuarios.bootstrapTable('refresh');
        }
        if (data.error === -34) {
            customAlert(data.type, data.mensaje, 3000, 'toast-top-center', "Mensaje sistema");
            modal_boostrap_usuario.hide();
            M_.tabla_usuarios.bootstrapTable('refresh');
        }
    }
}

function validarCamposFormUsuario() {
    let nombre = document.querySelector("#nombre");
    let correo = document.querySelector("#correo");
    let contrasena = document.querySelector("#contrasena");
    let confirmar_contrasena = document.querySelector("#confirmar_contrasena");
    let estado = document.querySelector("#estado");

    if (nombre.value === "") {
        customAlert('warning', "El campo nombre no puede estar vacio", 2000, "toast-top-center", 'Mensaje del sistema');
        return false;
    }

    if (correo.value === "") {
        customAlert('warning', "El campo correo no puede estar vacio", 2000, "toast-top-center", 'Mensaje del sistema');
        return false;
    }

    if (contrasena.value === "") {
        customAlert('warning', "El campo contraseña no puede estar vacio", 2000, "toast-top-center", 'Mensaje del sistema');
        return false;
    }
    if (confirmar_contrasena.value === "") {
        customAlert('warning', "El campo confirmar contraseña no puede estar vacio", 2000, "toast-top-center", 'Mensaje del sistema');
        return false;
    }

    if (estado.value === "") {
        customAlert('warning', "El campo estado no puede estar vacio", 2000, "toast-top-center", 'Mensaje del sistema');
        return false;
    }

    return true;
}


const btn_nuevo_usuario = () => {
    return {
        btnAddNuevo: {
            text: '',
            icon: 'fa fa-plus-circle',
            event: async () => {
                M_.modal_footer.classList.add('bg-success')
                M_.btn_guardar.classList.add('btn-outline-success')
                modal_boostrap_usuario.show();
            },
            attributes: {
                title: 'Nuevo',
                class: 'btn btn-success',
                id: 'btn_nuevo_usuario'
            }
        },
        // btnRemoveAll: {
        //     text: '',
        //     icon: 'fa fa-trash',
        //     event: () => {
        //         let ids = getIdSelections(M_.tabla_usuarios)
        //         const accion = async () => {
        //             let data = new FormData();
        //             data.append('ids', JSON.stringify(ids));
        //             let response = await M_.borrarUsuarios(data);
        //             M_.tabla_usuarios.bootstrapTable('refresh');
        //             customAlert(response.type, response.mensaje, 3000, 'toast-top-center', "Mensaje sistema");
        //             M_.qs(M_.name_remove_all_usuarios).disabled = true
        //         }
        //         confirmar(accion, `Esta seguro que desea eliminar ${ids.length} registros?`);
        //     },
        //     attributes: {
        //         title: 'eliminar Registros',
        //         class: 'btn btn-danger',
        //         id: 'btn_remove_all_usuarios',
        //         disabled: true
        //     }
        // }
    }
}

