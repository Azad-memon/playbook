<form id="edit-user-form">
    @csrf
    <div class="alert alert-danger print-error-msg1" style="display:none">
        <ul></ul>
    </div>
    <input type="hidden" id="edit_id" value="{{ $data[0]['id'] }}" />

    <div class="col-md-12 mt-3">
        <x-inputField label='user_name' labelCaption="Enter Name" id="user_name" type="text" name="name"
            placeholder="Enter name" :inputData="$data[0]['name']" />
    </div>
    <div class="col-md-12 mt-3">
        <x-inputField label='user_name' labelCaption="Enter Email" id="user_name" type="email" name="email"
            placeholder="Enter Email" :inputData="$data[0]['email']" />
    </div>
    <div class="col-md-12 mt-3">
        <x-inputField label='user_name' labelCaption="Enter Phone number" id="user_name" type="number"
            name="phone_number" placeholder="Enter Phone number" :inputData="$data[0]['phone_number']" />
    </div>

    <div class="col-md-12 mt-3">
        <x-inputField label='user_name' labelCaption="Create Password" id="user_name" type="text" name="password"
            placeholder="Enter Password" />
    </div>
    <div class="col-md-12 mt-3">
        <x-inputField label='user_name' labelCaption="Confirm Password" id="user_name" type="text"
            name="password_confirmation" placeholder="Enter Password again" />
    </div>


    @if (!empty($positions))
        <div class="col-md-12 mt-3">

            @foreach ($positions as $key => $value)
                @php
                    $options[$value['pos_id']] = $value['name'];
                @endphp
            @endforeach

            @php
                $fetch['options'] = $options;
                $fetch['userSelectedOption']['Key'] = $data[0]['position_id'];
            @endphp

            <x-selectField label='question_type' className="c-select2" labelCaption="Choose Position" name="position_id"
                defaultOption="Select Position" :options="$fetch" />
        </div>
    @endif

    @if (!empty($departments))
        @php
            unset($fetch);
            unset($options);
        @endphp
        <div class="col-md-12 mt-3">
            @foreach ($departments as $key => $value)
                @php
                    $options[$value['id']] = $value['name'];
                @endphp
            @endforeach

            @php
                $fetch['options'] = $options;
                $fetch['userSelectedOption']['Key'] = $data[0]['department_id'];
            @endphp

            <x-selectField label='question_type' className="c-select2" labelCaption="Choose Department"
                name="department_id" defaultOption="Select Department" :options="$fetch" />
        </div>
    @endif


    <div class="col-sm-12 mt-4 text-center">
        <div class="form-group">
            <div class="form-control-wrap">
                <button type="submit" class="btn btn-primary" id="custom-save-button">Update Officer</button>
            </div>
        </div>
    </div>
</form>
