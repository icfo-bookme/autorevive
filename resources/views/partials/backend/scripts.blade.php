<script src="{{ asset('assets/js/jquery.min.js') }}"></script>
<script src="{{ asset('assets/js/popper.min.js') }}"></script>
<script src="{{ asset('assets/js/bootstrap.min.js') }}"></script>
<!-- alertfy -->
<script src="{{ asset('assets/plugins/alertfy/alertify.min.js') }}"></script>
<!-- simplebar js -->
<script src="{{ asset('assets/plugins/simplebar/js/simplebar.js') }}"></script>
<!-- sidebar-menu js -->
<script src="{{ asset('assets/js/sidebar-menu.js') }}"></script>
<!-- loader scripts -->
<!-- <script src="assets/js/jquery.loading-indicator.html"></script> -->
<!-- Custom scripts -->
<script src="{{ asset('assets/js/app-script.js') }}"></script>

<!-- Chart js -->

<script src="{{ asset('assets/plugins/Chart.js/Chart.min.js') }}"></script>
<!-- Vector map JavaScript -->
<script src="{{ asset('assets/plugins/vectormap/jquery-jvectormap-2.0.2.min.js') }}"></script>
<script src="{{ asset('assets/plugins/vectormap/jquery-jvectormap-world-mill-en.js') }}"></script>
<!-- Easy Pie Chart JS -->
<script src="{{ asset('assets/plugins/jquery.easy-pie-chart/jquery.easypiechart.min.js') }}"></script>
<!-- Sparkline JS -->
<script src="{{ asset('assets/plugins/sparkline-charts/jquery.sparkline.min.js') }}"></script>
<script src="{{ asset('assets/plugins/jquery-knob/excanvas.js') }}"></script>
<script src="{{ asset('assets/plugins/jquery-knob/jquery.knob.js') }}"></script>

<!--Data Tables js-->
<script src="{{ asset('assets/plugins/bootstrap-datatable/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('assets/plugins/bootstrap-datatable/js/dataTables.bootstrap4.min.js') }}"></script>
<script src="{{ asset('assets/plugins/bootstrap-datatable/js/dataTables.buttons.min.js') }}"></script>
<script src="{{ asset('assets/plugins/bootstrap-datatable/js/buttons.bootstrap4.min.js') }}"></script>
<script src="{{ asset('assets/plugins/bootstrap-datatable/js/jszip.min.js') }}"></script>
<script src="{{ asset('assets/plugins/bootstrap-datatable/js/pdfmake.min.js') }}"></script>
<script src="{{ asset('assets/plugins/bootstrap-datatable/js/vfs_fonts.js') }}"></script>
<script src="{{ asset('assets/plugins/bootstrap-datatable/js/buttons.html5.min.js') }}"></script>
<script src="{{ asset('assets/plugins/bootstrap-datatable/js/buttons.print.min.js') }}"></script>
<script src="{{ asset('assets/plugins/bootstrap-datatable/js/buttons.colVis.min.js') }}"></script>

<!-- SELECT2 -->
<script src="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/js/select2.min.js"></script>


<!-- include summernote css/js -->
<link href="https://cdn.jsdelivr.net/npm/summernote@0.8.16/dist/summernote.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.16/dist/summernote.min.js"></script>


<script>
    $(function() {
        $(".knob").knob();
    });
    // $(document).ready(function() {
    //     // $(document).on('show.bs.modal', '#invoiceModal', function(e) {
    //     //     console.log($('#invoiceModal').data('showRelatedTarget'));
    //     // });
    //     $('#invoiceModal').on('hidden.bs.modal', function() {
    //       alert("111111")
    //     });
    // });
    let invoiceNumber;
    function getUserData(id){
      invoiceNumber= id; 
      console.log("kawsarrrrrrrrrr", id);
    }
    // $('#invoiceModal').on('hidden.bs.modal', function() {
    //     getinvoiceListHistory(invoiceNumber);
    // });
</script>
