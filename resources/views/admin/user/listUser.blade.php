@extends('admin.layout.app')

@section('title-section', 'Usuarios')

@section('content')
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
@endsection