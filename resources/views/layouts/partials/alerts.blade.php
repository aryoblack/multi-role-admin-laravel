<!-- SweetAlert2 Messages -->
@if(session('success') || session('error') || session('warning') || session('info'))
<script>
document.addEventListener('DOMContentLoaded', function() {
    @if(session('success'))
    Swal.fire({
        icon: 'success',
        title: 'Berhasil!',
        text: '{{ session('success') }}',
        timer: 3000,
        showConfirmButton: false,
        toast: true,
        position: 'top-end',
        timerProgressBar: true,
    });
    @endif

    @if(session('error'))
    Swal.fire({
        icon: 'error',
        title: 'Error!',
        text: '{{ session('error') }}',
        confirmButtonText: 'OK'
    });
    @endif

    @if(session('warning'))
    Swal.fire({
        icon: 'warning',
        title: 'Peringatan!',
        text: '{{ session('warning') }}',
        confirmButtonText: 'OK'
    });
    @endif

    @if(session('info'))
    Swal.fire({
        icon: 'info',
        title: 'Informasi',
        text: '{{ session('info') }}',
        confirmButtonText: 'OK'
    });
    @endif
});
</script>
@endif

