document.addEventListener("DOMContentLoaded", function () {
    if ($('#detalle_pedido').length > 0) {
        listar();
    }
    
    $('#tbl').DataTable({
        language: {
            "url": "//cdn.datatables.net/plug-ins/1.10.11/i18n/Spanish.json"
        },
        "order": [
            [0, "desc"]
        ],
        "paging": true,
        "pagingType": "simple_numbers",
        "searching": true
    });

    $(".confirmar").submit(function (e) {
        e.preventDefault();
        Swal.fire({
            title: '¿Está seguro de eliminar?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#FF6347', // Tomato color for confirm button
            cancelButtonColor: '#28a745', // Green color for cancel button
            confirmButtonText: 'Sí, Eliminar!'
        }).then((result) => {
            if (result.isConfirmed) {
                this.submit();
            }
        });
    });

    $('.addDetalle').click(function () {
        let id_producto = $(this).data('id');
        registrarDetalle(id_producto);
    });

    $('#realizar_pedido').click(function (e) {
        e.preventDefault();
        var action = 'procesarPedido';
        var id_sala = $('#id_sala').val();
        var mesa = $('#mesa').val();
        var observacion = $('#observacion').val();
        $.ajax({
            url: 'ajax.php',
            async: true,
            data: {
                procesarPedido: action,
                id_sala: id_sala,
                mesa: mesa,
                observacion: observacion
            },
            success: function (response) {
                const res = JSON.parse(response);
                if (response != 'error') {
                    Swal.fire({
                        position: 'top-end',
                        icon: 'success',
                        title: 'Pedido solicitado con éxito',
                        showConfirmButton: false,
                        timer: 2000
                    })
                    setTimeout(() => {
                        window.location = 'mesas.php?id_sala=' + id_sala + '&mesas=' + res.mensaje;
                    }, 1500);
                } else {
                    Swal.fire({
                        position: 'top-end',
                        icon: 'error',
                        title: 'Error al generar el pedido',
                        showConfirmButton: false,
                        timer: 2000
                    })
                }
            },
            error: function (error) {
                alert(error);
            }
        });
    });

    $('.finalizarPedido').click(function () {
        var action = 'finalizarPedido';
        var id_sala = $('#id_sala').val();
        var mesa = $('#mesa').val();
        $.ajax({
            url: 'ajax.php',
            async: true,
            data: {
                finalizarPedido: action,
                id_sala: id_sala,
                mesa: mesa
            },
            success: function (response) {
                const res = JSON.parse(response);
                if (response != 'error') {
                    Swal.fire({
                        position: 'top-end',
                        icon: 'success',
                        title: 'Pedido Finalizado',
                        showConfirmButton: false,
                        timer: 2000
                    })
                    setTimeout(() => {
                        window.location = 'mesas.php?id_sala=' + id_sala + '&mesas=' + res.mensaje;
                    }, 1500);
                } else {
                    Swal.fire({
                        position: 'top-end',
                        icon: 'error',
                        title: 'Error al finalizar el pedido',
                        showConfirmButton: false,
                        timer: 2000
                    })
                }
            },
            error: function (error) {
                alert(error);
            }
        });
    })
});

function listar() {
    let html = '';
    let detalle = 'detalle';
    $.ajax({
        url: "ajax.php",
        dataType: "json",
        data: {
            detalle: detalle
        },
        success: function (response) {
            response.forEach(row => {
                html += `<div class="col-md-4 mb-3">
                    <div class="card shadow-lg">
                        <div class="card-body">
                            <div class="col-12 text-center">
                                <img src="${row.imagen}" class="product-image rounded-circle border" alt="Product Image" style="max-width: 100px;">
                            </div>
                            <p class="my-3 text-muted">${row.nombre}</p>
                            <h2 class="mb-0 text-success">${row.precio}</h2>
                            <div class="mt-3">
                                <input type="number" class="form-control addCantidad mb-2" data-id="${row.id}" value="${row.cantidad}" style="border-radius: 10px;">
                                <button class="btn btn-danger eliminarPlato" type="button" data-id="${row.id}" style="border-radius: 10px;">Eliminar</button>
                            </div>
                        </div>
                    </div>
                </div>`;
            });
            document.querySelector("#detalle_pedido").innerHTML = html;
            $('.eliminarPlato').click(function () {
                let id = $(this).data('id');
                eliminarPlato(id);
            })
            $('.addCantidad').change(function (e) {
                let id = $(this).data('id');
                cantidadPlato(e.target.value, id);
            })
        }
    });
}

function registrarDetalle(id_pro) {
    let action = 'regDetalle';
    $.ajax({
        url: "ajax.php",
        type: 'POST',
        dataType: "json",
        data: {
            id: id_pro,
            regDetalle: action
        },
        success: function (response) {
            if (response == 'registrado') {
                listar();
            }
            Swal.fire({
                position: 'top-end',
                icon: 'success',
                title: 'Producto agregado al carrito',
                showConfirmButton: false,
                timer: 2000
            })
        }
    });
}

function eliminarPlato(id) {
    let detalle = 'Eliminar';
    $.ajax({
        url: "ajax.php",
        data: {
            id: id,
            delete_detalle: detalle
        },
        success: function (response) {
            if (response == 'ok') {
                Swal.fire({
                    position: 'top-end',
                    icon: 'success',
                    title: 'Producto eliminado con éxito',
                    showConfirmButton: false,
                    timer: 2000
                })
                listar();
            } else {
                Swal.fire({
                    position: 'top-end',
                    icon: 'error',
                    title: 'Error al eliminar el producto',
                    showConfirmButton: false,
                    timer: 2000
                })
            }
        }
    });
}

function cantidadPlato(cantidad, id) {
    let detalle = 'cantidad';
    $.ajax({
        url: "ajax.php",
        data: {
            id: id,
            cantidad: cantidad,
            detalle_cantidad: detalle
        },
        success: function (response) {
            if (response != 'ok') {
                listar();
                Swal.fire({
                    position: 'top-end',
                    icon: 'error',
                    title: 'Error al agregar la cantidad',
                    showConfirmButton: false,
                    timer: 2000
                })
            }
        }
    });
}

function btnCambiar(e) {
    e.preventDefault();
    const actual = document.getElementById('actual').value;
    const nueva = document.getElementById('nueva').value;
    if (actual == "" || nueva == "") {
        Swal.fire({
            position: 'top-end',
            icon: 'error',
            title: 'Los campos están vacíos',
            showConfirmButton: false,
            timer: 2000
        })
    } else {
        const cambio = 'pass';
        $.ajax({
            url: "ajax.php",
            type: 'POST',
            data: {
                actual: actual,
                nueva: nueva,
                cambio: cambio
            },
            success: function (response) {
                if (response == 'ok') {
                    Swal.fire({
                        position: 'top-end',
                        icon: 'success',
                        title: 'Contraseña modificada con éxito',
                        showConfirmButton: false,
                        timer: 2000
                    })
                    document.querySelector('#frmPass').reset();
                    $("#nuevo_pass").modal("hide");
                } else if (response == 'dif') {
                    Swal.fire({
                        position: 'top-end',
                        icon: 'error',
                        title: 'Contraseña actual incorrecta',
                        showConfirmButton: false,
                        timer: 2000
                    })
                } else {
                    Swal.fire({
                        position: 'top-end',
                        icon: 'error',
                        title: 'Error al modificar la contraseña',
                        showConfirmButton: false,
                        timer: 2000
                    })
                }
            }
        });
    }
}

function editarUsuario(id) {
    const action = "editarUsuario";
    $.ajax({
        url: 'ajax.php',
        type: 'GET',
        async: true,
        data: {
            editarUsuario: action,
            id: id
        },
        success: function (response) {
            const datos = JSON.parse(response);
            $('#nombre').val(datos.nombre);
            $('#rol').val(datos.rol);
            $('#correo').val(datos.correo);
            $('#id').val(datos.id);
            $('#btnAccion').val('actualizar');
        }
    });
}


function limpiar() {
    $('#formulario')[0].reset();
    $('#id').val('');
    $('#btnAccion').val('Registrar');
}