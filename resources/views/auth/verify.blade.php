@extends('layouts.appPublic')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-7" style="margin-top: 2%">
                <div class="box">
                    <h3 class="box-title" style="padding: 2%">Verifica tu correo electrónico</h3>

                    <div class="box-body">
                        @if (session('resent'))
                            <div class="alert alert-success" role="alert">Un nuevo enlace de verificación se ha enviado a tu correo electrónico
                            </div>
                        @endif
                        <p>Antes de proceder, por favor verifica tu  correo electrónico para poder ingresar. Si no recibiste un correo de verificación, </p>
                        <a class="btn btn-primary"  onclick="event.preventDefault(); document.getElementById('email-form').submit();" style="color:#fff;"> Da click para enviar un nuevo correo </a>.
                        <form id="email-form" action="{{ route('verification.resend') }}" method="POST" style="display: none;">@csrf</form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection