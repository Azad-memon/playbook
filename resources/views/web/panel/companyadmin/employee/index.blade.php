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
</style>
@endpush

@section('body_container')
<div class="container">
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    {{-- Add Company Button --}}
    <button  class="btn btn-primary" data-open-modal data-modal-title="Add Employee" data-url="{{ route('admin.company-employee.add-form',['company_id' => $company_id]) }}">
    Add Employee
</button>

    {{-- Company Table --}}
    <table id="company-employees-table" class="table table-bordered dt-responsive nowrap">
        <thead>
            <tr>
                <th>Name</th>
                <th>Email</th>
                <th>Description</th>
                <th>Logo</th>
                <th>Invitation</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>

            @forelse($employees as $employee)
                <tr data-id="{{ $employee->id }}"
                    data-name="{{ $employee->name }}"
                    data-email="{{ $employee->email }}"
                    data-description="{{ $employee->description }}"
                    data-logo="{{ $employee->logo }}">
                    <td>{{ $employee->name }}</td>
                    <td>{{ $employee->email }}</td>
                    <td>{{ $employee->description }}</td>
                    <td>
                        @if($employee->logo)
                            <img src="{{ asset('storage/' . $employee->logo) }}" width="50" alt="Logo">
                        @endif
                    </td>
                    <td>
                         @if($employee->accepted_at == null)
                           <span class="badge badge-warning">Pending</span>
                        @else
                            <span class="badge badge-success">Accepted</span>
                        @endif
                    </td>
                   <td>
                      <div class="dropdown" data-bs-display="static">
                        <button class="btn btn-xs btn-primary dropdown-toggle" type="button" id="companyActionsDropdown{{ $employee->id }}" data-bs-toggle="dropdown" aria-expanded="false">
                            Actions
                        </button>
                        <ul class="dropdown-menu" aria-labelledby="companyActionsDropdown{{ $employee->id }}">
                            <li>
                                <button type="button"
                                    class="dropdown-item edit-company"
                                    data-open-modal
                                    data-modal-title="Edit Company"
                                    data-url="{{ route('admin.company-employee.edit-form', ['id' => $employee->id]) }}">
                                    Edit
                                </button>
                            </li>
                            <li>
                                <form action="{{ route('admin.employee.destroy', $employee->id) }}" method="POST"
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
                @empty
             @endforelse
        </tbody>
    </table>
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
    @include('web.panel.includes.super_admin_scripts')
<script>
$(document).ready(function() {
    // manageUsers();
    var table = $('#company-employees-table').DataTable({
        destroy : true
        });

});

</script>
@endpush
@endsection
