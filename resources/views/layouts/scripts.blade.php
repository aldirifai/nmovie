<script src="{{ asset('vendor/jquery/jquery.min.js') }}"></script>
<script src="{{ asset('vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('vendor/bootstrap-datepicker/js/bootstrap-datepicker.min.js') }}"></script>
<script src="{{ asset('vendor/bootstrap-datepicker/locales/bootstrap-datepicker.id.min.js') }}"></script>
<script src="{{ asset('vendor/datatables/datatables.min.js') }}"></script>

<script>
    $('.datepicker').datepicker({
        format: 'yyyy-mm-dd',
        autoclose: true
    });
</script>
