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
            <tr class="hover:bg-gray-100">
                <td class="py-2 px-4 border-b text-center">{{ $user->id }}</td>
                <td class="py-2 px-4 border-b">{{ $user->name }}</td>
                <td class="py-2 px-4 border-b">{{ $user->email }}</td>
                <td class="py-2 px-4 border-b text-center">
                    <a href="#" class="bg-blue-500 text-white px-3 py-1 rounded-md hover:bg-blue-700">Editar</a>
                    <a href="#" class="bg-red-500 text-white px-3 py-1 rounded-md hover:bg-red-700">Eliminar</a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>



    <!-- Popup (Oculto por defecto) -->
    <div id="userPopup" class="fixed inset-0 bg-gray-900 bg-opacity-50 flex items-center justify-center hidden">
        <div class="bg-white p-6 rounded-lg shadow-lg w-96">
            <h2 class="text-xl font-bold mb-4">Alta de Usuario</h2>

            <!-- Formulario -->
            <form id="userForm">
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
                    <button type="button" id="closePopup" class="px-4 py-2 bg-red-600 text-white rounded-lg">Cerrar</button>
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
            });

            // Cerrar popup
            $("#closePopup").click(function() {
                $("#userPopup").addClass("hidden");
            });

            // Manejo del formulario
            $("#userForm").submit(function(event) {
                event.preventDefault();

                let nombre = $("#nombre").val();
                let email = $("#email").val();
                let password = $("#password").val();

                alert("Usuario agregado:\nNombre: " + nombre + "\nEmail: " + email);

                // Aquí podrías enviar los datos a tu backend con AJAX

                // Limpiar y cerrar el popup
                $(this)[0].reset();
                $("#userPopup").addClass("hidden");
            });
        });
    </script>
@endsection