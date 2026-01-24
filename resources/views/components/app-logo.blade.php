@props([
    'sidebar' => false,
    'iconOnly' => false,
    'name' => config('app.name', 'EducaTe'),
])

@if($iconOnly)
    <div {{ $attributes->merge(['class' => 'flex aspect-square size-8 items-center justify-center rounded-md bg-aulachain-blue text-white shadow-sm']) }}>
        <x-app-logo-icon class="size-5 fill-current text-white" />
    </div>
@elseif($sidebar)
    <flux:sidebar.brand :name="$name" {{ $attributes }}>
        <x-slot name="logo" class="flex aspect-square size-8 items-center justify-center rounded-md bg-aulachain-blue text-white">
            <x-app-logo-icon class="size-5 fill-current text-white dark:text-zinc-900" />
        </x-slot>
    </flux:sidebar.brand>
@else
    <flux:brand :name="$name" {{ $attributes }}>
        <x-slot name="logo" class="flex aspect-square size-8 items-center justify-center rounded-md bg-aulachain-blue text-white">
            <x-app-logo-icon class="size-5 fill-current text-white dark:text-zinc-900" />
        </x-slot>
    </flux:brand>
@endif
