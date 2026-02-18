<x-layouts::app title="Tomar Examen: {{ $exam->title }}">
    <div class="container mx-auto py-6 max-w-4xl">
        <div
            class="relative overflow-hidden rounded-2xl bg-linear-to-br from-academic-purple to-academic-purple-hover p-8 shadow-xl mb-6">
            <div class="relative z-10 flex flex-col md:flex-row md:items-center md:justify-between gap-6">
                <div>
                    <h1 class="text-3xl font-bold text-black">{{ $exam->title }}</h1>
                    @if($exam->time_limit)
                        <p class="text-neutral-800 font-medium italic">Tiempo límite: {{ $exam->time_limit }} minutos</p>
                    @endif
                </div>
                <div class="bg-white/40 backdrop-blur-md px-4 py-2 rounded-xl border border-white/50 text-center">
                    <p class="text-[10px] text-neutral-700 uppercase tracking-wider font-extrabold">Pistas usadas</p>
                    <p id="global-hints-counter" class="text-2xl font-bold text-black">{{ $attempt->hints_used }} / 3</p>
                </div>
            </div>
            <div class="absolute -right-12 -top-12 h-40 w-40 rounded-full bg-white/10 blur-3xl"></div>
        </div>

        @if($exam->time_limit)
            <div class="mb-8">
                <div class="w-full bg-neutral-light dark:bg-neutral-light rounded-full h-3">
                    <div id="time-progress" class="bg-warning-yellow h-3 rounded-full transition-all duration-300 shadow-sm"
                        style="width: 100%"></div>
                </div>
                <div class="flex justify-between items-center mt-2 px-1">
                    <span class="text-xs font-bold text-neutral-medium uppercase tracking-widest">Progreso del tiempo</span>
                    <span class="text-sm font-bold text-neutral-dark font-mono bg-warning-yellow/10 px-2 py-0.5 rounded"
                        id="time-remaining">
                        {{ $exam->time_limit }}:00
                    </span>
                </div>
            </div>
        @endif
    </div>

    <form action="{{ route('student.exams.submit', [$exam, $attempt]) }}" method="POST" id="exam-form"
        onsubmit="window.isSubmitting = true;">
        @csrf
        <input type="hidden" name="hints_used" value="{{ $attempt->hints_used }}" id="hints-used-input">

        @if(isset($annulled_message))
            <div class="fixed inset-0 z-100 flex items-center justify-center bg-black/80 backdrop-blur-md p-4">
                <div
                    class="max-w-md w-full bg-white dark:bg-neutral-900 rounded-3xl p-8 shadow-2xl text-center border border-red-500/30">
                    <div
                        class="w-20 h-20 bg-red-100 dark:bg-red-900/30 rounded-full flex items-center justify-center mx-auto mb-6">
                        <flux:icon.exclamation-triangle class="w-10 h-10 text-red-600 dark:text-red-400" />
                    </div>
                    <h2 class="text-2xl font-bold text-neutral-900 dark:text-white mb-4">Examen Anulado</h2>
                    <p class="text-neutral-600 dark:text-neutral-400 mb-6">{{ $annulled_message }}</p>
                    <flux:button href="{{ route('student.exams') }}" variant="primary"
                        class="w-full bg-red-600 hover:bg-red-700">
                        Volver a mis exámenes
                    </flux:button>
                </div>
            </div>
        @endif

            <div class="space-y-6">
                @foreach($exam->questions as $index => $question)
                    @php
                        $savedAnswer = $attempt->answers[$question->id] ?? null;
                    @endphp
                    <flux:card>
                        <div class="mb-4">
                            <div class="flex items-center justify-between mb-2">
                                <h3 class="text-lg font-bold text-academic-purple">
                                    Pregunta {{ $index + 1 }} de {{ $exam->questions->count() }}
                                </h3>
                                <span
                                    class="px-2 py-1 bg-academic-purple/10 text-academic-purple rounded text-xs font-bold ring-1 ring-academic-purple/20">
                                    {{ $question->points }} puntos
                                </span>
                            </div>
                            <p class="text-neutral-800 dark:text-neutral-200 text-lg">{{ $question->question_text }}</p>
                        </div>

                        <div class="space-y-2">
                            @if($question->type === 'multiple_choice')
                                @foreach($question->options as $key => $option)
                                    <label
                                        class="flex items-center gap-3 p-3 rounded-lg border border-neutral-light dark:border-neutral-light/20 hover:border-blue-500/50 group cursor-pointer transition-colors has-checked:bg-blue-50 dark:has-checked:bg-blue-900/20 has-checked:border-blue-500">
                                        <input type="radio" name="answers[{{ $question->id }}]" value="{{ $key }}"
                                            class="text-blue-500 focus:ring-blue-500" {{ $savedAnswer == $key ? 'checked' : '' }} />
                                        <span class="font-medium text-neutral-700 dark:text-neutral-300">{{ $key }})</span>
                                        <span class="flex-1 text-neutral-900 dark:text-white">{{ $option }}</span>
                                    </label>
                                @endforeach
                            @elseif($question->type === 'true_false')
                                <label
                                    class="flex items-center gap-3 p-3 rounded-lg border border-neutral-200 dark:border-neutral-700 hover:bg-neutral-50 dark:hover:bg-neutral-800 cursor-pointer transition-colors has-checked:bg-blue-50">
                                    <input type="radio" name="answers[{{ $question->id }}]" value="Verdadero"
                                        class="text-emerald-600 focus:ring-emerald-500" {{ $savedAnswer == 'Verdadero' ? 'checked' : '' }} />
                                    <span class="flex-1 text-neutral-900 dark:text-white">Verdadero</span>
                                </label>
                                <label
                                    class="flex items-center gap-3 p-3 rounded-lg border border-neutral-200 dark:border-neutral-700 hover:bg-neutral-50 dark:hover:bg-neutral-800 cursor-pointer transition-colors has-checked:bg-blue-50">
                                    <input type="radio" name="answers[{{ $question->id }}]" value="Falso"
                                        class="text-emerald-600 focus:ring-emerald-500" {{ $savedAnswer == 'Falso' ? 'checked' : '' }} />
                                    <span class="flex-1 text-neutral-900 dark:text-white">Falso</span>
                                </label>
                            @else
                                <textarea name="answers[{{ $question->id }}]" rows="3"
                                    class="w-full rounded-lg border-neutral-300 dark:border-neutral-700 bg-white dark:bg-neutral-800 text-neutral-900 dark:text-white shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm"
                                    placeholder="Escribe tu respuesta aquí...">{{ $savedAnswer }}</textarea>
                            @endif
                        </div>

                        @if(!$attempt->is_completed)
                            <div class="mt-4 pt-4 border-t border-neutral-200 dark:border-neutral-700">
                                <livewire:exam.hint-button :question="$question" :attempt="$attempt" />
                            </div>
                        @endif
                    </flux:card>
                @endforeach
            </div>

            <div class="mt-6 flex justify-end gap-3">
                <flux:button type="button" variant="ghost" href="{{ route('student.exams') }}">
                    Cancelar
                </flux:button>
                <flux:button type="submit" variant="primary"
                    class="bg-green-500 hover:bg-green-600 active:bg-green-700 border-none shadow-lg">
                    Finalizar Examen
                </flux:button>
            </div>
        </form>
    </div>

        <script>
            // Prevenir copiar, pegar y clic derecho
            document.addEventListener('copy', e => e.preventDefault());
            document.addEventListener('paste', e => e.preventDefault());
            document.addEventListener('cut', e => e.preventDefault());
            document.addEventListener('contextmenu', e => e.preventDefault());

            // Detección de cambio de pestaña
            let isAnnulled = {{ $attempt->is_annulled ? 'true' : 'false' }};
            window.isSubmitting = false;

            document.addEventListener('visibilitychange', function () {
                if (document.hidden && !isAnnulled && !window.isSubmitting) {
                    annulExam();
                }
            });

            window.addEventListener('blur', function () {
                if (!isAnnulled && !window.isSubmitting) {
                    annulExam();
                }
            });

            function annulExam() {
                isAnnulled = true;
                fetch('{{ route('student.exams.annul', [$exam, $attempt]) }}', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Content-Type': 'application/json',
                        'Accept': 'application/json'
                    }
                }).then(() => {
                    window.location.reload();
                });
            }

            // Auto-guardado de respuestas
            const examForm = document.getElementById('exam-form');

            function saveProgress() {
                if (isAnnulled || window.isSubmitting) return;

                const formData = new FormData(examForm);
                const data = {};
                formData.forEach((value, key) => {
                    if (key.includes('answers[')) {
                        data[key] = value;
                    }
                });

                fetch('{{ route('student.exams.save-progress', [$exam, $attempt]) }}', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Content-Type': 'application/json',
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify(data)
                });
            }

            // Guardar al cambiar cualquier input
            examForm.addEventListener('change', saveProgress);
            examForm.addEventListener('input', debounce(saveProgress, 1000));

            function debounce(func, wait) {
                let timeout;
                return function (...args) {
                    clearTimeout(timeout);
                    timeout = setTimeout(() => func.apply(this, args), wait);
                }
            }

            // Timer Logic
            @if($exam->time_limit)
                let timeLimit = {{ $exam->time_limit }} * 60;
                const startedAt = {{ $attempt->started_at->timestamp }};
                const now = Math.floor(Date.now() / 1000);
                const elapsed = now - startedAt;
                let timeRemaining = Math.max(0, timeLimit - elapsed);

                const timeDisplay = document.getElementById('time-remaining');
                const progressBar = document.getElementById('time-progress');

                function updateTimer() {
                    if (isAnnulled) return;

                    if (timeRemaining <= 0) {
                        window.isSubmitting = true;
                        document.getElementById('exam-form').submit();
                        return;
                    }

                    const minutes = Math.floor(timeRemaining / 60);
                    const seconds = timeRemaining % 60;
                    if (timeDisplay) timeDisplay.textContent = `${minutes}:${seconds.toString().padStart(2, '0')}`;

                    const progress = (timeRemaining / timeLimit) * 100;
                    if (progressBar) {
                        progressBar.style.width = progress + '%';
                        if (progress < 20) {
                            progressBar.classList.remove('bg-blue-500');
                            progressBar.classList.add('bg-red-500');
                        }
                    }

                    timeRemaining--;
                }

                setInterval(updateTimer, 1000);
                updateTimer();
            @endif

            // Escuchar actualización de pistas desde Livewire
            document.addEventListener('livewire:init', () => {
                Livewire.on('refresh-hints-counter', (event) => {
                    const counter = document.getElementById('global-hints-counter');
                    if (counter) {
                        counter.textContent = `${event.hintsUsed} / 3`;
                    }
                });
            });
        </script>
</x-layouts::app>