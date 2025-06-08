<div class="mb-3">
    {{ html()->label(__('label.name'), 'name')->class('form-label') }}
    {{ html()->text('name')->class('form-control')->required() }}
    @error('name')
    <div class="invalid-feedback d-block">{{ $message }}</div>
    @enderror
</div>

<div class="mb-3">
    {{ html()->label(__('label.description'), 'description')->class('form-label') }}
    {{ html()->textarea('description')->class('form-control') }}
    @error('description')
    <div class="invalid-feedback d-block">{{ $message }}</div>
    @enderror
</div>
