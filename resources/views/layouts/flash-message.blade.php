@if ($message = Session::get('success'))

<script>
    Swal.fire({        
        icon: 'success',
        title: @json($message),
        showConfirmButton: false,
        timer: 5000
    });
    console.log(@json($message));
</script>

@endif

@if ($message = Session::get('error'))
                
<script>
    Swal.fire({        
        icon: 'error',
        title: @json($message),
        showConfirmButton: false,
        timer: 5000
    });
    console.log(@json($message));
</script>
@endif

@if ($message = Session::get('warning'))
<script>
    Swal.fire({
        
        icon: 'warning',
        title: @json($message),
        showConfirmButton: false,
        timer: 5000
    })
</script>
@endif

@if ($message = Session::get('info'))
<script>
    Swal.fire({
        
        icon: 'info',
        title: @json($message),
        showConfirmButton: false,
        timer: 5000
    })
</script>
@endif

@if ($message = Session::get('notification'))
<script>
    Swal.fire({       
        icon: 'notification',
        title: @json($message),
        showConfirmButton: false,
        timer: 5000
    })
</script>
@endif



@if ($message = $errors->any())
<script>    
    Swal.fire({       
        icon: 'question',
        text: @json($errors->all()),        
        showConfirmButton: false,
        timer: 10500
    })
    console.log(@json($errors));
</script>
@endif

