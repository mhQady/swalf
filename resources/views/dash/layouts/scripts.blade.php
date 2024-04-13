@include('sweetalert::alert')
<script>
    const Toast = Swal.mixin({
        toast: true,
        position: @json(app()->getLocale() == 'en' ? "top-end" : "top-start" ),
        showConfirmButton: false,
        timer: 3000,
        timerProgressBar: true,
        didOpen: (toast) => {
            toast.onmouseenter = Swal.stopTimer;
            toast.onmouseleave = Swal.resumeTimer;
        }
    });
</script>
@stack('scripts')