<x-layouts::app title="Quiz: {{ $lesson->title }}">
    <div class="container mx-auto py-6 max-w-3xl">
        <div class="mb-6">
            <flux:button href="{{ route('sat-education.show', $lesson) }}" variant="ghost" size="sm">
                ← Regresar a la lección
            </flux:button>
        </div>

        <div class="text-center mb-8">
            <h1 class="text-3xl font-bold dark:text-white mb-2">Quiz Interactivo</h1>
            <p class="text-lg text-neutral-600 dark:text-neutral-400">Responde correctamente para ganar AulaChains.</p>
        </div>

        @if($completed)
            <div
                class="bg-green-100 border-l-4 border-green-500 p-6 rounded-lg text-green-900 mb-8 max-w-xl mx-auto text-center shadow">
                <div
                    class="mx-auto bg-green-500 w-16 h-16 text-white rounded-full flex items-center justify-center mb-4 shadow-lg shadow-green-500/50">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                        stroke="currentColor" class="size-8">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M11.48 3.499a.562.562 0 0 1 1.04 0l2.125 5.111a.563.563 0 0 0 .475.345l5.518.442c.499.04.701.663.321.988l-4.204 3.602a.563.563 0 0 0-.182.557l1.285 5.385a.562.562 0 0 1-.84.61l-4.725-2.885a.562.562 0 0 0-.586 0L6.982 20.54a.562.562 0 0 1-.84-.61l1.285-5.386a.562.562 0 0 0-.182-.557l-4.204-3.602a.562.562 0 0 1 .321-.988l5.518-.442a.563.563 0 0 0 .475-.345L11.48 3.5Z" />
                    </svg>
                </div>
                <h3 class="text-xl font-bold mb-2">¡Ya completaste y aprobaste este quiz!</h3>
                <p>Anteriormente demostraste que dominas este tema. ¡Avanza a la siguiente lección!</p>
            </div>
        @else
            @if(session('error'))
                <div class="bg-red-100 border-left-4 border-red-500 text-red-700 p-4 rounded mb-6 text-center font-bold">
                    {{ session('error') }}
                </div>
            @endif

            <flux:card>
                <form action="{{ route('sat-education.lessons.quiz.submit', $lesson) }}" method="POST">
                    @csrf

                    <div class="space-y-8">
                        @foreach($lesson->quiz_data['questions'] as $index => $q)
                            <div class="bg-neutral-50 dark:bg-neutral-800 p-6 rounded-2xl border dark:border-neutral-700">
                                <h3 class="text-lg font-bold text-academic-purple dark:text-academic-purple-hover mb-4">
                                    <span
                                        class="bg-academic-purple text-white w-8 h-8 inline-flex items-center justify-center rounded-full mr-2">{{ $index + 1 }}</span>
                                    {{ $q['question'] }}
                                </h3>

                                <div class="space-y-3 pl-10">
                                    @foreach($q['options'] as $oIndex => $option)
                                        <label
                                            class="block p-4 bg-white dark:bg-neutral-900 border-2 dark:border-neutral-700 rounded-xl cursor-pointer hover:border-academic-purple hover:bg-purple-50 dark:hover:bg-purple-900/10 transition-colors">
                                            <div class="flex items-center">
                                                <input type="radio" name="answers[{{ $index }}]" value="{{ $oIndex }}" required
                                                    class="w-5 h-5 text-academic-purple bg-gray-100 border-gray-300 focus:ring-academic-purple dark:bg-gray-700 dark:border-gray-600">
                                                <span
                                                    class="ml-3 text-neutral-800 dark:text-neutral-200 font-medium">{{ $option }}</span>
                                            </div>
                                        </label>
                                    @endforeach
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <div class="mt-10 text-center">
                        <flux:button type="submit" variant="primary" size="xl"
                            class="w-full max-w-sm font-bold text-lg tracking-wide rounded-full px-8 py-4 shadow-xl shadow-academic-purple/20">
                            Revisar Respuestas y Ganar AC
                        </flux:button>
                    </div>
                </form>
            </flux:card>
        @endif
    </div>
</x-layouts::app>