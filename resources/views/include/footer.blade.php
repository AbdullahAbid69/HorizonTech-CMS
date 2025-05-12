<!-- container-scroller -->

<!-- plugins:js -->
<script src="{{ asset('vendors/js/vendor.bundle.base.js')}}"></script>
<!-- endinject -->
<!-- Plugin js for this page -->
{{--
<script src="{{ asset('vendors/chart.js/Chart.min.js')}}"></script> --}}
<script src="{{ asset('vendors/datatables.net/jquery.dataTables.js')}}"></script>
<script src="{{ asset('vendors/datatables.net-bs4/dataTables.bootstrap4.js')}}"></script>
{{--
<script src="{{ asset('js/dataTables.select.min.js')}}"></script> --}}

<!-- End plugin js for this page -->
<!-- inject:js -->
<script src="{{ asset('js/off-canvas.js')}}"></script>
<script src="{{ asset('js/hoverable-collapse.js')}}"></script>
<script src="{{ asset('js/template.js')}}"></script>
<script src="{{ asset('js/settings.js')}}"></script>
<script src="{{ asset('js/todolist.js')}}"></script>
{{--
<script src={{asset("vendors/select2/select2.min.js")}}></script> --}}
<!-- endinject -->
<!-- Custom js for this page-->
<script src="{{ asset('js/dashboard.js')}}"></script>
<script src="{{ asset('js/Chart.roundedBarCharts.js')}}"></script>
<!-- End custom js for this page-->
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>

@if (Session::has('success'))
    <script>
        toastr.options = {
            "progressBar": true,
            "closeButton": true,
        }
        toastr.success("{{ Session::get('success') }}");
    </script>
@elseif (Session::has('error'))
    <script>
        toastr.options = {
            "progressBar": true,
            "closeButton": true,
        }
        toastr.error("{{ Session::get('error') }}");
    </script>
@endif
</body>

</html>