@if(session('toast'))
    <div class="position-relative position-lg-fixed z-1001" style="top: 0; {{ (__('lang_dir') == 'rtl' ? 'left' : 'right') }}: 0;">
        @foreach(session('toast') as $link)
            <div aria-live="polite" aria-atomic="true" class="position-relative">
                <div class="toast fade show border-0 font-size-base mx-lg-3 shadow-sm shadow-lg- mt-3 overflow-hidden" role="alert" aria-live="assertive" aria-atomic="true" data-autohide="false" style="max-width: inherit;">
                    <div class="toast-header px-1 py-2">
                        <div class="d-flex align-items-center px-2">@include('icons.link', ['class' => 'fill-current icon-label'])</div>
                        <div class="{{ (__('lang_dir') == 'rtl' ? 'ml-auto' : 'mr-auto') }}">{{ __('Link shortened') }}</div>
                        <button type="button" class="close d-flex align-items-center justify-content-center p-2" data-dismiss="toast" aria-label="Close">
                            <span aria-hidden="true" class="d-flex align-items-center">@include('icons.close', ['class' => 'fill-current icon-close'])</span>
                        </button>
                    </div>
                    <div class="toast-body">
                        <div class="row">
                            <div class="col d-flex">
                                <div class="{{ (__('lang_dir') == 'rtl' ? 'ml-2' : 'mr-2') }}"><img src="https://icons.duckduckgo.com/ip3/{{ parse_url($link->url)['host'] }}.ico" rel="noreferrer" class="icon-label"></div>

                                <div class="text-truncate">
                                    <a href="{{ route('stats', $link->id) }}" dir="ltr">{{ str_replace(['http://', 'https://'], '', (($link->domain->name ?? config('app.url')) .'/'.$link->alias)) }}</a>

                                    <div class="text-dark text-truncate small">
                                        <span class="text-secondary cursor-help" data-toggle="tooltip-url" title="{{ $link->url }}">@if($link->title){{ $link->title }}@else<span dir="ltr">{{ str_replace(['http://', 'https://'], '', $link->url) }}</span>@endif</span>
                                    </div>
                                </div>
                            </div>

                            <div class="col-auto d-flex">
                                @include('shared.buttons.copy_link')
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@endif