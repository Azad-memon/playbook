@extends('web/admin/layout')
@push('css')
    <link href="{{ URL::asset('admin-panel/assets/libs/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet"
        type="text/css" />
    <link href="{{ URL::asset('admin-panel/assets/libs/datatables/buttons.bootstrap4.min.css') }}" rel="stylesheet"
        type="text/css" />
    <!-- Responsive datatable examples -->
    <link href="{{ URL::asset('admin-panel/assets/libs/datatables/responsive.bootstrap4.min.css') }}" rel="stylesheet"
        type="text/css" />
    <link href="{{ URL::asset('admin-panel/assets/libs/datatables/buttons.bootstrap4.min.css') }}" rel="stylesheet"
        type="text/css" />
    <!-- Magnific popup -->
    <link href="{{ URL::asset('admin-panel/assets/libs/magnific-popup/magnific-popup.css') }}" rel="stylesheet"
        type="text/css">
    <!-- Bootstrap Toggle CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-toggle/2.2.2/css/bootstrap-toggle.min.css"
        rel="stylesheet">
@endpush

@push('custom-scripts')
    <!-- Required datatable js -->
    <script src="{{ URL::asset('admin-panel/assets/libs/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ URL::asset('admin-panel/assets/libs/datatables/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ URL::asset('admin-panel/assets/libs/datatables/dataTables.responsive.min.js') }}"></script>
    <script src="{{ URL::asset('admin-panel/assets/libs/datatables/dataTables.buttons.min.js') }}"></script>
    <script src="{{ URL::asset('admin-panel/assets/libs/datatables/buttons.bootstrap4.min.js') }}"></script>
    <script src="{{ URL::asset('admin-panel/assets/libs/datatables/jszip.min.js') }}"></script>
    <script src="{{ URL::asset('admin-panel/assets/libs/datatables/pdfmake.min.js') }}"></script>
    <script src="{{ URL::asset('admin-panel/assets/libs/datatables/vfs_fonts.js') }}"></script>
    <script src="{{ URL::asset('admin-panel/assets/libs/datatables/buttons.html5.min.js') }}"></script>
    <script src="{{ URL::asset('admin-panel/assets/libs/datatables/buttons.print.min.js') }}"></script>
    <script src="{{ URL::asset('admin-panel/assets/libs/datatables/buttons.colVis.min.js') }}"></script>
    <!-- Bootstrap Toggle JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-toggle/2.2.2/js/bootstrap-toggle.min.js"></script>
    <!-- Magnific popup -->
    <script src="{{ URL::asset('admin-panel/assets/libs/magnific-popup/jquery.magnific-popup.min.js') }}"></script>
    <script>
        $(document).ready(function() {
            trashedUsers();
        });
    </script>
@endpush










@section('body_container')
    <div class="card m-b-20">
        <div class="card-body">
            <ul class="breadcrumb tw-flex tw-items-center tw-mt-1">
                <li class="breadcrumb-item">
                    <a href="{{ route('superadmin.dashboard') }}">Home</a>
                </li>
                <li class="breadcrumb-item " aria-current="page">
                    <a href="{{ route('superadmin.users') }}">Manage Officers</a>
                    
                </li>
                <li class="breadcrumb-item active" aria-current="page">Trashed Officers</li>
            </ul>
            @include('web.includes.es_msg')
            <div class="row" id="trashed-users">

            </div>
            <bR><br>


        </div>
    </div>
    @include('web.includes.pre_loader')
@endsection
