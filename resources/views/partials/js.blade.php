<!-- Core JS -->
<script src="{{ asset('templates/assets/js/jquery-3.6.0.min.js') }}"></script>
<script src="{{ asset('templates/assets/js/bootstrap.bundle.min.js') }}"></script>

<!-- jQuery UI Kit -->
<script src="{{ asset('templates/plugins/jquery_ui/jquery-ui.1.12.1.min.js') }}"></script>

<!-- Peity  -->
<script src="{{ asset('templates/plugins/peity/jquery.peity.min.js') }}"></script>
<script src="{{ asset('templates/plugins/peity/piety-init.js') }}"></script>

<!-- Select 2 -->
<script src="{{ asset('templates/plugins/select2/js/select2.min.js') }}"></script>

<!-- Datatables -->
<script src="{{ asset('templates/plugins/datatables/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('templates/plugins/datatables/js/datatables.init.js') }}"></script>

<!-- Date Picker -->
<script src="{{ asset('templates/plugins/flatpickr/flatpickr.min.js') }}"></script>

<!-- Dropzone -->
<script src="{{ asset('templates/plugins/dropzone/dropzone.min.js') }}"></script>
<script src="{{ asset('templates/plugins/dropzone/dropzone_custom.js') }}"></script>

<!-- TinyMCE -->
{{-- <script src="{{ asset('templates/plugins/tinymce/tinymce.min.js') }}"></script>
<script src="{{ asset('templates/plugins/prism/prism.js') }}"></script>
<script src="{{ asset('templates/plugins/jquery-repeater/jquery.repeater.js') }}"></script> --}}


<!-- Sweet Alert -->
<script src="{{ asset('templates/plugins/sweetalert/sweetalert2.min.js') }}"></script>
<script src="{{ asset('templates/plugins/sweetalert/sweetalert2-init.js') }}"></script>
<script src="{{ asset('templates/plugins/nicescroll/jquery.nicescroll.min.js') }}"></script>
<script src="{{ asset('templates/plugins/nicescroll/jquery.nicescroll.min.js') }}"></script>

<!-- Snippets JS -->
<script src="{{ asset('templates/assets/js/snippets.js') }}"></script>

@stack('page_script')

<!-- Theme Custom JS -->
<script src="{{ asset('templates/assets/js/theme.js') }}"></script>

@stack('custom_script')