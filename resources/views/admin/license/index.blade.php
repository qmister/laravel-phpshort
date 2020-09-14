@section('site_title', formatTitle([__('Settings'), config('settings.title')]))

@include('shared.breadcrumbs', ['breadcrumbs' => [
    ['url' => route('admin.dashboard'), 'title' => __('Admin')],
    ['title' => __('License')],
]])

<h2 class="mb-3 d-inline-block">
    @if(config('settings.license_key') === null || config('settings.license_type') === null)
        {{ __('New') }}
    @else
        {{ __('Edit') }}
    @endif
</h2>

<div class="card border-0 shadow-sm">
    <div class="card-header">
        <div class="font-weight-medium py-1">
            {{ __('License') }}
        </div>
    </div>
    <div class="card-body">
        @include('shared.message')

        <form method="POST" action="{{ route('admin.license') }}">
            @csrf

            <div class="form-group">
                <label for="i_license_key">{{ __('License key') }}</label>
                <input id="i_license_key" type="text" class="form-control{{ $errors->has('license_key') ? ' is-invalid' : '' }}" name="license_key" value="{{ old('license_key') }}" autofocus>
                @if ($errors->has('license_key'))
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $errors->first('license_key') }}</strong>
                    </span>
                @endif
            </div>

            <div class="row mt-3">
                <div class="col">
                    <button type="submit" class="btn btn-primary">
                        {{ __('Save') }}
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
