<x-layouts::app title="Editar Recompensa">
    <div class="container mx-auto py-6 max-w-2xl">
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-neutral-900 dark:text-white">Editar Recompensa</h1>
            <p class="text-neutral-500 dark:text-neutral-400">Modifica la información de la recompensa</p>
        </div>

        <flux:card>
            <form action="{{ route('teacher.rewards.update', $reward) }}" method="POST" class="space-y-6">
                @csrf
                @method('PUT')

                <div class="space-y-2">
                    <flux:field>
                        <flux:label>Nombre de la Recompensa *</flux:label>
                        <flux:input name="name" value="{{ old('name', $reward->name) }}" placeholder="Ej: Chocolate grande" required />
                        <flux:error name="name" />
                    </flux:field>
                </div>

                <div class="space-y-2">
                    <flux:field>
                        <flux:label>Descripción</flux:label>
                        <flux:textarea name="description" rows="3" placeholder="Descripción del producto...">{{ old('description', $reward->description) }}</flux:textarea>
                        <flux:error name="description" />
                    </flux:field>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="space-y-2">
                        <flux:field>
                            <flux:label>Costo en AulaChain (₳) *</flux:label>
                            <flux:input name="cost" type="number" step="0.01" min="0" value="{{ old('cost', $reward->cost) }}" placeholder="0.00" required />
                            <flux:error name="cost" />
                        </flux:field>
                    </div>

                    <div class="space-y-2">
                        <flux:field>
                            <flux:label>Categoría *</flux:label>
                            <flux:select name="category" required>
                                <option value="">Selecciona una categoría</option>
                                <option value="Snacks" {{ old('category', $reward->category) === 'Snacks' ? 'selected' : '' }}>Snacks</option>
                                <option value="Bebidas" {{ old('category', $reward->category) === 'Bebidas' ? 'selected' : '' }}>Bebidas</option>
                                <option value="Premium" {{ old('category', $reward->category) === 'Premium' ? 'selected' : '' }}>Premium</option>
                                <option value="Privilegios" {{ old('category', $reward->category) === 'Privilegios' ? 'selected' : '' }}>Privilegios</option>
                                <option value="Material" {{ old('category', $reward->category) === 'Material' ? 'selected' : '' }}>Material</option>
                                <option value="Educativo" {{ old('category', $reward->category) === 'Educativo' ? 'selected' : '' }}>Educativo</option>
                            </flux:select>
                            <flux:error name="category" />
                        </flux:field>
                    </div>
                </div>

                <div class="space-y-2">
                    <flux:field>
                        <flux:label>Stock Disponible *</flux:label>
                        <flux:input name="stock" type="number" min="0" value="{{ old('stock', $reward->stock) }}" placeholder="0" required />
                        <flux:description>Cantidad de unidades disponibles para canje</flux:description>
                        <flux:error name="stock" />
                    </flux:field>
                </div>

                <div class="flex gap-3 justify-end">
                    <flux:button href="{{ route('teacher.rewards.index') }}" variant="ghost">
                        Cancelar
                    </flux:button>
                    <flux:button type="submit" variant="primary">
                        Guardar Cambios
                    </flux:button>
                </div>
            </form>
        </flux:card>
    </div>
</x-layouts::app>
