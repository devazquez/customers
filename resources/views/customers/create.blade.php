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
                            <h3 class="text-center">Crear un cliente </h3>
                            <form action="{{ route('customers.store') }}" method="POST"> 
                                @csrf 
                                <div class="mb-3">
                                    <label for="customer_id" class="form-label">ID del Cliente:</label>
                                    <input type="text" class="form-control" id="customer_id" name="customer_id" value="{{ old('customer_id') }}" required> 
                                </div>

                                <div class="mb-3">
                                    <label for="first_name" class="form-label">Nombre:</label>
                                    <input type="text" class="form-control" id="first_name" name="first_name" value="{{ old('first_name') }}" required>
                                </div>

                                <div class="mb-3">
                                    <label for="last_name" class="form-label">Apellido:</label>
                                    <input type="text" class="form-control" id="last_name" name="last_name" value="{{ old('last_name') }}" required>
                                </div>

                                <div class="mb-3">
                                    <label for="company" class="form-label">Compañía:</label>
                                    <input type="text" class="form-control" id="company" name="company" value="{{ old('company') }}">
                                </div>

                                <div class="mb-3">
                                    <label for="city" class="form-label">Ciudad:</label>
                                    <input type="text" class="form-control" id="city" name="city" value="{{ old('city') }}">
                                </div>

                                <div class="mb-3">
                                    <label for="country" class="form-label">País:</label>
                                    <input type="text" class="form-control" id="country" name="country" value="{{ old('country') }}">
                                </div>

                                <div class="mb-3">
                                    <label for="phone_1" class="form-label">Teléfono 1:</label>
                                    <input type="tel" class="form-control" id="phone_1" name="phone_1" value="{{ old('phone_1') }}" required>
                                </div>

                                <div class="mb-3">
                                    <label for="phone_2" class="form-label">Teléfono 2:</label>
                                    <input type="tel" class="form-control" id="phone_2" name="phone_2" value="{{ old('phone_2') }}">
                                </div>

                                <div class="mb-3">
                                    <label for="email" class="form-label">Email:</label>
                                    <input type="email" class="form-control" id="email" name="email" value="{{ old('email') }}" required>
                                </div>

                                <div class="mb-3">
                                    <label for="subscription_date" class="form-label">Fecha de Suscripción:</label>
                                    <input type="date" class="form-control" id="subscription_date" name="subscription_date" value="{{ old('subscription_date') }}">
                                </div>

                                <div class="mb-3">
                                    <label for="website" class="form-label">Sitio Web:</label>
                                    <input type="url" class="form-control" id="website" name="website" value="{{ old('website') }}">
                                </div>

                                <button type="submit" class="btn btn-primary">Crear Cliente</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

