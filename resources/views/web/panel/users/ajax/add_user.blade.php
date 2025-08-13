<form id="add-user-form">
    @csrf
    <div class="alert alert-danger print-error-msg1" style="display:none">
        <ul></ul>
    </div>


    <div class="col-md-12 mt-3">
        <x-inputField label='user_name' labelCaption="Enter Name" id="user_name" type="text" name="name"
            placeholder="Enter name" />
    </div>
    <div class="col-md-12 mt-3">
        <x-inputField label='user_name' labelCaption="Enter Email" id="user_name" type="email" name="email"
            placeholder="Enter Email" />
    </div>
    <div class="col-md-12 mt-3">
        <x-inputField label='user_name' labelCaption="Enter Phone number" id="user_name" type="number"
            name="phone_number" placeholder="Enter Phone number" />
    </div>

    <div class="col-md-12 mt-3">
        <x-inputField label='user_name' labelCaption="Create Password" id="user_name" type="text" name="password"
            placeholder="Enter Password" />
    </div>
    <div class="col-md-12 mt-3">
        <x-inputField label='user_name' labelCaption="Confirm Password" id="user_name" type="text"
            name="password_confirmation" placeholder="Enter Password again" />
    </div>
    @if (!empty($data['positions']))
        <div class="col-md-12 mt-3">

            @foreach ($data['positions'] as $key => $value)
                @php
                    $options[$value['pos_id']] = $value['name'];
                @endphp
            @endforeach

            @php
                $fetch['options'] = $options;
            @endphp

            <x-selectField label='question_type' className="c-select2" labelCaption="Choose Position" name="position_id"
                defaultOption="Select Position" :options="$fetch" />
        </div>
    @endif

     @if (!empty($data['departments']))
        <div class="col-md-12 mt-3">
            @php
                unset($fetch);
                 unset($options);
            @endphp
            @foreach ($data['departments'] as $key => $value)
                @php
                    $options[$value['id']] = $value['name'];
                @endphp
            @endforeach

            @php
                $fetch['options'] = $options;
            @endphp

            <x-selectField label='question_type' className="c-select2" labelCaption="Choose Department" name="department_id"
                defaultOption="Select Department" :options="$fetch" />
        </div>
    @endif




    <div class="col-sm-12 mt-4 text-center">
        <div class="form-group">
            <div class="form-control-wrap">
                <button type="submit" class="btn btn-primary" id="custom-save-button">Add Officer</button>
            </div>
        </div>
    </div>
</form>
