<div class="row" style="width:100%">
    <div class="col-md-12 text-center">
        <a href="#" id="add-user" class="btn btn-primary mt-3 mb-3 me-3">
            <i class="mdi mdi-shape-rectangle-plus"></i>
            <b> Add Officer </b>
        </a>
        <a href="{{ route('superadmin.users.trash') }}" class="btn btn-warning mt-3 mb-3">
            <i class="mdi mdi-delete"></i>
            <b> Trash Officers </b>
        </a>
    </div>
</div>


<table id="datatable-buttons" class="table table-bordered dt-responsive nowrap"
    style="border-collapse: collapse; border-spacing: 0; width: 100%;">
    <thead>
        <tr>
            <th style="max-width:50px">Sr. No.</th>
            <th style="max-width:250px">Name</th>
            <th style="max-width:100px">Email</th>
            <th style="max-width:100px">Phone #</th>
            <th style="max-width:100px">Department</th>
            <th style="max-width:100px">Position</th>
            <th style="max-width:100px">Status</th>
            <th style="max-width:100px">Action</th>
        </tr>
    </thead>
    <tbody>
        @if (!empty($data))
            <?php $serial = 1; ?>
            @foreach ($data as $value)
                <tr>
                    <td>{{ $serial++ }}</td>

                    <td>{{ $value['name'] }}</td>
                    <td>{{ $value['email'] }}</td>
                    <td>{{ $value['phone_number'] }}</td>
                    <td>
                        @if (!empty($value['get_department']))
                            {{$value['get_department']['name']}}
                        @else
                            -
                        @endif
                    </td>
                   <td>
                        @if (!empty($value['get_position']))
                            {{$value['get_position']['name']}}
                        @else
                            -
                        @endif
                    </td>

                    <td>
                        <input type="checkbox" class="c-toggle-status" id="c-user-toggle" data-id="{{ $value['id'] }}"
                            @if ($value['is_active'] == 1) checked @endif data-toggle="toggle" data-on="Active"
                            data-off="Inactive" data-onstyle="success" data-offstyle="danger">
                    </td>
                    <td>

                        <a href="" id="edit-user" data-id="{{ $value['id'] }}" class="btn btn-primary btn-xs"><i
                                class="ti-pencil-alt"></i></a>
                        <a href="" id="trash-user" data-id="{{ $value['id'] }}" class="btn btn-danger btn-xs"><i
                                class="ti-trash"></i></a>
                    </td>
                </tr>
            @endforeach
        @endif
    </tbody>
</table>
<script src="{{ URL::asset('admin-panel/assets/js/lightbox.js') }}"></script>
