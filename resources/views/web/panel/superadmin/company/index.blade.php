@extends('web/panel/layout')
@push('css')

    <link href="{{ URL::asset('panel/assets/libs/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet"
        type="text/css" />
    <link href="{{ URL::asset('panel/assets/libs/datatables/buttons.bootstrap4.min.css') }}" rel="stylesheet"
        type="text/css" />
    <!-- Responsive datatable examples -->
    <link href="{{ URL::asset('panel/assets/libs/datatables/responsive.bootstrap4.min.css') }}" rel="stylesheet"
        type="text/css" />
    <link href="{{ URL::asset('panel/assets/libs/datatables/buttons.bootstrap4.min.css') }}" rel="stylesheet"
        type="text/css" />
    <!-- Magnific popup -->
    <link href="{{ URL::asset('panel/assets/libs/magnific-popup/magnific-popup.css') }}" rel="stylesheet"
        type="text/css">
    <!-- Bootstrap Toggle CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-toggle/2.2.2/css/bootstrap-toggle.min.css"
        rel="stylesheet">
    <link href="{{ URL::asset('panel/assets/libs/select2/css/select2.min.css') }}" rel="stylesheet" type="text/css" />
    <style>
    .btn-xs {
    padding: 0.25rem 0.4rem !important;
    font-size: 0.75rem !important;
    line-height: 1.2;
    border-radius: 0.2rem;
    }
    .dropdown-menu {
    z-index: 1055 !important;
    }
     .buttons-excel{
        margin-right: 15px;
    }
    #datatable-buttons_paginate{
        padding-bottom: 10px;
        padding-top: 10px;
    }
</style>
@endpush

@section('body_container')
<div class="row">
    {{-- Add Company Button --}}
    {{-- <button  class="btn btn-primary" data-open-modal data-modal-title="Add Company" data-url="{{ route('superadmin.company.add-form') }}">
    Add Company
</button> --}}
    <div class="card">
        <div class="row" style="width:100%">
            <div class="col-md-12 text-center">

                <a href="#" data-open-modal data-modal-title="Add Company" data-url="{{ route('superadmin.company.add-form')}}" class="btn btn-info mt-3 mb-3 me-3">
                    <i class="mdi mdi-shape-rectangle-plus"></i>
                    <b> Add Company </b>
                </a>
            </div>
        </div>

    {{-- Company Table --}}
    <table id="datatable-buttons" class="table table-bordered dt-responsive nowrap">
        <thead>
            <tr>
                <th>Name</th>
                <th>Email</th>
                <th>Admin Email</th>
                <th>Description</th>
                <th>Logo</th>
                <th>Invitation</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($companies as $company)
                <tr data-id="{{ $company->id }}"
                    data-name="{{ $company->name }}"
                    data-email="{{ $company->email }}"
                    data-description="{{ $company->description }}"
                    data-logo="{{ $company->logo }}">
                    <td>{{ $company->name }}</td>
                    <td>{{ $company->email }}</td>
                    <td>{{ $company->adminInvite->email??'' }}</td>
                    <td>{{ $company->description }}</td>
                    <td>
                        @if($company->logo)
                        <div class="custom-image-container">
                            <a class="image-popup-no-margins" href="{{ asset('storage/' . $company->logo) }}">
                            <img src="{{ asset('storage/' . $company->logo) }}" width="50" alt="Logo" class="custom-img-responsive">
                            </a>
                        </div>
                        @endif
                    </td>
                    <td>
                        @if($company->admin_invitation_accepted == 'no')
                           <span class="badge badge-warning">Pending</span>
                        @else
                            <span class="badge badge-success">Accepted</span>
                        @endif
                    </td>
                   <td>
                     <div class="dropdown" data-bs-display="static">
                        <button class="btn btn-xs btn-primary dropdown-toggle" type="button" id="companyActionsDropdown{{ $company->id }}" data-bs-toggle="dropdown" aria-expanded="false">
                            Actions
                        </button>
                        <ul class="dropdown-menu" aria-labelledby="companyActionsDropdown{{ $company->id }}">
                            <li>
                                <button type="button"
                                    class="dropdown-item edit-company"
                                    data-open-modal
                                    data-modal-title="Edit Company"
                                    data-url="{{ route('superadmin.company.edit-form', ['id' => $company->id]) }}">
                                    Edit
                                </button>
                            </li>
                            <li>
                                <form action="{{ route('superadmin.company.destroy', $company->id) }}" method="POST"
                                    onsubmit="return confirm('Are you sure you want to delete this company?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="dropdown-item text-danger">
                                        Delete
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </div>
                </td>

                </tr>
            @endforeach
        </tbody>
    </table>
    </div>
</div>

{{-- Modal Script --}}
@push('custom-scripts')
 <!-- Required datatable js -->
    <script src="{{ URL::asset('panel/assets/libs/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ URL::asset('panel/assets/libs/datatables/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ URL::asset('panel/assets/libs/datatables/dataTables.responsive.min.js') }}"></script>
    <script src="{{ URL::asset('panel/assets/libs/datatables/dataTables.buttons.min.js') }}"></script>
    <script src="{{ URL::asset('panel/assets/libs/datatables/buttons.bootstrap4.min.js') }}"></script>
    <script src="{{ URL::asset('panel/assets/libs/datatables/jszip.min.js') }}"></script>
    <script src="{{ URL::asset('panel/assets/libs/datatables/pdfmake.min.js') }}"></script>
    <script src="{{ URL::asset('panel/assets/libs/datatables/vfs_fonts.js') }}"></script>
    <script src="{{ URL::asset('panel/assets/libs/datatables/buttons.html5.min.js') }}"></script>
    <script src="{{ URL::asset('panel/assets/libs/datatables/buttons.print.min.js') }}"></script>
    <script src="{{ URL::asset('panel/assets/libs/datatables/buttons.colVis.min.js') }}"></script>
    <!-- Bootstrap Toggle JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-toggle/2.2.2/js/bootstrap-toggle.min.js"></script>
    <!-- Magnific popup -->
    <script src="{{ URL::asset('panel/assets/libs/magnific-popup/jquery.magnific-popup.min.js') }}"></script>
    <script src="{{ URL::asset('panel/assets/libs/select2/js/select2.full.min.js') }}"></script>
    <script src="{{ URL::asset('panel/assets/js/lightbox.js') }}"></script>
    @include('web.panel.includes.super_admin_scripts')
<script>
$(document).ready(function() {
    applyDataTables();

});

</script>
@endpush
@endsection
