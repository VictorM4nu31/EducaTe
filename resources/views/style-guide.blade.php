<x-layouts.app>
    <div class="py-12 px-4 sm:px-6 lg:px-8 max-w-7xl mx-auto">
        <div class="mb-12">
            <h1 class="text-4xl font-bold text-neutral-dark dark:text-neutral-dark mb-4">AulaChain Color System</h1>
            <p class="text-lg text-neutral-medium">A guide to the primary and functional colors used in the AulaChain educational platform.</p>
        </div>

        <section class="mb-16">
            <h2 class="text-2xl font-semibold mb-6">Primary Colors</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                <!-- AulaChain Blue -->
                <div class="flex flex-col">
                    <div class="h-24 rounded-t-lg bg-aulachain-blue flex items-center justify-center">
                        <span class="text-white font-mono">#2563EB</span>
                    </div>
                    <div class="p-4 bg-white dark:bg-neutral-very-light rounded-b-lg border border-neutral-light">
                        <h3 class="font-bold text-neutral-dark">AulaChain Blue</h3>
                        <p class="text-sm text-neutral-medium">Primary action, focus, stability.</p>
                    </div>
                </div>

                <!-- AulaChain Green -->
                <div class="flex flex-col">
                    <div class="h-24 rounded-t-lg bg-aulachain-green flex items-center justify-center">
                        <span class="text-white font-mono">#10B981</span>
                    </div>
                    <div class="p-4 bg-white dark:bg-neutral-very-light rounded-b-lg border border-neutral-light">
                        <h3 class="font-bold text-neutral-dark">AulaChain Green</h3>
                        <p class="text-sm text-neutral-medium">Prosperity, AulaChain currency, growth.</p>
                    </div>
                </div>

                <!-- AulaChain Orange -->
                <div class="flex flex-col">
                    <div class="h-24 rounded-t-lg bg-aulachain-orange flex items-center justify-center">
                        <span class="text-white font-mono">#F59E0B</span>
                    </div>
                    <div class="p-4 bg-white dark:bg-neutral-very-light rounded-b-lg border border-neutral-light">
                        <h3 class="font-bold text-neutral-dark">AulaChain Orange</h3>
                        <p class="text-sm text-neutral-medium">Energy, secondary actions, gamification.</p>
                    </div>
                </div>

                <!-- Academic Purple -->
                <div class="flex flex-col">
                    <div class="h-24 rounded-t-lg bg-academic-purple flex items-center justify-center">
                        <span class="text-white font-mono">#8B5CF6</span>
                    </div>
                    <div class="p-4 bg-white dark:bg-neutral-very-light rounded-b-lg border border-neutral-light">
                        <h3 class="font-bold text-neutral-dark">Academic Purple</h3>
                        <p class="text-sm text-neutral-medium">Knowledge, levels, excellence.</p>
                    </div>
                </div>
            </div>
        </section>

        <section class="mb-16">
            <h2 class="text-2xl font-semibold mb-6">Functional Colors</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <!-- Warning Yellow -->
                <div class="flex flex-col">
                    <div class="h-16 rounded-t-lg bg-warning-yellow flex items-center justify-center">
                        <span class="text-white font-mono">#EAB308</span>
                    </div>
                    <div class="p-4 bg-white dark:bg-neutral-very-light rounded-b-lg border border-neutral-light">
                        <h3 class="font-bold text-neutral-dark">Warning Yellow</h3>
                        <p class="text-sm text-neutral-medium">Attention, pending tasks.</p>
                    </div>
                </div>

                <!-- Alert Red -->
                <div class="flex flex-col">
                    <div class="h-16 rounded-t-lg bg-alert-red flex items-center justify-center">
                        <span class="text-white font-mono">#EF4444</span>
                    </div>
                    <div class="p-4 bg-white dark:bg-neutral-very-light rounded-b-lg border border-neutral-light">
                        <h3 class="font-bold text-neutral-dark">Alert Red</h3>
                        <p class="text-sm text-neutral-medium">Error, late tasks, destructive.</p>
                    </div>
                </div>
            </div>
        </section>

        <section class="mb-16">
            <h2 class="text-2xl font-semibold mb-6">Neutral Grays (Semantic)</h2>
            <div class="space-y-4">
                <div class="flex items-center space-x-4">
                    <div class="w-16 h-16 rounded bg-neutral-dark"></div>
                    <div>
                        <p class="font-bold">Neutral Dark</p>
                        <p class="text-sm text-neutral-medium font-mono">var(--color-neutral-dark)</p>
                    </div>
                </div>
                <div class="flex items-center space-x-4">
                    <div class="w-16 h-16 rounded bg-neutral-medium"></div>
                    <div>
                        <p class="font-bold">Neutral Medium</p>
                        <p class="text-sm text-neutral-medium font-mono">var(--color-neutral-medium)</p>
                    </div>
                </div>
                <div class="flex items-center space-x-4">
                    <div class="w-16 h-16 rounded bg-neutral-light"></div>
                    <div>
                        <p class="font-bold">Neutral Light</p>
                        <p class="text-sm text-neutral-medium font-mono">var(--color-neutral-light)</p>
                    </div>
                </div>
                <div class="flex items-center space-x-4 border border-neutral-light p-2 rounded">
                    <div class="w-16 h-16 rounded bg-neutral-very-light border border-neutral-light"></div>
                    <div>
                        <p class="font-bold">Neutral Very Light</p>
                        <p class="text-sm text-neutral-medium font-mono">var(--color-neutral-very-light)</p>
                    </div>
                </div>
            </div>
        </section>

        <section>
            <h2 class="text-2xl font-semibold mb-6">Buttons Preview</h2>
            <div class="flex flex-wrap gap-4">
                <button class="bg-aulachain-blue hover:bg-aulachain-blue-hover active:bg-aulachain-blue-active text-white px-6 py-2 rounded-lg font-medium transition-colors">
                    Primary Blue
                </button>
                <button class="bg-aulachain-green hover:bg-aulachain-green-hover active:bg-aulachain-green-active text-white px-6 py-2 rounded-lg font-medium transition-colors">
                    Success Green
                </button>
                <button class="bg-aulachain-orange hover:bg-aulachain-orange-hover active:bg-aulachain-orange-active text-white px-6 py-2 rounded-lg font-medium transition-colors">
                    Action Orange
                </button>
                <button class="bg-academic-purple hover:bg-academic-purple-hover text-white px-6 py-2 rounded-lg font-medium transition-colors">
                    Premium Purple
                </button>
                <button class="bg-alert-red hover:bg-alert-red-hover active:bg-alert-red-active text-white px-6 py-2 rounded-lg font-medium transition-colors">
                    Destructive Red
                </button>
            </div>
        </section>
    </div>
</x-layouts.app>
