@extends('layouts.appPublic')

@section('content')
    <section class="section">
        <div class="section-body">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <h3 class="text-center">Ingresa el archivo CSV de clientes</h3>
                            <form action="{{ route('store.csv') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <input type="file" name="file" accept=".csv">
                                <button type="submit">Importar desde CSV</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

