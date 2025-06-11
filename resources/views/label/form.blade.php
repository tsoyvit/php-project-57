<div>
    {{ html()->label(__('label.name'), 'name') }}
</div>

<div class="mb-2">
    {{ html()->text('name')->class('rounded border-gray-300 w-1/3')->required() }}
    @error('name')
    <div class="invalid-feedback d-block">{{ $message }}</div>
    @enderror
</div>

<div>
    {{ html()->label(__('label.description'), 'description') }}
</div>

<div class="mb-2">
    {{ html()->textarea('description')->class('rounded border-gray-300 w-1/3') }}
    @error('description')
    <div class="invalid-feedback d-block">{{ $message }}</div>
    @enderror
</div>
