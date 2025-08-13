<link href="{{ URL::asset('admin-panel/assets/css/timepicker.min.css') }}" rel="stylesheet"
type="text/css" />

<script src="{{ URL::asset('admin-panel/assets/js/timepicker.min.js') }}"></script>


    <label for="{{ $name }}">{{ $labelCaption }}</label>
    <div class="input-group">
        <input type="text" id="{{ $name }}" name="{{ $name }}" class="form-control bs-timepicker"
            value="{{ old($name, $value) }}" placeholder="Select Time">
        <span class="input-group-text"><i class="fa fa-clock"></i></span>
    </div>
<script>
  $(function () {
    $('.bs-timepicker').timepicker({
            timeFormat: 'h:i A', 
            interval: 15, 
            minTime: '12:00 AM', 
            maxTime: '11:59 PM', 
            dynamic: false,
            dropdown: true,
            scrollbar: true
        });
  });
</script>
