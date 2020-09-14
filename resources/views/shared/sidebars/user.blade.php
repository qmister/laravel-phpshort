@section('menu')
    @php
        /**
         * key => [icon, title, route]
         */
        $menu = [
            'dashboard' => ['dashboard', 'Dashboard', 'dashboard'],
            'links' => ['link', 'Links', 'links'],
            'spaces' => ['space', 'Spaces', 'spaces'],
            'domains' => ['domain', 'Domains', 'domains'],
        ];
    @endphp

    @foreach ($menu as $key => $value)
        <li class="nav-item">
            <a class="nav-link d-flex px-4 @if (request()->segment(1) == $key && isset($value[3]) == false) active @endif" @if(isset($value[3])) data-toggle="collapse" href="#subMenu-{{ $key }}" role="button" @if (array_key_exists(request()->segment(3), $value[3])) aria-expanded="true" @else aria-expanded="false" @endif aria-controls="collapse-{{ $key }}" @else href="{{ (Route::has($value[2]) ? route($value[2]) : $value[2]) }}" @endif>
                <span class="sidebar-icon d-flex align-items-center">@include('icons.' . $value[0], ['class' => 'fill-current '.(__('lang_dir') == 'rtl' ? 'ml-3' : 'mr-3')])</span>
                <span class="flex-grow-1">{{ __($value[1]) }}</span>
                @if (isset($value[3])) <span class="ml-auto sidebar-expand">@include('icons.expand', ['class' => 'fill-current text-muted'])</span> @endif
            </a>
        </li>

        @if (isset($value[3]))
            <div class="collapse sub-menu @if (request()->segment(2) == $key) show @endif" id="subMenu-{{ $key }}">
                @foreach ($value[3] as $subKey => $subValue)
                    <a href="{{ (Route::has($subValue[1]) ? route($subValue[1]) : $subValue[1]) }}" class="nav-link @if (request()->segment(3) == $subKey) active @endif">{{ __($subValue[0]) }}</a>
                @endforeach
            </div>
        @endif
    @endforeach
@endsection