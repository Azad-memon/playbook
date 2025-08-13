<!DOCTYPE html>
<html lang="en">
@include('web.poster.includes.header')
@stack('css')

<body id="body-container" class="bodywraper main-section body-inner-page">
    <div id="bodyinnerinner" class="bodycontent">
        @include('web.poster.includes.topbar')
        @section('body_container')

        @show
        @include('web.panel.includes.bootstrap_modal')
        @include('web.poster.includes.footer')
        @include('web.poster.includes.footer_scripts')
        @stack('custom-scripts')
        @include('web.panel.includes.admin_scripts')
    </div>
</body>


</html>




@if (session('jsonMessage') != '')
    <script>
        jsonMessage("{{ session('response') }}", "{{ session('message') }}");
    </script>
@endif

@if (session('jsonMessage2') != '')
    <script>
        jsonMessage2("{{ session('response') }}", "{{ session('message') }}");
    </script>
@endif
