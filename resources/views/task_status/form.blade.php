<div class="mb-3">

    {{ html()->label(__('app.name'), 'name')->class('form-label') }}
    {{ html()->text('name')->class('form-control')->required() }}
    @error('name')
    <div class="invalid-feedback d-block">{{ $message }}</div>
    @enderror

</div>
