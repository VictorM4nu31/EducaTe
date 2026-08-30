<?php

namespace App\Services;

use App\Enums\TransactionType;
use App\Models\Transaction;
use App\Models\User;
use App\Support\Money;
use Illuminate\Support\Facades\DB;
use InvalidArgumentException;

class EconomyService
{
    /**
     * Retención de impuestos (SAT) en puntos base: 500 = 5%.
     */
    public const TAX_RATE_BASIS_POINTS = 500;

    /**
     * Acreditar AC a un usuario (p. ej. por completar una tarea) con retención
     * de impuestos automática. Es la única vía de ingreso al sistema.
     */
    public function credit(
        User $user,
        float $amount,
        string $description,
        array $metadata = [],
        TransactionType $type = TransactionType::Income,
        bool $taxed = true,
    ): Transaction {
        return DB::transaction(function () use ($user, $amount, $description, $metadata, $type, $taxed) {
            $wallet = $user->wallet ?: $user->wallet()->create(['balance' => 0]);

            $amountCents = Money::toCents($amount);
            $taxCents = $taxed
                ? (int) round($amountCents * self::TAX_RATE_BASIS_POINTS / 10000)
                : 0;
            $netCents = $amountCents - $taxCents;

            $transaction = $wallet->transactions()->create([
                'amount' => Money::fromCents($amountCents),
                'type' => $type->value,
                'description' => $description,
                'metadata' => array_merge($metadata, [
                    'tax_deducted' => Money::fromCents($taxCents),
                ]),
            ]);

            if ($taxCents > 0) {
                $wallet->transactions()->create([
                    'amount' => Money::fromCents(-$taxCents),
                    'type' => TransactionType::Tax->value,
                    'description' => "Retención SAT (5%) - {$description}",
                    'rfc_receiver' => 'SAT-FONDO-COMUN',
                ]);
            }

            $wallet->increment('balance', Money::fromCents($netCents));

            return $transaction;
        });
    }

    /**
     * Debitar AC de un usuario (marketplace, pistas, etc.).
     */
    public function debit(
        User $user,
        float $amount,
        string $description,
        TransactionType $type = TransactionType::Expense,
        array $metadata = [],
    ): Transaction {
        return DB::transaction(function () use ($user, $amount, $description, $type, $metadata) {
            $wallet = $user->wallet;

            if (! $wallet) {
                throw new InvalidArgumentException('Aún no tienes una cuenta AulaChain.');
            }

            $amountCents = Money::toCents($amount);

            if ($amountCents <= 0) {
                throw new InvalidArgumentException('El monto a debitar debe ser mayor a cero.');
            }

            if (Money::toCents($wallet->balance) < $amountCents) {
                throw new InvalidArgumentException('Saldo insuficiente de AulaChain.');
            }

            $transaction = $wallet->transactions()->create([
                'amount' => Money::fromCents(-$amountCents),
                'type' => $type->value,
                'description' => $description,
                'metadata' => $metadata,
            ]);

            $wallet->decrement('balance', Money::fromCents($amountCents));

            return $transaction;
        });
    }

    /**
     * Transferir AC entre estudiantes (P2P). La transferencia no aplica retención.
     */
    public function transfer(
        User $sender,
        User $receiver,
        float $amount,
        string $description = 'Transferencia P2P',
    ): Transaction {
        return DB::transaction(function () use ($sender, $receiver, $amount, $description) {
            if ($sender->id === $receiver->id) {
                throw new InvalidArgumentException('No puedes transferirte a ti mismo.');
            }

            $amountCents = Money::toCents($amount);

            if ($amountCents <= 0) {
                throw new InvalidArgumentException('El monto a transferir debe ser mayor a cero.');
            }

            $senderWallet = $sender->wallet;

            if (! $senderWallet || Money::toCents($senderWallet->balance) < $amountCents) {
                throw new InvalidArgumentException('Saldo insuficiente de AulaChain.');
            }

            $senderWallet->transactions()->create([
                'amount' => Money::fromCents(-$amountCents),
                'type' => TransactionType::P2p->value,
                'description' => "Transferencia enviada a {$receiver->name}: {$description}",
                'rfc_receiver' => $receiver->rfc,
                'metadata' => ['receiver_id' => $receiver->id],
            ]);
            $senderWallet->decrement('balance', Money::fromCents($amountCents));

            $receiverWallet = $receiver->wallet ?: $receiver->wallet()->create(['balance' => 0]);

            $transaction = $receiverWallet->transactions()->create([
                'amount' => Money::fromCents($amountCents),
                'type' => TransactionType::P2p->value,
                'description' => "Transferencia recibida de {$sender->name}: {$description}",
                'rfc_sender' => $sender->rfc,
                'metadata' => ['sender_id' => $sender->id],
            ]);
            $receiverWallet->increment('balance', Money::fromCents($amountCents));

            return $transaction;
        });
    }

    /**
     * Retención esperada para una cantidad (util para resúmenes en la UI).
     */
    public function taxFor(float $amount): float
    {
        $amountCents = Money::toCents($amount);

        return Money::fromCents((int) round($amountCents * self::TAX_RATE_BASIS_POINTS / 10000));
    }
}
