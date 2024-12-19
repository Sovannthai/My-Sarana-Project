<!DOCTYPE html>
<html lang="en">
@include('backends.layouts.header')
<!-- Toastr CSS -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" rel="stylesheet">
<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<!-- Toastr JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

<body>
    <div class="wrapper">
        <!-- Sidebar -->
        @include('backends.layouts.sidebar')
        <!-- End Sidebar -->

        <div class="main-panel">
            <div class="main-header">
                @include('backends.layouts.navbar')
                <!-- End Navbar -->
            </div>
            <div class="container">
                <div class="page-inner">
                    {{-- <div class="d-flex align-items-left align-items-md-center flex-column flex-md-row pt-2 pb-4">
                            <h3 class="fw-bold mb-3">@yield('content-header')</h3>
                    </div> --}}
                    @yield('contents') <span>
                        <h3>@yield('cotent-header')</h3>
                    </span>
                </div>
            </div>

            <footer class="footer">
                <div class="">
                    <div class="copyright">
                        <div class="text-container">
                            <div class="sliding-text">2024, Sarana Project By <a href="https://github.com/Sovannthai">HE
                                    Sovannthai</a></div>
                        </div>
                    </div>
                </div>
            </footer>
        </div>

        <!-- Custom template | don't include it in your project! -->
        <div class="custom-template">
            {{-- @include('backends.layouts.custom') --}}
        </div>

        <!-- Include jQuery -->
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <!-- Include Bootstrap JS -->
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
        <!-- Include Font Awesome -->
        <script src="https://kit.fontawesome.com/a076d05399.js"></script>
        {{-- Image link preview --}}
        <script src="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.3/js/lightbox.min.js"></script>
        <!-- End Custom template -->
    </div>
    <!--   Core JS Files   -->
    @include('backends.layouts.script')
    <script>
        $(document).ready(function() {
            @if (Session::has('success'))
                toastr.options = {
                    "closeButton": true,
                    "progressBar": true,
                    "timeOut": "5000",
                    "extendedTimeOut": "2000",
                    "positionClass": "toast-top-right"
                };
                toastr.success("{{ Session::get('success') }}");
            @endif
            @if (Session::has('error'))
                toastr.options = {
                    "closeButton": true,
                    "progressBar": true,
                    "timeOut": "5000",
                    "extendedTimeOut": "2000",
                    "positionClass": "toast-top-right"
                };
                toastr.error("{{ Session::get('error') }}");
            @endif
        });
        //Alert and store message get from telegram bot
        // $(document).ready(function() {
        //     const audio = new Audio('{{ asset('uploads/sound/success.mp3') }}');
        //     audio.load();

        //     function playAudio() {
        //         audio.play().catch(function(error) {
        //             console.error('Audio play failed:', error);
        //         });
        //     }

        //     function fetchMessages() {
        //         $.ajax({
        //             url: '{{ route('get-chat-from-user') }}',
        //             method: 'GET',
        //             success: function(data) {
        //                 toastr.options = {
        //                     closeButton: true,
        //                     progressBar: true,
        //                     timeOut: 7000,
        //                     extendedTimeOut: 2000,
        //                     positionClass: "toast-top-right",
        //                 };

        //                 if (data.success) {
        //                     if (data.messages && data.messages.length > 0) {
        //                         playAudio();
        //                         data.messages.forEach(function(message) {
        //                             toastr.info(
        //                                 `New message from ${message.sender}: ${message.text}`
        //                             );
        //                         });
        //                     }
        //                 }
        //             },
        //             error: function(xhr) {
        //                 console.error('Error:', xhr);
        //                 toastr.error('An error occurred while fetching messages.');
        //             }
        //         });
        //     }
        //     $(window).on('click', function() {
        //         playAudio();
        //     });
        //     setInterval(fetchMessages, 2000);
        // });
    </script>
    <script>
        $(document).ready(function() {
            $(document).on('click', '.delete-btn', function(e) {
                e.preventDefault();
                var form = $(this).closest('form');
                Swal.fire({
                    title: "Are you sure?",
                    text: "You won't be able to revert this!",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#3085d6",
                    cancelButtonColor: "#d33",
                    confirmButtonText: "Yes, delete it!"
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit();
                    }
                });
            });
        });
    </script>
    <script>
        $(document).ready(function() {
            $(document).on('click', '.logout', function(e) {
                e.preventDefault();
                var form = $(this).closest('form');
                Swal.fire({
                    title: "Are you sure?",
                    text: "You want to logout?",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#3085d6",
                    cancelButtonColor: "#d33",
                    confirmButtonText: "Logout"
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit();
                    }
                });
            });
        });
    </script>
    <script>
        $(document).ready(function() {
            $("#basic-datatables").DataTable({
                responsive: true,
                pageLength: 10,
                lengthMenu: [5, 10, 20, 50, 100],
                language: {
                    search: "@lang('Search'):",
                    lengthMenu: "@lang('Show _MENU_ entries')",
                    info: "@lang('Showing _START_ to _END_ of _TOTAL_ entries')",
                    infoEmpty: "@lang('No entries available')",
                    paginate: {
                        next: "@lang('Next')",
                        previous: "@lang('Previous')"
                    }
                }
            });

            $("#multi-filter-select").DataTable({
                pageLength: 5,
                initComplete: function() {
                    this.api()
                        .columns()
                        .every(function() {
                            var column = this;
                            var select = $(
                                    '<select class="form-select"><option value=""></option></select>'
                                )
                                .appendTo($(column.footer()).empty())
                                .on("change", function() {
                                    var val = $.fn.dataTable.util.escapeRegex($(this).val());

                                    column
                                        .search(val ? "^" + val + "$" : "", true, false)
                                        .draw();
                                });
                            column
                                .data()
                                .unique()
                                .sort()
                                .each(function(d, j) {
                                    select.append(
                                        '<option value="' + d + '">' + d + "</option>"
                                    );
                                });
                        });
                },
            });
            // Add Row
            $("#add-row").DataTable({
                pageLength: 5,
            });

            var action =
                '<td> <div class="form-button-action"> <button type="button" data-bs-toggle="tooltip" title="" class="btn btn-link btn-primary btn-lg" data-original-title="Edit Task"> <i class="fa fa-edit"></i> </button> <button type="button" data-bs-toggle="tooltip" title="" class="btn btn-link btn-danger" data-original-title="Remove"> <i class="fa fa-times"></i> </button> </div> </td>';

            $("#addRowButton").click(function() {
                $("#add-row")
                    .dataTable()
                    .fnAddData([
                        $("#addName").val(),
                        $("#addPosition").val(),
                        $("#addOffice").val(),
                        action,
                    ]);
                $("#addRowModal").modal("hide");
            });
        });
    </script>
    <script>
        $(document).ready(function() {
            $('#select-all').change(function() {
                $('.switch input[type="checkbox"]').prop('checked', this.checked).change();
            });
        });
    </script>
    <script>
        $(function() {
            $('.select2').select2({
                // allowClear: true
            });
            // $(".thumbnail").fancybox();
            $(document).on("click", ".btn-modal", function(e) {
                e.preventDefault();
                var container = $(this).data("container");

                $.ajax({
                    url: $(this).data("href"),
                    dataType: "html",
                    success: function(result) {
                        $(container).html(result).modal("show");
                        $('.select2').select2();
                    },
                });
            });
            //Initialize Select2 Elements
            $('.select2').select2();
        });
    </script>
    <script>
        $(document).ready(function() {
            $(document).on('shown.bs.modal', '.modal', function() {
                $(this).find('.select2').select2({
                    dropdownParent: $(this)
                });
            });
        });
    </script>
</body>

</html>
