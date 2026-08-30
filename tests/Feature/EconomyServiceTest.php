<?php

use App\Enums\TransactionType;
use App\Models\User;
use App\Services\EconomyService;
use App\Support\Money;

function walletBalance(User $user): float
{
    return (float) $user->wallet()->first()->balance;
}

test('retiene el 5% de impuestos al acreditar', function () {
    $user = User::factory()->create();

    app(EconomyService::class)->credit($user, 30, 'Premio de prueba');

    $wallet = $user->wallet()->first();

    expect(walletBalance($user))->toBe(28.5);
    expect($wallet->transactions()->where('type', 'income')->count())->toBe(1);
    expect($wallet->transactions()->where('type', 'tax')->count())->toBe(1);
    expect((float) $wallet->transactions()->where('type', 'tax')->value('amount'))->toBe(-1.5);
});

test('puede acreditar sin retencion de impuestos', function () {
    $user = User::factory()->create();

    app(EconomyService::class)->credit($user, 100, 'Saldo a favor (sin retención)', [], TransactionType::Income, false);

    $wallet = $user->wallet()->first();

    expect(walletBalance($user))->toBe(100.0);
    expect($wallet->transactions()->where('type', 'tax')->count())->toBe(0);
});

test('rebaja el saldo al debitar', function () {
    $user = User::factory()->create();
    app(EconomyService::class)->credit($user, 100, 'Carga inicial', [], TransactionType::Income, false);

    app(EconomyService::class)->debit($user, 40, 'Pista de examen', TransactionType::Expense);

    expect(walletBalance($user))->toBe(60.0);
    expect($user->wallet()->first()->transactions()->where('type', 'expense')->count())->toBe(1);
});

test('rechaza debitar con saldo insuficiente sin modificar el saldo', function () {
    $user = User::factory()->create();
    app(EconomyService::class)->credit($user, 20, 'Carga inicial', [], TransactionType::Income, false);

    expect(fn () => app(EconomyService::class)->debit($user, 50, 'Gasto excesivo'))
        ->toThrow(InvalidArgumentException::class);

    expect(walletBalance($user))->toBe(20.0);
});

test('transfiere entre usuarios sin retencion y bloquea la auto-transferencia', function () {
    $sender = User::factory()->create();
    $receiver = User::factory()->create();

    app(EconomyService::class)->credit($sender, 100, 'Carga inicial', [], TransactionType::Income, false);

    app(EconomyService::class)->transfer($sender, $receiver, 30, 'Regalo');

    expect(walletBalance($sender))->toBe(70.0);
    expect(walletBalance($receiver))->toBe(30.0);

    expect(fn () => app(EconomyService::class)->transfer($sender, $sender, 10))
        ->toThrow(InvalidArgumentException::class);

    expect(walletBalance($sender))->toBe(70.0);
});

test('convierte montos a centavos y viceversa sin perdida de precision', function () {
    expect(Money::toCents(9.99))->toBe(999);
    expect(Money::fromCents(999))->toBe(9.99);
    expect(Money::toCents(0.005))->toBe(1);
    expect(Money::fromCents(Money::toCents(123.45)))->toBe(123.45);
});
