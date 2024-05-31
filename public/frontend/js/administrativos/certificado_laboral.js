const descargarPDF = () => {
    window.open(`/administrativos/certificado/laboral/generar_pdf`)
 }
 
 const mostrarAlert = () => {
    Swal.fire({
       title: 'Desea descargar su certificado laboral presione el boton descargar PDF!!',
       icon: 'success',
       confirmButtonText: 'Cerrar'
    });
 }