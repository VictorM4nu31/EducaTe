<x-layouts::app title="{{ $lesson->title }}">
    <div class="container mx-auto py-6 max-w-4xl">
        <div class="mb-6">
            <flux:button href="{{ route('sat-education.index') }}" variant="ghost" size="sm">
                ← Volver a Lecciones
            </flux:button>
        </div>

        <flux:card class="mb-6">
            <div class="mb-6">
                <div class="flex items-center gap-2 mb-2">
                    <flux:badge variant="info" size="sm">{{ ucfirst($lesson->category) }}</flux:badge>
                </div>
                <h1 class="text-3xl font-bold text-neutral-900 dark:text-white">{{ $lesson->title }}</h1>
            </div>

            <div class="prose dark:prose-invert max-w-none">
                {!! $lesson->content !!}
            </div>

            @if(!empty($lesson->quiz_data) && isset($lesson->quiz_data['questions']))
                <div
                    class="mt-8 p-6 bg-yellow-50 dark:bg-yellow-900/20 border border-yellow-200 dark:border-yellow-700/50 rounded-xl text-center">
                    <h3 class="text-xl font-bold text-yellow-800 dark:text-yellow-500 mb-2">¡Pon a prueba lo que aprendiste!
                    </h3>
                    <p class="text-yellow-700 dark:text-yellow-600 mb-4">Resuelve este quiz de 3 preguntas y, si respondes
                        todo correctamente, ganarás un bono de AulaChains.</p>
                    <flux:button href="{{ route('sat-education.lessons.quiz', $lesson) }}" variant="primary"
                        class="bg-yellow-500 hover:bg-yellow-600 text-white border-none shadow-md">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" class="size-5 mr-2">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                        </svg>
                        Tomar el Quiz
                    </flux:button>
                </div>
            @endif
        </flux:card>

        @if($relatedLessons->count() > 0)
            <flux:card>
                <h2 class="text-xl font-bold text-neutral-900 dark:text-white mb-4">Lecciones Relacionadas</h2>
                <div class="space-y-3">
                    @foreach($relatedLessons as $related)
                        <a href="{{ route('sat-education.show', $related) }}"
                            class="block p-3 rounded-lg border border-neutral-200 dark:border-neutral-700 hover:bg-neutral-50 dark:hover:bg-neutral-800 transition-colors">
                            <h3 class="font-bold text-neutral-900 dark:text-white">{{ $related->title }}</h3>
                        </a>
                    @endforeach
                </div>
            </flux:card>
        @endif
    </div>
</x-layouts::app>