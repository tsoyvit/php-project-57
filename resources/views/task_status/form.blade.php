<div>
    {{ html()->label(__('app.name'), 'name') }}
</div>

<div class="mb-2">
    {{ html()->text('name')->class('rounded border-gray-300 w-1/3')->required() }}
    @error('name')
    <div class="text-rose-600">{{ $message }}</div>
    @enderror
</div>
