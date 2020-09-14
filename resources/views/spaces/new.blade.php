@section('site_title', formatTitle([__('New'), __('Space'), config('settings.title')]))

@include('shared.breadcrumbs', ['breadcrumbs' => [
    ['url' => route('dashboard'), 'title' => __('Home')],
    ['url' => route('spaces'), 'title' => __('Spaces')],
    ['title' => __('New')],
]])

<h2 class="mb-3 d-inline-block">{{ __('New') }}</h2>

<div class="card border-0 shadow-sm">
    <div class="card-header">
        <div class="row">
            <div class="col">
                <div class="font-weight-medium py-1">{{ __('Space') }}</div>
            </div>
        </div>
    </div>
    <div class="card-body">
        @include('shared.message')

        <form action="{{ route('spaces.new') }}" method="post" enctype="multipart/form-data">
            @csrf

            <div class="form-group">
                <label for="i_name">{{ __('Name') }}</label>
                <input type="text" name="name" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" id="i_name" value="{{ old('name') }}">
                @if ($errors->has('name'))
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $errors->first('name') }}</strong>
                    </span>
                @endif
            </div>

            <div class="form-group">
                <label for="i_name">{{ __('Color') }}</label>
                <div class="form-row">
                    @foreach(formatSpace() as $key => $value)
                        <div class="col-4 col-sm">
                            <div class="custom-control custom-radio custom-control-inline">
                                <input type="radio" id="i_color{{ $key }}" name="color" class="custom-control-input{{ $errors->has('color') ? ' is-invalid' : '' }}" value="{{ $key }}" @if($key == 1) checked @endif>
                                <label class="custom-control-label d-flex align-items-center" for="i_color{{ $key }}"><span class="icon-label bg-{{ $value }} rounded-circle cursor-pointer"></span></label>
                            </div>
                        </div>
                    @endforeach
                </div>
                @if ($errors->has('color'))
                    <span class="invalid-feedback d-block" role="alert">
                        <strong>{{ $errors->first('color') }}</strong>
                    </span>
                @endif
            </div>

            <button type="submit" name="submit" class="btn btn-primary">{{ __('Save') }}</button>
        </form>
    </div>
</div>