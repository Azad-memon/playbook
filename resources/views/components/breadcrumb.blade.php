<style>
    li.breadcrumb-item a {
        color: #2F2F3B;
    }
</style>

<div class="container-fluid">
    <div class="page-title">
        <div class="row">
            <div class="col-6">
                <h3>{{ $title }}</h3>
            </div>
            <div class="col-6">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="{{ $home }}">
                            <svg class="stroke-icon">
                                <use href="{{ asset('panel/assets/svg/icon-sprite.svg#stroke-home') }}"></use>
                            </svg>
                        </a>
                    </li>

                    @foreach ($inactive as $url => $label)
                        <li class="breadcrumb-item">
                            <a href="{{ $url }}">{{ $label }}</a>
                        </li>
                    @endforeach

                    <li class="breadcrumb-item active">{{ $active }}</li>
                </ol>
            </div>
        </div>
    </div>
</div>
