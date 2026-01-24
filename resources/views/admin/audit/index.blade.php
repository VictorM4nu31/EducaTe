<x-layouts::app title="Registro de Auditoría">
    <div class="container mx-auto py-6">
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-neutral-dark">Registro de Auditoría</h1>
            <p class="text-neutral-medium mt-1">Seguimiento histórico de las acciones realizadas en el sistema por todos los usuarios.</p>
        </div>

        <flux:card>
            <flux:table>
                <flux:table.columns>
                    <flux:table.column>Usuario</flux:table.column>
                    <flux:table.column>Acción</flux:table.column>
                    <flux:table.column>Descripción</flux:table.column>
                    <flux:table.column>Fecha</flux:table.column>
                    <flux:table.column>IP / Dispositivo</flux:table.column>
                </flux:table.columns>

                <flux:table.rows>
                    @forelse($logs as $log)
                        <flux:table.row>
                            <flux:table.cell>
                                <div class="flex items-center gap-2">
                                    <flux:avatar size="xs" :name="$log->user?->name" :initials="$log->user?->initials()" />
                                    <div>
                                        <p class="text-sm font-medium text-neutral-dark">{{ $log->user?->name ?? 'Sistema' }}</p>
                                        <p class="text-[10px] text-neutral-medium">{{ $log->user?->email ?? '' }}</p>
                                    </div>
                                </div>
                            </flux:table.cell>
                            <flux:table.cell>
                                <flux:badge size="sm" class="capitalize">
                                    {{ str_replace('_', ' ', $log->action) }}
                                </flux:badge>
                            </flux:table.cell>
                            <flux:table.cell>
                                <p class="text-sm text-neutral-medium max-w-xs truncate" title="{{ $log->description }}">
                                    {{ $log->description }}
                                </p>
                            </flux:table.cell>
                            <flux:table.cell>
                                <p class="text-sm text-neutral-dark">{{ $log->created_at->format('d/m/Y H:i') }}</p>
                                <p class="text-[10px] text-neutral-medium">{{ $log->created_at->diffForHumans() }}</p>
                            </flux:table.cell>
                            <flux:table.cell>
                                <div class="text-[10px] text-neutral-medium">
                                    <p>{{ $log->ip_address }}</p>
                                    <p class="truncate max-w-[150px]">{{ $log->user_agent }}</p>
                                </div>
                            </flux:table.cell>
                        </flux:table.row>
                    @empty
                        <flux:table.row>
                            <flux:table.cell colspan="5" class="text-center py-12">
                                <p class="text-neutral-medium">No hay registros de actividad recientes.</p>
                            </flux:table.cell>
                        </flux:table.row>
                    @endforelse
                </flux:table.rows>
            </flux:table>

            @if($logs->hasPages())
                <div class="mt-6">
                    {{ $logs->links() }}
                </div>
            @endif
        </flux:card>
    </div>
</x-layouts::app>
