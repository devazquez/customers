@extends('layouts.appPublic')

@section('content')
    <section class="section">
        <div class="section-body">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <h3 class="text-center">Lista de Clientes</h3>  
                            <a  href="{{ route('customers.delete-all') }}"  class="btn btn-danger">Eliminar todos los clientes</a>
                            <a  href="{{ route('customers.create') }}" class="btn btn-primary ">Agregar nuevo cliente</a>
                            <div class="table-responsive">                          
                                <table class="table">
                                    <thead class="thead-dark">
                                        <tr>
                                            <th>ID</th>
                                            <th>Customer ID</th>
                                            <th>Nombre</th>
                                            <th>Apellido</th>
                                            <th>Compañía</th>
                                            <th>Ciudad</th>
                                            <th>País</th>
                                            <th>Teléfono 1</th>
                                            <th>Teléfono 2</th>
                                            <th>Email</th>
                                            <th>Fecha de Suscripción</th>
                                            <th>Sitio Web</th>
                                            <th>Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($customers as $customer)
                                        <tr>
                                            <th scope="row">{{ $customer->id }}</td>
                                            <td>{{ $customer->customer_id }}</td>
                                            <td>{{ $customer->first_name }}</td>
                                            <td>{{ $customer->last_name }}</td>
                                            <td>{{ $customer->company }}</td>
                                            <td>{{ $customer->city }}</td>
                                            <td>{{ $customer->country }}</td>
                                            <td>{{ $customer->phone_1 }}</td>
                                            <td>{{ $customer->phone_2 }}</td>
                                            <td>{{ $customer->email }}</td>
                                            <td>{{ $customer->subscription_date }}</td>
                                            <td>{{ $customer->website }}</td>
                                            <td>
                                                <form action="{{ route('customers.destroy', $customer->id) }}" method="POST" onsubmit="return confirm('¿Estás seguro de que quieres eliminar este cliente?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger">Eliminar</button>
                                                </form>
                                                <a href="{{ route('customers.edit', $customer->id) }}" class="btn btn-primary">Editar</a>
                                                <a href="{{ route('customers.show', $customer->id) }}" class="btn btn-info">Ver</a>
                                                </td>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

