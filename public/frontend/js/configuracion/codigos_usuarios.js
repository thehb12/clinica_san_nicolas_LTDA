let M_;
const iniciarModulo = () => {
    const M_ = {
        qs: name => document.querySelector(name),
        server: utilExeFetch,
        serverPaginador: ajaxRequestPaginador,
        name_modal: '#modal_codigo_usuario',
        name_remove_all_codigos_usuarios: '#btn_remove_all_codigos_usuarios',
        name_tabla_codigos_usuarios: 'table_codigos_usuarios',
        name_toolbar_tabla: '#toolbar_codigos_usuarios',
        tabla_codigos_usuarios: null
    }
    return {
        ...M_,
        codigos_usuarios_form: M_.qs('#codigos_usuarios_form'),
        input_id: M_.qs('#id'),
        input_name_codigo: M_.qs('#codigo'),
        select_id_estado: M_.qs('#estado'),
        btn_reset: M_.qs('#btn_reset_form'),
        btn_guardar: M_.qs('#btn_guardar_form'),
        modal_footer: M_.qs('#estado_accion'),
        modal_codigo_usuario: M_.qs(M_.name_modal),
    };
}


const ajaxRequest = async (params) => {
    let form = new FormData()
    let response = await utilExeFetch(path_lista_tabla_codigos_usuarios, form);
    responseHandler(response)
    params.success(response)
}


const initTabla_Codigos_Usuarios = () => {
    M_ = iniciarModulo();
    let spacific_config = {
        ajax: ajaxRequest,
        columns:
            [
                formatt_campo_title_boostrap_table({type: 'state'}),
                formatt_campo_title_boostrap_table({type: 'id'}),
                formatt_campo_title_boostrap_table({type: 'relation', name: 'usuario'}),
                formatt_campo_title_boostrap_table({type: 'text', name: 'usuario'}),
                formatt_campo_title_boostrap_table({type: 'text', name: 'codigo'}),
            ],
        toolbar: M_.name_toolbar_tabla,
    }
    M_.tabla_codigos_usuarios = crate_table_boostrap_table(M_.name_tabla_codigos_usuarios, spacific_config, {
        pagination: true,
        pageSize: 15
    })
}

function responseHandler(res) {
    return res.rows
}
