@props([
    'sidebar' => false,
    'iconOnly' => false,
    'name' => config('app.name', 'EducaTe'),
])

@if($iconOnly)
    <div {{ $attributes->merge(['class' => 'flex aspect-square size-8 items-center justify-center rounded-md bg-transparent shadow-sm overflow-hidden']) }}>
        <x-app-logo-icon class="size-full object-cover" />
    </div>
@elseif($sidebar)
    <flux:sidebar.brand :name="$name" {{ $attributes }}>
        <x-slot name="logo" class="flex aspect-square size-8 items-center justify-center rounded-md bg-transparent overflow-hidden">
            <x-app-logo-icon class="size-full object-cover" />
        </x-slot>
    </flux:sidebar.brand>
@else
    <flux:brand :name="$name" {{ $attributes }}>
        <x-slot name="logo" class="flex aspect-square size-8 items-center justify-center rounded-md bg-transparent overflow-hidden">
            <x-app-logo-icon class="size-full object-cover" />
        </x-slot>
    </flux:brand>
@endif
