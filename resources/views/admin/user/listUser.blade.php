@extends('admin.layout.app')

@section('title-section', 'Usuarios')

@section('content')
    <div class=" mx-10 my-3 text-right">
        <button id="openPopup" class="rounded-md bg-green-600 px-3.5 py-2.5 text-sm font-semibold text-white shadow-xs hover:bg-green-500 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">Nuevo Usuario</button>
    </div>

    <table class="min-w-full bg-white border border-gray-300 rounded-lg">


        <thead class="bg-gray-200">
            <tr>
                <th class="py-2 px-4 border-b">ID</th>
                <th class="py-2 px-4 border-b">Nombre</th>
                <th class="py-2 px-4 border-b">Email</th>
                <th class="py-2 px-4 border-b">Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($users as $user)
            <tr class="hover:bg-gray-100" id="user{{ $user->id }}">
                <td class="py-2 px-4 border-b text-center">{{ $user->id }}</td>
                <td class="py-2 px-4 border-b">{{ $user->name }}</td>
                <td class="py-2 px-4 border-b">{{ $user->email }}</td>
                <td class="py-2 px-4 border-b text-center">
                    <a href="#" data-id="{{ $user->id }}" data-nombre="{{ $user->name }}" data-email="{{ $user->email }}" class="btnEditar bg-blue-500 text-white px-3 py-1 rounded-md hover:bg-blue-700">Editar</a>
                    <a href="#" data-id="{{ $user->id }}" class="btnEliminar bg-red-500 text-white px-3 py-1 rounded-md hover:bg-red-700">Eliminar</a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>



    <!-- Popup (Oculto por defecto) -->
    <div id="userPopup" class="fixed inset-0 bg-gray-900 bg-opacity-50 items-center justify-center hidden">
        <div class="bg-white p-6 rounded-lg shadow-lg w-96">
            <h2 class="text-xl font-bold mb-4">Alta de Usuario</h2>

            <!-- Formulario -->
            <form id="userForm">
                <meta name="csrf-token" content="{{ csrf_token() }}">
                <input id="id" name="id" value="0" type="hidden">
                <div class="mb-4">
                    <label class="block text-gray-700">Nombre</label>
                    <input type="text" id="nombre" class="w-full px-3 py-2 border rounded-lg" required>
                </div>

                <div class="mb-4">
                    <label class="block text-gray-700">Email</label>
                    <input type="email" id="email" class="w-full px-3 py-2 border rounded-lg" required>
                </div>

                <div class="mb-4">
                    <label class="block text-gray-700">Contraseña</label>
                    <input type="password" id="password" class="w-full px-3 py-2 border rounded-lg" required>
                </div>

                <div class="flex justify-between">
                    <button type="submit" class="px-4 py-2 bg-green-600 text-white rounded-lg">Guardar</button>
                    <button type="button"  id="closePopup" class="px-4 py-2 bg-red-600 text-white rounded-lg">Cerrar</button>
                </div>
            </form>
        </div>
    </div>
@endsection


@section('scriptCustom')
    <script>
         $(document).ready(function() {
            // Abrir popup
            $("#openPopup").click(function() {
                $("#userPopup").removeClass("hidden");
                $("#userPopup").addClass("flex");
            });

            // Cerrar popup
            $("#closePopup").click(function() {
                $("#userPopup").addClass("hidden");
                $("#userPopup").removeClass("flex");
            });

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            // Manejo del formulario
            $("#userForm").submit(function(event) {
                event.preventDefault();
                let id = $("#id").val();

                let nombre = $("#nombre").val();
                let email = $("#email").val();
                let password = $("#password").val();
                if(id == 0){
                    $.ajax({
                        url: 'addUser/', // asegurate que la ruta esté bien definida
                        type: 'POST',
                        data: {
                            nombre: nombre,
                            email: email,
                            password: password
                        },
                        success: function(respuesta) {
                            alert(respuesta);                            
                        },
                        error: function(xhr) {
                            alert('Error: ' + xhr.responseText);
                            console.error(xhr);
                        }
                    });
                }else{
                    editUserForm(id,nombre,email,password);
                    $("#id").val(0);
                }
                window.location.reload();
            });



            $('.btnEliminar').click(function() {
                const id = $(this).data('id');

                if (!confirm('¿Estás seguro de que querés eliminar este usuario?')) return;

                $.ajax({
                    url: 'deleteUser/' + id,
                    type: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(respuesta) {
                        $("#user"+id).remove();
                    },
                    error: function(xhr) {
                        alert('Error: ' + xhr.responseJSON.error);
                    }
                });
            });

            $('.btnEditar').click(function() {
                console.log('anda');
                $("#userPopup").removeClass("hidden");
                
                $('#id').val($(this).data('id'));
                $('#nombre').val($(this).data('nombre'));
                $('#email').val($(this).data('email'));
                $('#password').val(''); // limpia la contraseña
                // Abrí tu popup o modal acá si usás uno
            });

            function editUserForm(id,nombre,email,password) {

                $.ajax({
                    url: 'updateUser/' + id,
                    type: 'PUT',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: {
                        nombre: nombre,
                        email: email,
                        password: password
                    },
                    success: function(res) {
                        alert(res.message);
                        // actualizá la lista de usuarios si hace falta
                    },
                    error: function(xhr) {
                        if (xhr.status === 422) {
                            let errores = xhr.responseJSON.errors;
                            let mensaje = 'Errores:\n';
                            for (let campo in errores) {
                                mensaje += `${campo}: ${errores[campo][0]}\n`;
                            }
                            alert(mensaje);
                        } else {
                            alert('Error: ' + xhr.responseJSON.error);
                        }
                    }
                });
            }

        });
    </script>
@endsection