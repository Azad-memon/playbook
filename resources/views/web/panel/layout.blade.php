<!DOCTYPE html>
<html lang="en">
@include('web.panel.includes.header')
@stack('css')


<body>
    <?php
        $user = Auth::user();
    ?>
    <!-- loader Starts-->
    <div class="loader-wrapper">
        <div class="loader-index"><span></span></div>
        <svg>
            <defs></defs>
            <filter id="goo">
                <fegaussianblur in="SourceGraphic" stddeviation="11" result="blur"></fegaussianblur>
                <fecolormatrix in="blur" values="1 0 0 0 0  0 1 0 0 0  0 0 1 0 0  0 0 0 19 -9" result="goo">
                </fecolormatrix>
            </filter>
        </svg>
    </div>

    <!-- loader ends-->
    <!-- tap on top starts-->
    <div class="tap-top"><i data-feather="chevrons-up"></i></div>

    <div class="page-wrapper compact-wrapper" id="pageWrapper">
        @include('web.panel.includes.topbar')

        <div class="page-body-wrapper">
            @include('web.panel.includes.sidebar',['user' => $user])
            <div class="page-body">
                 <x-breadcrumb :breadcrumb="$breadcrumb" :title="$pageTitle" />
                @section('body_container')

                @show
                @include('web.panel.includes.bootstrap_modal')
            </div>
            @include('web.panel.includes.footer')
        </div>
    </div>
    @include('web.panel.includes.footer_scripts')
    @stack('custom-scripts')
    @include('web.panel.includes.admin_scripts')
    <script src="{{ asset('panel/assets/js/modal-service.js') }}"></script>
</body>
<!-- Common Modal -->
<div class="modal fade custom_modal" id="commonModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="custom_modal-title"></h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body" id="custom_modal_body">
            <div class="text-center p-3">Loading...</div>
        </div>
    </div>
  </div>
</div>
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
