@extends('admin.layout.app')

@section('title-section', 'Eventos')

@section('content')

    <!-- Botón para abrir el modal -->
    <div class=" mx-10 my-3 text-right">
        <button id="btnAbrirModal" class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">
            Agregar Evento
        </button>
    </div>

    <!-- Modal -->
    <div id="modalEvento" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center  z-50">
        <div class="bg-white rounded-xl shadow-xl w-full max-w-2xl p-6 relative">
            <h2 class="text-xl font-bold mb-4" id="modalTitulo">Agregar Evento</h2>

            <!-- Botón cerrar -->
            <button id="btnCerrarModal" class="absolute top-2 right-4 text-gray-600 hover:text-black text-xl">&times;</button>

            <!-- Formulario -->
            <form id="formEvento" enctype="multipart/form-data">
                <input type="hidden" id="eventoId">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label for="titulo" class="block font-medium">Título</label>
                        <input type="text" id="titulo" name="titulo" class="w-full border rounded p-2">
                    </div>

                    <div>
                        <label for="lugar_evento" class="block font-medium">Lugar del evento</label>
                        <input type="text" id="lugar_evento" name="lugar_evento" class="w-full border rounded p-2">
                    </div>

                    <div>
                        <label for="fecha" class="block font-medium">Fecha</label>
                        <input type="date" id="fecha" name="fecha" class="w-full border rounded p-2">
                    </div>

                    <div>
                        <label for="long_lat" class="block font-medium">Longitud/Latitud</label>
                        <input type="text" id="long_lat" name="long_lat" class="w-full border rounded p-2">
                    </div>

                    <div class="col-span-2">
                        <label for="descripcion" class="block font-medium">Descripción</label>
                        <textarea id="descripcion" name="descripcion" rows="3" class="w-full border rounded p-2"></textarea>
                    </div>

                    <div class="col-span-2">
                        <label for="img_evento" class="block font-medium">Imagen del evento</label>
                        <input type="file" id="img_evento" name="img_evento" class="w-full border rounded p-2">
                    </div>
                </div>

                <div class="mt-4">
                    <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                        Guardar Evento
                    </button>
                    <button type="button" id="btnCancelar" class="ml-2 bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600">
                        Cancelar
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Tabla de eventos -->
    
        <table class="min-w-full bg-white border border-gray-300 rounded-lg">
            <thead>
                <tr class="bg-gray-200">
                    <th class="px-2 py-1">Imagen del Evento</th>
                    <th class="px-2 py-1">Fecha</th>
                    <th class="px-2 py-1">Título</th>
                    <th class="px-2 py-1">Lugar</th>
                    <th class="px-2 py-1">Acciones</th>
                </tr>
            </thead>
            <tbody id="tablaEventos" class="divide-y"></tbody>
        </table>
    
    @endsection


    @section('scriptCustom')
    <script>
        const rutaBase = '/admin/eventos';

        function cargarEventos() {
            $.get(rutaBase, function(data) {
                let html = '';
                data.forEach(e => {
                    html += `
                        <tr>
                            <td class="px-2 py-1">
                                ${e.img_evento ? `<img src="/storage/${e.img_evento}" class="h-16 rounded-md shadow-sm">` : ''}
                            </td>
                            <td class="px-2 py-1 text-center">${e.fecha}</td>
                            <td class="px-2 py-1 text-center">${e.titulo}</td>
                            <td class="px-2 py-1 text-center">${e.lugar_evento}</td>
                            <td class="px-2 py-1 text-center">
                                <button class="bg-blue-500 text-white px-3 py-1 rounded-md hover:bg-blue-700" onclick="editarEvento(${e.id})">Editar</button>
                                <button class="bg-red-500 text-white px-3 py-1 rounded-md hover:bg-red-700" onclick="eliminarEvento(${e.id})">Eliminar</button>
                            </td>
                        </tr>
                    `;
                });
                $('#tablaEventos').html(html);
            });
        }

        function resetForm() {
            $('#eventoId').val('');
            $('#formEvento')[0].reset();
            $('#modalTitulo').text('Agregar Evento');
        }

        function mostrarModal() {
            $('#modalEvento').removeClass('hidden');
            $('#modalEvento').addClass('flex');
        }

        function ocultarModal() {
            $('#modalEvento').addClass('hidden');
            $('#modalEvento').removeClass('flex');
            resetForm();
        }

        $('#btnAbrirModal').click(function() {
            resetForm();
            mostrarModal();
        });

        $('#btnCerrarModal, #btnCancelar').click(function() {
            ocultarModal();
        });

        $('#formEvento').submit(function(e) {
            e.preventDefault();

            let id = $('#eventoId').val();
            let url = rutaBase + (id ? '/' + id : '');
            let method = id ? 'POST' : 'POST'; // PUT se simula
            let formData = new FormData(this);
            if (id) formData.append('_method', 'PUT');

            $.ajax({
                url: url,
                type: method,
                data: formData,
                processData: false,
                contentType: false,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(res) {
                    alert(res.message);
                    ocultarModal();
                    cargarEventos();
                },
                error: function(xhr) {
                    let errores = xhr.responseJSON.errors;
                    let mensaje = 'Errores:\n';
                    for (let campo in errores) {
                        mensaje += `${campo}: ${errores[campo][0]}\n`;
                    }
                    alert(mensaje);
                }
            });
        });

        function editarEvento(id) {
            $.get(`${rutaBase}/${id}`, function(data) {
                $('#eventoId').val(data.id);
                $('#titulo').val(data.titulo);
                $('#descripcion').val(data.descripcion);
                $('#lugar_evento').val(data.lugar_evento);
                $('#long_lat').val(data.long_lat);
                $('#fecha').val(data.fecha);
                $('#modalTitulo').text('Editar Evento');
                mostrarModal();
            });
        }

        function eliminarEvento(id) {
            if (!confirm('¿Eliminar este evento?')) return;
            $.ajax({
                url: `${rutaBase}/${id}`,
                type: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(res) {
                    alert(res.message);
                    cargarEventos();
                },
                error: function(xhr) {
                    alert('Error al eliminar');
                }
            });
        }

        $(document).ready(function() {
            cargarEventos();
        });
    </script>
@endsection
