@extends('layout.app')

@push('custom_css')
    <style>
        #videotron_background_image_preview,
        #visitor_background_image_preview {
            margin-top: 10px;
            max-width: 100%;
            border-radius: 5px;
        }
    </style>
@endpush

@section('main')
<main class="main-wrapper">
    <div class="container-fluid">
        <form id="eventForm" action="{{ route('all-event.add-action') }}" method="post" autocomplete="off" enctype="multipart/form-data">
            @csrf
            <div class="inner-contents">
                <div class="page-header d-flex align-items-center justify-content-between mr-bottom-30">
                    <div class="left-part">
                        <h2 class="text-dark">Add New Event</h2>
                    </div>
                    <div class="right-part">
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </div>
                    </div>
                </div>
                <div class="card border-0">
                    <div class="card-header bg-transparent border-0 p-5 pb-0">
                        <h5 class="mb-0">General Information</h5>
                    </div>
                    <div class="card-body pt-3">
                        <div class="row">
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label for="name" class="form-label @if ($errors->has('name')) text-danger @elseif(old('name') && !$errors->has('name')) text-success @endif">Name</label>
                                    <br>
                                    <input type="text" class="form-control @if ($errors->has('name')) is-invalid text-danger @elseif(old('name') && !$errors->has('name')) is-valid text-success @endif" id="name" value="{{ old('name') }}" name="name" placeholder="Event Name">
                                    @error('name')
                                        <small class="mt-2 text-danger float-start col-sm-12">
                                            {{ $message }}
                                        </small>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="date" class="form-label @if ($errors->has('date')) text-danger @elseif(old('date') && !$errors->has('date')) text-success @endif">Event Date</label>
                                    <input type="text" class="form-control @if ($errors->has('date')) is-invalid text-danger @elseif(old('date') && !$errors->has('date')) is-valid text-success @endif" id="date" name="date" placeholder="Event Date" value="{{ old('date') }}">
                                    @error('date')
                                        <small class="mt-2 text-danger float-start col-sm-12">
                                            {{ $message }}
                                        </small>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label for="time_start" class="form-label @if ($errors->has('time_start')) text-danger @elseif(old('time_start') && !$errors->has('time_start')) text-success @endif">Event Time Start</label>
                                    <input type="text" class="form-control @if ($errors->has('time_start')) is-invalid text-danger @elseif(old('time_start') && !$errors->has('time_start')) is-valid text-success @endif" id="time_start" name="time_start" placeholder="Event Time Start" value="{{ old('time_start') }}">
                                    @error('time_start')
                                        <small class="mt-2 text-danger float-start col-sm-12">
                                            {{ $message }}
                                        </small>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="time_end" class="form-label @if ($errors->has('time_end')) text-danger @elseif(old('time_end') && !$errors->has('time_end')) text-success @endif">Event Tim End</label>
                                    <input type="text" class="form-control @if ($errors->has('time_end')) is-invalid text-danger @elseif(old('time_end') && !$errors->has('time_end')) is-valid text-success @endif" id="time_end" name="time_end" placeholder="Event Time End" value="{{ old('time_end') }}">
                                    @error('time_end')
                                        <small class="mt-2 text-danger float-start col-sm-12">
                                            {{ $message }}
                                        </small>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label for="" class="form-label">Use Table Code Before Send Message ?</label>
                                    <div class="d-flex gap-2">
                                        <div class="form-check">
                                            <label class="form-check-label">
                                                <input type="radio" class="form-check-input" name="status_table_security" id="status_table_security_true" value="true" {{ old('status_table_security') ? (old('status_table_security') === 'true' ? 'checked' : '') : '' }}>Yes</label>
                                        </div>
                                        <div class="form-check">
                                            <label class="form-check-label">
                                                <input type="radio" class="form-check-input" name="status_table_security" id="status_table_security_false" value="false" {{ old('status_table_security') ? (old('status_table_security') === 'false' ? 'checked' : '') : '' }}>No</label>
                                        </div>
                                    </div>
                                    @error('status_table_security')
                                        <small class="mt-2 text-danger float-start col-sm-12">
                                            {{ $message }}
                                        </small>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="card border-0">
                    <div class="card-header bg-transparent border-0 p-5 pb-0">
                        <div class="d-flex justify-content-between">
                            <h5 class="mb-0">Settings : Message Bubble</h5>
                            <button id="defaultBtnBubble" type="button" class="btn btn-sm btn-info">Use Default Style</button>
                        </div>
                    </div>
                    <div class="card-body pt-3">
                        <div class="row">
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label for="bubble_color_code_message_name" class="form-label @if ($errors->has('bubble_color_code_message_name')) text-danger @elseif(old('bubble_color_code_message_name') && !$errors->has('bubble_color_code_message_name')) text-success @endif">Color of Name Message Sender:</label>
                                    <br>
                                    <input class="form-control" id="bubble_color_code_message_name" name="bubble_color_code_message_name" data-jscolor="{value:'', position:'bottom', height:80, backgroundColor:'#333', palette:'rgba(0,0,0,0) #fff #808080 #000 #996e36 #f55525 #ffe438 #88dd20 #22e0cd #269aff #bb1cd4', paletteCols:11, hideOnPaletteClick:true}">
                                    @error('bubble_color_code_message_name')
                                        <small class="mt-2 text-danger float-start col-sm-12">
                                            {{ $message }}
                                        </small>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="bubble_color_code_message_time" class="form-label @if ($errors->has('bubble_color_code_message_time')) text-danger @elseif(old('bubble_color_code_message_time') && !$errors->has('bubble_color_code_message_time')) text-success @endif">Color of Time Message:</label>
                                    <br>
                                    <input class="form-control" id="bubble_color_code_message_time" name="bubble_color_code_message_time" data-jscolor="{value:'', position:'bottom', height:80, backgroundColor:'#333', palette:'rgba(0,0,0,0) #fff #808080 #000 #996e36 #f55525 #ffe438 #88dd20 #22e0cd #269aff #bb1cd4', paletteCols:11, hideOnPaletteClick:true}">
                                    @error('bubble_color_code_message_time')
                                        <small class="mt-2 text-danger float-start col-sm-12">
                                            {{ $message }}
                                        </small>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label for="bubble_color_code_message_text" class="form-label @if ($errors->has('bubble_color_code_message_text')) text-danger @elseif(old('bubble_color_code_message_text') && !$errors->has('bubble_color_code_message_text')) text-success @endif">Color of Message Text:</label>
                                    <br>
                                    <input class="form-control" id="bubble_color_code_message_text" name="bubble_color_code_message_text" data-jscolor="{value:'', position:'bottom', height:80, backgroundColor:'#333', palette:'rgba(0,0,0,0) #fff #808080 #000 #996e36 #f55525 #ffe438 #88dd20 #22e0cd #269aff #bb1cd4', paletteCols:11, hideOnPaletteClick:true}">
                                    @error('bubble_color_code_message_text')
                                        <small class="mt-2 text-danger float-start col-sm-12">
                                            {{ $message }}
                                        </small>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="bubble_color_code_message_background" class="form-label @if ($errors->has('bubble_color_code_message_background')) text-danger @elseif(old('bubble_color_code_message_background') && !$errors->has('bubble_color_code_message_background')) text-success @endif">Color of Message Bubble:</label>
                                    <br>
                                    <input class="form-control" id="bubble_color_code_message_background" name="bubble_color_code_message_background" data-jscolor="{value:'', position:'bottom', height:80, backgroundColor:'#333', palette:'rgba(0,0,0,0) #fff #808080 #000 #996e36 #f55525 #ffe438 #88dd20 #22e0cd #269aff #bb1cd4', paletteCols:11, hideOnPaletteClick:true}">
                                    @error('bubble_color_code_message_background')
                                        <small class="mt-2 text-danger float-start col-sm-12">
                                            {{ $message }}
                                        </small>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label for="bubble_message_font_size" class="form-label @if ($errors->has('bubble_message_font_size')) text-danger @elseif(old('bubble_message_font_size') && !$errors->has('bubble_message_font_size')) text-success @endif">Size of Message Text:</label>
                                    <div class="input-group">
                                        <input id="bubble_message_font_size" type="number" class="form-control @if ($errors->has('bubble_message_font_size')) is-invalid text-danger @elseif(old('bubble_message_font_size') && !$errors->has('bubble_message_font_size')) is-valid text-success @endif" name="bubble_message_font_size" value="" min="16">
                                        <span class="badge d-flex align-items-center text-blue py-2 px-3 fs-16"><blockquote class="blockquote mb-0">px</blockquote></span>
                                    </div>
                                    @error('bubble_message_font_size')
                                        <small class="mt-2 text-danger float-start col-sm-12">
                                            {{ $message }}
                                        </small>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="bubble_message_width" class="form-label @if ($errors->has('bubble_message_width')) text-danger @elseif(old('bubble_message_width') && !$errors->has('bubble_message_width')) text-success @endif">Width of Message Bubble:</label>
                                    <div class="input-group">
                                        <input id="bubble_message_width" type="number" class="form-control @if ($errors->has('bubble_message_width')) is-invalid text-danger @elseif(old('bubble_message_width') && !$errors->has('bubble_message_width')) is-valid text-success @endif" name="bubble_message_width" value="" min="250">
                                        <span class="badge d-flex align-items-center text-blue py-2 px-3 fs-16"><blockquote class="blockquote mb-0">px</blockquote></span>
                                    </div>
                                    @error('bubble_message_width')
                                        <small class="mt-2 text-danger float-start col-sm-12">
                                            {{ $message }}
                                        </small>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-6">
                        <div class="card border-0">
                            <div class="card-header bg-transparent border-0 p-5 pb-0">
                                <div class="d-flex justify-content-between">
                                    <h5 class="mb-0">Settings : Videotron View</h5>
                                    <button id="defaultBtnVideotron" type="button" class="btn btn-sm btn-info">Use Default Style</button>
                                </div>
                            </div>
                            <div class="card-body pt-3">
                                <div class="row">
                                    <div class="form-group">
                                        <label for="" class="@if ($errors->has('videotron_flag_background')) text-danger @elseif(old('videotron_flag_background') && !$errors->has('videotron_flag_background')) text-success @endif">Background Image / Background Color:</label>
                                        <div class="d-flex align-items-center" style="gap:0.5rem;">
                                            <div class="form-check">
                                                <label class="form-check-label">
                                                    <input type="radio" class="form-check-input" name="videotron_flag_background" id="videotron_flag_background_image" value="image">Use Image as Background</label>
                                            </div>
                                            <div class="form-check">
                                                <label class="form-check-label">
                                                    <input type="radio" class="form-check-input" name="videotron_flag_background" id="videotron_flag_background_color" value="color">Use Color as Background</label>
                                            </div>
                                        </div>
                                        @if (old('videotron_flag_background') && !$errors->has('videotron_flag_background'))
                                            <small class="mt-2 text-warning float-start col-sm-12">
                                                Please re-select again.
                                            </small>
                                        @endif
                                        @error('videotron_flag_background')
                                            <small class="mt-2 text-danger float-start col-sm-12">
                                                {{ $message }}
                                            </small>
                                        @enderror
                                    </div>
                                    <div id="videotron-input-container"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-lg-6">
                        <div class="card border-0">
                            <div class="card-header bg-transparent border-0 p-5 pb-0">
                                <div class="d-flex justify-content-between">
                                    <h5 class="mb-0">Settings : Visitor View</h5>
                                    <button id="defaultBtnVisitor" type="button" class="btn btn-sm btn-info">Use Default Style</button>
                                </div>
                            </div>
                            <div class="card-body pt-3">
                                <div class="row">
                                    <div class="form-group">
                                        <label for="" class="@if ($errors->has('visitor_flag_background')) text-danger @elseif(old('visitor_flag_background') && !$errors->has('visitor_flag_background')) text-success @endif">Background Image / Background Color:</label>
                                        <div class="d-flex align-items-center" style="gap:0.5rem;">
                                            <div class="form-check">
                                                <label class="form-check-label">
                                                    <input type="radio" class="form-check-input" name="visitor_flag_background" id="visitor_flag_background_image" value="image">Use Image as Background</label>
                                            </div>
                                            <div class="form-check">
                                                <label class="form-check-label">
                                                    <input type="radio" class="form-check-input" name="visitor_flag_background" id="visitor_flag_background_color" value="color">Use Color as Background</label>
                                            </div>
                                        </div>
                                        @if (old('visitor_flag_background') && !$errors->has('visitor_flag_background'))
                                            <small class="mt-2 text-warning float-start col-sm-12">
                                                Please re-select again.
                                            </small>
                                        @endif
                                        @error('visitor_flag_background')
                                            <small class="mt-2 text-danger float-start col-sm-12">
                                                {{ $message }}
                                            </small>
                                        @enderror
                                    </div>
                                    <div id="visitor-input-container"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</main>
@endsection

@push('page_script')
<script src="{{ asset('templates/plugins/moment/moment-with-locales.js') }}"></script>
<script src="{{ asset('templates/plugins/datetimepicker/jquery.datetimepicker.full.min.js') }}"></script>
<script src="{{ asset('templates/plugins/jscolor-2.5.2/jscolor.js') }}"></script>
@endpush


@push('custom_script')
    <script>
        // DateTimepicker
        $('#date').datetimepicker({
            datepicker: true,
            timepicker: false,
            format: 'Y-m-d',
            theme: 'dark',
            scrollMonth: false,
            scrollInput: false
        });
        $('#time_start').datetimepicker({
            datepicker: false,
            format: 'H:i',
            step: 1,
            theme: 'dark'
        });
        $('#time_end').datetimepicker({
            datepicker: false,
            format: 'H:i',
            step: 1,
            theme: 'dark'
        });
        // DateTimepicker

        // JSCOLOR
        jscolor.presets.default = {
            position: 'right',
            palette: [
                '#000000', '#7d7d7d', '#870014', '#ec1c23', '#ff7e26',
                '#fef100', '#22b14b', '#00a1e7', '#3f47cc', '#a349a4',
                '#ffffff', '#c3c3c3', '#b87957', '#feaec9', '#ffc80d',
                '#eee3af', '#b5e61d', '#99d9ea', '#7092be', '#c8bfe7',
            ],
        };
        // JSCOLOR

        document.addEventListener('DOMContentLoaded', function() {
            // Videotron
            $('#defaultBtnVideotron').click(function() {
                $.ajax({
                    url: '{{ route("all-event.set-default-style") }}',
                    type: 'GET',
                    success: function(response) {
                        if (response.videotron_flag_background === 'color') {
                            $('#videotron_flag_background_color').prop('checked', true);
                        }
                        updateInputFieldVideotron(response);
                    },
                    error: function(xhr, status, error) {
                        console.error('An error occurred:', error);
                    }
                });
            });

            $('input[name="videotron_flag_background"]').change(function() {
                updateInputFieldVideotron();
            });

            function updateInputFieldVideotron(response = []) {
                const inputContainerVideotron = $('#videotron-input-container');
                inputContainerVideotron.empty();

                if ($('#videotron_flag_background_image').is(':checked')) {
                    inputContainerVideotron.append(`
                    <div class="form-group">
                        <label for="videotron_background_image">File Background Image: <br><small class="text-info">(*file size must be less than 3MB)</small></label>
                        <input type="file" class="form-control" id="videotron_background_image" name="videotron_background_image" placeholder="File Background Image" accept="image/*" onchange="showImagePreviewVideotron(event)">
                        <img id="videotron_background_image_preview" src="#" alt="" style="display: none;" />
                    </div>
                `);
                } else if ($('#videotron_flag_background_color').is(':checked')) {
                    inputContainerVideotron.append(`
                    <div class="form-group">
                        <label for="videotron_background_color">Background Color Code:</label>
                        <input name="videotron_color_code" class="form-control" data-jscolor="{value:'${response.videotron_color_code}', position:'bottom', height:80, backgroundColor:'#333',
                          palette:'rgba(0,0,0,0) #fff #808080 #000 #996e36 #f55525 #ffe438 #88dd20 #22e0cd #269aff #bb1cd4',
                          paletteCols:11, hideOnPaletteClick:true}">
                    </div>
                `);
                    jscolor.install();
                }
            }

            // Visitor
            $('#defaultBtnVisitor').click(function() {
                $.ajax({
                    url: '{{ route("all-event.set-default-style") }}',
                    type: 'GET',
                    success: function(response) {
                        if (response.visitor_flag_background === 'color') {
                            $('#visitor_flag_background_color').prop('checked', true);
                        }
                        updateInputFieldVisitor(response);
                    },
                    error: function(xhr, status, error) {
                        console.error('An error occurred:', error);
                    }
                });
            });

            $('input[name="visitor_flag_background"]').change(function() {
                updateInputFieldVisitor();
            });

            function updateInputFieldVisitor(response = []) {
                const inputContainerVisitor = $('#visitor-input-container');
                inputContainerVisitor.empty();

                if ($('#visitor_flag_background_image').is(':checked')) {
                    inputContainerVisitor.append(`
                    <div class="form-group">
                        <label for="visitor_background_image">File Background Image: <br><small class="text-info">(*file size must be less than 3MB)</small></label>
                        <input type="file" class="form-control" id="visitor_background_image" name="visitor_background_image" placeholder="File Background Image" accept="image/*" onchange="showImagePreviewVisitor(event)">
                        <img id="visitor_background_image_preview" src="#" alt="" style="display: none;" />
                    </div>
                `);
                } else if ($('#visitor_flag_background_color').is(':checked')) {
                    inputContainerVisitor.append(`
                    <div class="form-group">
                        <label for="visitor_color_code">Background Color Code:</label>
                        <input name="visitor_color_code" class="form-control" data-jscolor="{value:'${response.visitor_color_code}', position:'bottom', height:80, backgroundColor:'#333',
                          palette:'rgba(0,0,0,0) #fff #808080 #000 #996e36 #f55525 #ffe438 #88dd20 #22e0cd #269aff #bb1cd4',
                          paletteCols:11, hideOnPaletteClick:true}">
                    </div>
                `);
                    jscolor.install();
                }
            }

            // Bubble
            $('#defaultBtnBubble').click(function() {
                $.ajax({
                    url: '{{ route("all-event.set-default-style") }}',
                    type: 'GET',
                    success: function(response) {
                        $('#bubble_color_code_message_name')[0].jscolor.fromString(response
                            .bubble_color_code_message_name);
                        $('#bubble_color_code_message_time')[0].jscolor.fromString(response
                            .bubble_color_code_message_time);
                        $('#bubble_color_code_message_text')[0].jscolor.fromString(response
                            .bubble_color_code_message_text);
                        $('#bubble_color_code_message_background')[0].jscolor.fromString(
                            response
                            .bubble_color_code_message_background);
                        $('#bubble_message_font_size').val(response.bubble_message_font_size);
                        $('#bubble_message_width').val(response.bubble_message_width);
                    },
                    error: function(xhr, status, error) {
                        console.error('An error occurred:', error);
                    }
                });
            });

        });
        
        
        $('#eventForm').on('submit', function(e) {
            e.preventDefault();
            swal({
                title: 'Are you sure?',
                text: "Do you want to submit the form?",
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, submit it!',
                cancelButtonText: 'Cancel'
            }).then((result) => {
                if (result.value) {
                    this.submit();
                }
            });
        });

        function showImagePreviewVideotron(event) {
            const reader = new FileReader();
            reader.onload = function() {
                const output = document.getElementById('videotron_background_image_preview');
                output.src = reader.result;
                output.style.display = 'block';
            };
            reader.readAsDataURL(event.target.files[0]);
        }

        function showImagePreviewVisitor(event) {
            const reader = new FileReader();
            reader.onload = function() {
                const output = document.getElementById('visitor_background_image_preview');
                output.src = reader.result;
                output.style.display = 'block';
            };
            reader.readAsDataURL(event.target.files[0]);
        }
    </script>
@endpush