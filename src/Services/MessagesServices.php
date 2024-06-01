<?php

namespace App\Services;

use Symfony\Component\HttpFoundation\JsonResponse;

class MessagesServices
{

    public function codigoInvalido(): array
    {
        return [
            "error" => 3,
            "type" => 'error',
            "mensaje" => 'Codigo Invalido.',
        ];
    }

    public function clavesNoIguales(): array
    {
        return [
            "error" => 3,
            "type" => 'success',
            "mensaje" => 'Las contraseñas ingresadas no son iguales.',
        ];
    }

    public function usuarioDuplicado(): array
    {
        return [
            "error" => 34,
            "type" => 'success',
            "mensaje" => 'Ya existe un usuario con el mismo nombre.',
        ];
    }

    public function correoDuplicado(): array
    {
        return [
            "error" => 34,
            "type" => 'success',
            "mensaje" => 'El correo ya Existe.',
        ];
    }

    public function codigoDuplicado(): array
    {
        return [
            "error" => 34,
            "type" => 'success',
            "mensaje" => 'El codigo ya existe.',
        ];
    }

    public function dniDuplicado(): array
    {
        return [
            "error" => 34,
            "type" => 'success',
            "mensaje" => 'El DNI ya existe.',
        ];
    }

    public function nombreCategoriaDuplicado(): array
    {
        return [
            "error" => 34,
            "type" => 'success',
            "mensaje" => 'El nombre de la categoria ya existe.',
        ];
    }

    public function nombreDuplicado(): array
    {
        return [
            "error" => 34,
            "type" => 'success',
            "mensaje" => 'Se insertaron solo registros no existentes',
        ];
    }

    public function nombreMedidaDuplicado(): array
    {
        return [
            "error" => 34,
            "type" => 'success',
            "mensaje" => 'El nombre de la media ya existe.',
        ];
    }

    public function abirtaCaja(): array
    {
        return [
            "error" => 34,
            "type" => 'success',
            "mensaje" => 'la caja ya esta abierta.',
        ];
    }


    public function cedulaDuplicada(): array
    {
        return [
            "error" => 34,
            "type" => 'success',
            "mensaje" => 'la cedula ya existe.',
        ];
    }

    public function usuarioCreada(): array
    {
        return [
            "error" => 34,
            "type" => 'success',
            "mensaje" => 'Usuario creado con exito.',
        ];
    }

    public function usuarioEditado(): array
    {
        return [
            "error" => -34,
            "type" => 'success',
            "mensaje" => 'Usuario editado con exito.',
        ];
    }

    public function trabajadorCreada(): array
    {
        return [
            "error" => 34,
            "type" => 'success',
            "mensaje" => 'Empleado creado con exito.',
        ];
    }

    public function trabajadorEditado(): array
    {
        return [
            "error" => -34,
            "type" => 'success',
            "mensaje" => 'Empleado editado con exito.',
        ];
    }

    public function limite(): array
    {
        return [
            "error" => -110,
            "type" => 'error',
            "mensaje" => "El campo limite no puede ir vacio"
        ];

    }

    public function productoCreada(): array
    {
        return [
            "error" => 34,
            "type" => 'success',
            "mensaje" => 'Usuario creado con exito.',
        ];
    }

    public function productoEditado(): array
    {
        return [
            "error" => -34,
            "type" => 'success',
            "mensaje" => 'Usuario editado con exito.',
        ];
    }

    public function cantidadAgregar(): array
    {
        return [
            "error" => 100,
            "type" => 'success',
            "mensaje" => 'Cantidad Agregada con exito.',
        ];
    }

    public function cantidadQuitar(): array
    {
        return [
            "error" => 100,
            "type" => 'success',
            "mensaje" => 'Dio de baja con exito.',
        ];
    }

    public function proveedorCreada(): array
    {
        return [
            "error" => 34,
            "type" => 'success',
            "mensaje" => 'Proveedor creado con exito.',
        ];
    }

    public function proveedorEditado(): array
    {
        return [
            "error" => -34,
            "type" => 'success',
            "mensaje" => 'Proveedor editado con exito.',
        ];
    }

    public function clienteCreado(): array
    {
        return [
            "error" => 34,
            "type" => 'success',
            "mensaje" => 'Proveedor creado con exito.',
        ];
    }

    public function clienteEditado(): array
    {
        return [
            "error" => -34,
            "type" => 'success',
            "mensaje" => 'Proveedor editado con exito.',
        ];
    }

    public function compoUsuario(): array
    {
        return [
            "error" => 30,
            "type" => 'success',
            "mensaje" => 'El campo usuario es obligatorio.',
        ];
    }

    public function compoNombre(): array
    {
        return [
            "error" => 31,
            "type" => 'success',
            "mensaje" => 'El campo nombre es obligatorio.',
        ];
    }

    public function compoClaveUno(): array
    {
        return [
            "error" => 32,
            "type" => 'success',
            "mensaje" => 'El campo contraseña es obligatorio.',
        ];
    }

    public function compoClaveDos(): array
    {
        return [
            "error" => 33,
            "type" => 'success',
            "mensaje" => 'El campo confirmar contraseña es obligatorio.',
        ];
    }

    public function compoEstado(): array
    {
        return [
            "error" => 34,
            "type" => 'success',
            "mensaje" => 'El campo estado es obligatorio.',
        ];
    }

    public function todoCampo(): array
    {
        return [
            "error" => 34,
            "type" => 'success',
            "mensaje" => 'Todos los campos son obligatorio.',
        ];
    }

    public function resgistrosBorrados(int $cantidad = 0): array
    {
        return [
            "error" => 35,
            "type" => "success",
            "mensaje" => "Se borraron " . $cantidad . " registros con exito!."
        ];
    }

    public function ticket(string $cantidad = ''): array
    {
        return [
            "error" => 35,
            "type" => "info",
            "mensaje" => "Ticket creado con exito." . "<br>" . " EL TICKET ID es: " . $cantidad
        ];
    }

    public function debug(): array
    {
        return [
            "error" => 36,
            "type" => 'error',
            "mensaje" => "proceso en contrucción :debug"
        ];
    }

    public function registroNoEncontrado(): array
    {
        return [
            "error" => 37,
            "type" => "error",
            "mensaje" => "No se pudo eliminar el registro porque no se encontró en la base de datos."
        ];
    }

    public function registroBorrado(): array
    {
        return [
            "error" => 38,
            "type" => "error",
            "mensaje" => "Registro borrado con exito!!"
        ];
    }

    public function formImcompleto(): array
    {
        return [
            "error" => 39,
            "type" => 'error',
            "mensaje" => "Formulario incompleto!."
        ];
    }

    public function claveCambiada(): array
    {
        return [
            "error" => 40,
            "type" => 'success',
            "mensaje" => "Se cambió con éxito la clave exitosamente.!."
        ];
    }

    public function claveAnteriorIncorrecta(): array
    {
        return [
            "error" => 41,
            "type" => 'error',
            "mensaje" => "La clave Anterior que ingresó no es valida!."
        ];
    }

    public function usuarioPerfil(): array
    {
        return [
            "error" => 42,
            "type" => 'success',
            "mensaje" => "Usuario Actualizado con exito"
        ];
    }

    public function codigoGenerado(): array
    {
        return [
            "error" => 42,
            "type" => 'success',
            "mensaje" => "Codigo generado con exito"
        ];
    }

    public function codigoExiste(): array
    {
        return [
            "error" => 42,
            "type" => 'success',
            "mensaje" => "Codigo existente genere otro!"
        ];
    }


    public function guardarDetalle(): array
    {
        return [
            "error" => 42,
            "type" => 'success',
            "mensaje" => "Se ha generado un nuevo detalle"
        ];
    }

    public function editarDetalle(): array
    {
        return [
            "error" => 42,
            "type" => 'success',
            "mensaje" => "Se ha editado un detalle"
        ];
    }

    public function registrarCompra(): array
    {
        return [
            "error" => 42,
            "type" => 'info',
            "mensaje" => "Compra Realizada con exito!"
        ];
    }

    public function descuentoActualizado(): array
    {
        return [
            "error" => 42,
            "type" => 'info',
            "mensaje" => "Se a aplicado el descuento con exito!"
        ];
    }

    public function Cantidad(): array
    {
        return [
            "error" => 42,
            "type" => 'error',
            "mensaje" => "Producto Agotado!"
        ];
    }

    public function likes(): array
    {
        return [
            "error" => 42,
            "type" => 'success',
            "mensaje" => "Gracias por dar me gusta Nuestros Productos!"
        ];
    }

    public function maxCantidad(): array
    {
        return [
            "error" => 42,
            "type" => 'error',
            "mensaje" => "La cantidad actual es mayor a la del inventario"
        ];
    }

    public function nitUsadoPorOtraEmpresa(): array
    {
        return [
            "error" => 3,
            "type" => 'error',
            "mensaje" => "El número NIT ya ha sido usado por otra empresa."
        ];
    }

    public function correoAsociadoTrabajador(): array
    {
        return [
            "error" => -110,
            "type" => 'error',
            "mensaje" => "El correo esta asociado a otro trabajador"
        ];

    }

    public function empresaCreada(): array
    {
        return [
            "error" => 34,
            "type" => 'success',
            "mensaje" => "Empresa creada con exito"
        ];
    }

    public function registroYaExiste(): array
    {
        return [
            "error" => 34,
            "type" => 'error',
            "mensaje" => "Ya existe un registro con mismo nombre"
        ];
    }

    public function agregarDatos(): array
    {
        return [
            "error" => 34,
            "type" => 'error',
            "mensaje" => "Por Favor Agregar más campos en las persianas"
        ];
    }

    public function registro(): array
    {
        return [
            "error" => 34,
            "type" => 'success',
            "mensaje" => "Registro Existente Activo"
        ];
    }

    public function errorGenerico(): array
    {
        return [
            "error" => 34,
            "type" => 'success',
            "mensaje" => "Error Generico"
        ];
    }


    public function registroGuardado(): array
    {
        return [
            "error" => -34,
            "type" => "success",
            "mensaje" => "Registro guardado con exito!!"
        ];
    }

    public function registroEditado(): array
    {
        return [
            "error" => 34,
            "type" => "success",
            "mensaje" => "Registro actualizado con exito!!"
        ];
    }


    public function registroActualizado(): array
    {
        return [
            "error" => 34,
            "type" => "success",
            "mensaje" => "Registro actualizado con exito!!"
        ];
    }

    public function permisosModificados(): array
    {
        return [
            "error" => 34,
            "type" => 'success',
            "mensaje" => "Permisos modificados con exito!."
        ];
    }

    public function errorConsulta(): array
    {
        return [
            "error" => -1,
            "type" => 'error',
            "mensaje" => "Error en la consulta!."
        ];
    }

    public function existeUnClienteConCedula(): array
    {
        return [
            "error" => 34,
            "type" => 'error',
            "mensaje" => "Ya existe un cliente con esta cedula."
        ];
    }

    public function compraAnulada(): array
    {
        return [
            "error" => 34,
            "type" => 'error',
            "mensaje" => "Compra Anulada Con Exito.."
        ];
    }

    public function ventaAnulada(): array
    {
        return [
            "error" => 34,
            "type" => 'error',
            "mensaje" => "Venta Anulada Con Exito.."
        ];
    }

    public function abrirCaja(): array
    {
        return [
            "error" => -34,
            "type" => "success",
            "mensaje" => "Caja abierta con exito!!"
        ];
    }

    public function cerrarCaja(): array
    {
        return [
            "error" => -34,
            "type" => "success",
            "mensaje" => "Caja cerrada con exito!!"
        ];
    }

}