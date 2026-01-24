<x-layouts::app title="Manual del Docente">
    <div class="container mx-auto py-6 max-w-4xl">
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-neutral-dark">Manual del Docente</h1>
            <p class="text-neutral-medium mt-1">Guía completa para la gestión de alumnos, tareas y recompensas en EducaTe.</p>
        </div>

        <div class="space-y-8">
            <section>
                <h2 class="text-xl font-bold text-neutral-dark mb-4 flex items-center gap-2">
                    <span class="flex h-6 w-6 items-center justify-center rounded bg-aulachain-blue text-white text-xs">1</span>
                    Gestión de Grupos
                </h2>
                <flux:card class="prose dark:prose-invert max-w-none text-neutral-medium">
                    <p>Como docente, puedes crear grupos para tus diferentes clases. Cada grupo genera un código único de 6 caracteres que debes compartir con tus alumnos para que puedan unirse.</p>
                    <ul>
                        <li><strong>Regenerar Código:</strong> Si sospechas que el código se ha filtrado, puedes regenerarlo en los ajustes del grupo.</li>
                        <li><strong>Expulsar Alumnos:</strong> Puedes ver la lista de integrantes y remover a quienes no pertenezcan a la clase.</li>
                    </ul>
                </flux:card>
            </section>

            <section>
                <h2 class="text-xl font-bold text-neutral-dark mb-4 flex items-center gap-2">
                    <span class="flex h-6 w-6 items-center justify-center rounded bg-aulachain-green text-white text-xs">2</span>
                    Tareas y AulaChain
                </h2>
                <flux:card class="prose dark:prose-invert max-w-none text-neutral-medium">
                    <p>Al crear tareas, asignas una recompensa en AulaChain (AC). Los alumnos reciben estos puntos automáticamente al momento en que tú apruebas y calificas su entrega.</p>
                    <ul>
                        <li><strong>Dificultad:</strong> Las tareas se categorizan por dificultad, lo que ayuda a los alumnos a priorizar su trabajo.</li>
                        <li><strong>Revisiones:</strong> Puedes dejar comentarios en las entregas para que el alumno aprenda de sus errores.</li>
                    </ul>
                </flux:card>
            </section>

            <section>
                <h2 class="text-xl font-bold text-neutral-dark mb-4 flex items-center gap-2">
                    <span class="flex h-6 w-6 items-center justify-center rounded bg-aulachain-orange text-white text-xs">3</span>
                    Marketplace de Recompensas
                </h2>
                <flux:card class="prose dark:prose-invert max-w-none text-neutral-medium">
                    <p>Tú tienes el control de qué pueden comprar los alumnos con sus puntos. Puedes crear recompensas como "Puntos extra", "Permiso de salida" o "Material didáctico".</p>
                </flux:card>
            </section>
        </div>
    </div>
</x-layouts::app>
