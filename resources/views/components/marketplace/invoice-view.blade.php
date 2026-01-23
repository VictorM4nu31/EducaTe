<?php

use Livewire\Volt\Component;

new class extends Component
{
    public $transaction;
    public $reward;
};
?>

<div class="font-mono text-sm text-neutral-800 dark:text-neutral-200">
    <div class="text-center border-b-2 border-dashed border-neutral-300 dark:border-neutral-700 pb-4 mb-4">
        <h2 class="text-xl font-bold uppercase">AulaChain SAT</h2>
        <p class="text-[10px] text-neutral-500">Sistema de Administración Tributaria Educativa</p>
        <p class="text-[10px] text-neutral-500 mt-2">FOLIO: #{{ str_pad($transaction->id, 8, '0', STR_PAD_LEFT) }}</p>
    </div>

    <div class="space-y-4">
        <div class="flex justify-between">
            <span class="uppercase text-[10px] font-bold text-neutral-500">Emisor:</span>
            <span class="text-right">TIENDA ESCOLAR AULACHAIN</span>
        </div>
        <div class="flex justify-between">
            <span class="uppercase text-[10px] font-bold text-neutral-500">Receptor:</span>
            <span class="text-right">{{ auth()->user()->name }}</span>
        </div>
        <div class="flex justify-between border-b border-neutral-100 dark:border-neutral-800 pb-2">
            <span class="uppercase text-[10px] font-bold text-neutral-500">RFC:</span>
            <span class="text-right">{{ auth()->user()->rfc }}</span>
        </div>

        <div class="py-4">
            <div class="flex justify-between font-bold mb-1">
                <span>{{ $reward->name }}</span>
                <span>₳ {{ number_format($reward->cost, 2) }}</span>
            </div>
            <p class="text-[10px] text-neutral-500">{{ $reward->description }}</p>
        </div>

        <div class="border-t-2 border-dashed border-neutral-300 dark:border-neutral-700 pt-4 space-y-1 text-right">
            <div class="flex justify-between">
                <span class="text-neutral-500">Subtotal:</span>
                <span>₳ {{ number_format($reward->cost, 2) }}</span>
            </div>
            <div class="flex justify-between text-[10px]">
                <span class="text-neutral-500">IVA (Simulado 0%):</span>
                <span>₳ 0.00</span>
            </div>
            <div class="flex justify-between text-lg font-bold">
                <span>TOTAL:</span>
                <span>₳ {{ number_format($reward->cost, 2) }}</span>
            </div>
        </div>

        <div class="mt-6 flex flex-col items-center gap-2 pt-4">
            <div class="bg-white p-2 rounded border border-neutral-200">
                <!-- Simple mock QR code using characters -->
                <div class="grid grid-cols-4 gap-1 p-1 opacity-50">
                    <div class="size-2 bg-black"></div><div class="size-2 bg-black"></div><div class="size-2 bg-gray-200"></div><div class="size-2 bg-black"></div>
                    <div class="size-2 bg-gray-200"></div><div class="size-2 bg-black"></div><div class="size-2 bg-black"></div><div class="size-2 bg-gray-200"></div>
                    <div class="size-2 bg-black"></div><div class="size-2 bg-gray-200"></div><div class="size-2 bg-black"></div><div class="size-2 bg-black"></div>
                    <div class="size-2 bg-black"></div><div class="size-2 bg-black"></div><div class="size-2 bg-gray-200"></div><div class="size-2 bg-black"></div>
                </div>
            </div>
            <p class="text-[8px] uppercase tracking-tighter text-neutral-400">Comprobante Fiscal Digital Educativo</p>
            <p class="text-[8px] text-neutral-400">{{ $transaction->created_at->format('Y-m-d H:i:s') }}</p>
        </div>
    </div>
</div>