@extends('layouts.appPublic')

@section('content')
    <section class="section">
        <div class="section-body">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <h3 class="text-center">Editar cliente </h3>
                            <form action="{{ route('customers.update', $customer->id) }}" method="POST"> 
                                @csrf
                                @method('PUT')                                 
                                <div class="mb-3">
                                    <label for="first_name" class="form-label">Nombre:</label>
                                    <input type="text" class="form-control" id="first_name" name="first_name"   value="{{ $customer->first_name }}" required>
                                </div>

                                <div class="mb-3">
                                    <label for="last_name" class="form-label">Apellido:</label>
                                    <input type="text" class="form-control" id="last_name" name="last_name" value="{{ $customer->last_name }}" required>
                                </div>

                                <div class="mb-3">
                                    <label for="company"   class="form-label">Compañía:</label>
                                    <input type="text" class="form-control" id="company" name="company" value="{{ $customer->company }}">
                                </div>

                                <div class="mb-3">
                                    <label for="city" class="form-label">Ciudad:</label>
                                    <input type="text" class="form-control" id="city" name="city" value="{{ $customer->city }}">
                                </div>

                                <div class="mb-3">
                                    <label for="country" class="form-label">País:</label>
                                    <input type="text" class="form-control" id="country" name="country" value="{{ $customer->country }}">
                                </div>

                                <div class="mb-3">
                                    <label for="phone_1" class="form-label">Teléfono 1:</label>
                                    <input type="tel" class="form-control" id="phone_1" name="phone_1" value="{{ $customer->phone_1 }}" required>
                                </div>

                                <div class="mb-3">
                                    <label for="phone_2" class="form-label">Teléfono 2:</label>
                                    <input type="tel" class="form-control" id="phone_2" name="phone_2" value="{{ $customer->phone_2 }}">
                                </div>

                                <div class="mb-3">
                                    <label for="email" class="form-label">Email:</label>
                                    <input type="email" class="form-control" id="email" name="email" value="{{ $customer->email }}" required>
                                </div>

                                <div class="mb-3">
                                    <label for="subscription_date"  class="form-label">Fecha de Suscripción:</label>
                                    <input type="date" class="form-control" id="subscription_date" name="subscription_date" value="{{ $customer->subscription_date }}">
                                </div>

                                <div class="mb-3">
                                    <label for="website" class="form-label">Sitio Web:</label>
                                    <input type="url" class="form-control" id="website" name="website" value="{{ $customer->website }}">
                                </div>

                                <button type="submit" class="btn btn-primary">Guardar Cambios</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

