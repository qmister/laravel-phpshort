@extends('layouts.app')

@section('site_title', formatTitle([__('Dashboard'), config('settings.title')]))

@section('content')
<div class="bg-base-1 flex-fill">
    @include('dashboard.header')
    <div class="bg-base-1">
        <div class="container py-3 my-3">
            <h4 class="mb-0">{{ __('Overview') }}</h4>

            <div class="row mb-5">
                @php
                    $cards = [
                        'users' =>
                        [
                            'title' => 'Links',
                            'value' => $stats['links'],
                            'description' => 'Manage links',
                            'route' => 'links',
                            'icon' => 'icons.background.link'
                        ],
                        [
                            'title' => 'Spaces',
                            'value' => $stats['spaces'],
                            'description' => 'Manage spaces',
                            'route' => 'spaces',
                            'icon' => 'icons.background.space'
                        ],
                        [
                            'title' => 'Domains',
                            'value' => $stats['domains'],
                            'description' => 'Manage domains',
                            'route' => 'domains',
                            'icon' => 'icons.background.domain'
                        ]
                    ];
                @endphp

                @foreach($cards as $card)
                    <div class="col-12 col-md-4 mt-3">
                        <div class="card border-0 shadow-sm h-100 overflow-hidden">
                            <div class="card-body d-flex">
                                <div class="flex-grow-1">
                                    <div class="text-muted font-weight-medium mb-2">{{ __($card['title']) }}</div>
                                    <div class="h1 mb-0 font-weight-normal">{{ number_format($card['value'], 0, __('.'), __(',')) }}</div>
                                </div>

                                <div class="icon-gradient-{{ $loop->index+4 }} text-primary d-flex align-items-top">
                                    @include($card['icon'], ['class' => 'fill-current icon-card-stats'])
                                </div>
                            </div>
                            <div class="card-footer bg-base-2 border-0">
                                <a href="{{ route($card['route']) }}" class="text-muted font-weight-medium d-inline-flex align-items-baseline">{{ __($card['description']) }}@include((__('lang_dir') == 'rtl' ? 'icons.chevron_left' : 'icons.chevron_right'), ['class' => 'icon-chevron fill-current '.(__('lang_dir') == 'rtl' ? 'mr-2' : 'ml-2')])</a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <h4 class="mb-0">{{ __('Recent activity') }}</h4>
            <div class="row">
                <div class="col-12 col-lg-6 mt-3">
                    <div class="card border-0 shadow-sm">
                        <div class="card-header align-items-center">
                            <div class="row">
                                <div class="col"><div class="font-weight-medium py-1">{{ __('Latest links') }}</div></div>
                            </div>
                        </div>

                        <div class="card-body">
                            @if(count($links) == 0)
                                {{ __('No data') }}.
                            @else
                                <div class="list-group list-group-flush my-n3">
                                    @foreach($links as $link)
                                        <div class="list-group-item px-0">
                                            <div class="row align-items-center">
                                                <div class="col d-flex text-truncate">
                                                    <div class="{{ (__('lang_dir') == 'rtl' ? 'ml-3' : 'mr-3') }}"><img src="https://icons.duckduckgo.com/ip3/{{ parse_url($link->url)['host'] }}.ico" rel="noreferrer" class="icon-label"></div>

                                                    <div class="text-truncate">
                                                        <a href="{{ route('stats', $link->id) }}" class="{{ ($link->disabled || $link->expiration_clicks && $link->clicks >= $link->expiration_clicks || \Carbon\Carbon::now()->greaterThan($link->ends_at) && $link->ends_at ? 'text-danger' : 'text-primary') }}" dir="ltr">{{ str_replace(['http://', 'https://'], '', (($link->domain->name ?? config('app.url')) .'/'.$link->alias)) }}</a>

                                                        <div class="text-dark text-truncate small">
                                                            <span class="text-secondary cursor-help" data-toggle="tooltip-url" title="{{ $link->url }}">@if($link->title){{ $link->title }}@else<span dir="ltr">{{ str_replace(['http://', 'https://'], '', $link->url) }}</span>@endif</span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-auto d-flex">
                                                    @include('shared.buttons.copy_link')
                                                    @include('shared.dropdowns.link', ['options' => ['dropdown' => ['button' => true, 'edit' => true, 'share' => true, 'stats' => true, 'preview' => true, 'open' => true, 'delete' => true]]])
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="col-12 col-lg-6 mt-3">
                    <div class="card border-0 shadow-sm">
                        <div class="card-header align-items-center">
                            <div class="row">
                                <div class="col"><div class="font-weight-medium py-1">{{ __('Latest clicks') }}</div></div>
                            </div>
                        </div>

                        <div class="card-body">
                            @if(count($clicks) == 0)
                                {{ __('No data') }}.
                            @else
                                <div class="list-group list-group-flush my-n3">
                                    @foreach($clicks as $click)
                                        <div class="list-group-item px-0">
                                            <div class="row align-items-center">
                                                <div class="col text-truncate">
                                                    <div class="row align-items-center">
                                                        <div class="col-6 d-flex">
                                                            <div class="{{ (__('lang_dir') == 'rtl' ? 'ml-3' : 'mr-3') }}"><img src="{{ asset('/images/icons/countries/'.formatCountry($click->country)) }}.svg" class="icon-label"></div>
                                                            <div class="text-truncate">
                                                                <div class="d-flex">
                                                                    <div class="text-truncate">
                                                                        @if(array_key_exists($click->country, config('countries')))
                                                                            {{ __(config('countries')[$click->country]) }}
                                                                        @else
                                                                            {{ __('Unknown') }}
                                                                        @endif
                                                                    </div>
                                                                </div>

                                                                <div class="text-muted text-truncate small">
                                                                    @if($click->referrer)
                                                                        {{ $click->referrer }}
                                                                    @else
                                                                        {{ __('Direct, Email, SMS') }}
                                                                    @endif
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-6 d-flex">
                                                            <div class="{{ (__('lang_dir') == 'rtl' ? 'ml-3' : 'mr-3') }}"><img src="{{ asset('/images/icons/browsers/'.formatBrowser($click->browser)) }}.svg" class="icon-label"></div>
                                                            <div class="text-truncate">
                                                                <div class="d-flex">
                                                                    <div class="text-truncate">
                                                                        @if($click->browser)
                                                                            {{ $click->browser }}
                                                                        @else
                                                                            {{ __('Unknown') }}
                                                                        @endif
                                                                    </div>
                                                                </div>

                                                                <div class="text-muted text-truncate small">
                                                                    @if($click->platform)
                                                                        {{ $click->platform }}
                                                                    @else
                                                                        {{ __('Unknown') }}
                                                                    @endif
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-auto">
                                                    <a href="{{ route('stats', $click->link_id) }}" class="btn btn-sm text-primary d-flex align-items-center">
                                                        @include('icons.stats', ['class' => 'fill-current icon-button'])&#8203;
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@include('shared.modals.share_link')
@include('shared.modals.delete_link')

@include('shared.sidebars.user')
@endsection
