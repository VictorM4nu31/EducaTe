<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
    <head>
        @include('partials.head')
    </head>
    <body class="min-h-screen bg-neutral-very-light antialiased dark:bg-linear-to-b dark:from-neutral-dark dark:to-neutral-very-light">
        <div class="bg-muted flex min-h-svh flex-col items-center justify-center gap-6 p-6 md:p-10 relative overflow-hidden">
            <div class="absolute -top-[10%] -left-[5%] w-[40%] h-[40%] bg-aulachain-blue/5 blur-[100px] rounded-full"></div>
            <div class="absolute -bottom-[10%] -right-[5%] w-[40%] h-[40%] bg-aulachain-green/5 blur-[100px] rounded-full"></div>
            <div class="flex w-full max-w-md flex-col gap-6">
                <a href="{{ route('home') }}" class="flex flex-col items-center gap-2 font-medium" wire:navigate>
                    <span class="flex h-12 w-12 items-center justify-center rounded-xl bg-aulachain-blue shadow-lg shadow-aulachain-blue/20">
                        <x-app-logo-icon class="size-8 fill-current text-white" />
                    </span>

                    <span class="sr-only">{{ config('app.name', 'Laravel') }}</span>
                </a>

                <div class="flex flex-col gap-6 relative z-10">
                    <div class="rounded-2xl border border-neutral-light bg-white dark:bg-neutral-dark dark:border-neutral-light/20 text-neutral-dark shadow-xl shadow-black/5">
                        <div class="px-10 py-8">{{ $slot }}</div>
                    </div>
                </div>
            </div>
        </div>
        @fluxScripts
    </body>
</html>
