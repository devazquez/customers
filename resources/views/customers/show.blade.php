@extends('layouts.appPublic')

@section('content')
    <section class="section">
        <div class="section-header">
            <h3 class="page__heading">Customers</h3>
        </div>
        <div class="section-body">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <h3 class="text-center">Detalles del Cliente</h3>
                            <div class="container">    
                                <div class="card">
                                    <div class="card-body">
                                        <h5 class="card-title">ID del Cliente: {{ $customer->customer_id }}</h5>
                                        <p class="card-text">Nombre: {{ $customer->first_name }}</p>
                                        <p class="card-text">Apellido: {{ $customer->last_name }}</p>
                                        <p class="card-text">Compañía: {{ $customer->company }}</p>
                                        <p class="card-text">Ciudad: {{ $customer->city }}</p>
                                        <p class="card-text">País: {{ $customer->country }}</p>
                                        <p class="card-text">Teléfono 1: {{ $customer->phone_1 }}</p>
                                        <p class="card-text">Teléfono 2: {{ $customer->phone_2 }}</p>
                                        <p class="card-text">Email: {{ $customer->email }}</p>
                                        <p class="card-text">Fecha de Suscripción: {{ $customer->subscription_date }}</p>
                                        <p class="card-text">Sitio Web: {{ $customer->website }}</p>
                                    </div>
                                </div>

                                <a href="{{ route('customers.index') }}" class="btn btn-secondary mt-3">Volver a la lista</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

