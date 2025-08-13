<div class="row" style="width:100%">
    <div class="col-md-12 text-center">
        <a href="{{ route('superadmin.users') }}" " class="btn btn-primary mt-3 mb-3 me-3">
            <i class="mdi mdi-shape-rectangle-plus"></i>
            <b> Active Officers </b>
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
                        <a href="" id="restore-user" data-id="{{ $value['id'] }}"
                            class="btn btn-primary btn-xs"><i class="fas fa-trash-restore"></i></a>
                    </td>
                </tr>
            @endforeach
            @endif
            </tbody>
            </table>
