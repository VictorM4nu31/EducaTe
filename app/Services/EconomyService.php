<?php

namespace App\Services;

use App\Models\Wallet;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Exception;

class EconomyService
{
    const TAX_RATE = 0.05; // 5% SAT tax

    /**
     * Credit AC to a user (e.g. for task completion) with automatic tax deduction.
     */
    public function credit(User $user, float $amount, string $description, array $metadata = [])
    {
        return DB::transaction(function () use ($user, $amount, $description, $metadata) {
            $wallet = $user->wallet ?: $user->wallet()->create(['balance' => 0]);
            
            $taxAmount = $amount * self::TAX_RATE;
            $netAmount = $amount - $taxAmount;

            // 1. Transaction for the gross income (for record)
            $transaction = $wallet->transactions()->create([
                'amount' => $amount,
                'type' => 'income',
                'description' => $description,
                'metadata' => array_merge($metadata, ['tax_deducted' => $taxAmount]),
            ]);

            // 2. Transaction for the tax deduction
            $wallet->transactions()->create([
                'amount' => -$taxAmount,
                'type' => 'tax',
                'description' => "Retención SAT (5%) - $description",
                'rfc_receiver' => 'SAT-FONDO-COMUN', // Common fund identifier
            ]);

            // 3. Update wallet balance with net amount
            $wallet->increment('balance', $netAmount);

            return $transaction;
        });
    }

    /**
     * Debit AC from a user (e.g. for marketplace or hints).
     */
    public function debit(User $user, float $amount, string $description, string $type = 'expense', array $metadata = [])
    {
        return DB::transaction(function () use ($user, $amount, $description, $type, $metadata) {
            $wallet = $user->wallet;

            if (!$wallet || $wallet->balance < $amount) {
                throw new Exception("Saldo insuficiente de AulaChain.");
            }

            $transaction = $wallet->transactions()->create([
                'amount' => -$amount,
                'type' => $type,
                'description' => $description,
                'metadata' => $metadata,
            ]);

            $wallet->decrement('balance', $amount);

            return $transaction;
        });
    }

    /**
     * Transfer AC between students (P2P).
     */
    public function transfer(User $sender, User $receiver, float $amount, string $description = 'Transferencia P2P')
    {
        return DB::transaction(function () use ($sender, $receiver, $amount, $description) {
            if ($sender->id === $receiver->id) {
                throw new Exception("No puedes transferirte a ti mismo.");
            }

            // Debit sender
            $this->debit($sender, $amount, "Transferencia enviada a {$receiver->name}", 'p2p', [
                'receiver_id' => $receiver->id,
                'receiver_name' => $receiver->name,
            ]);

            // Credit receiver (P2P transfers might not be taxed per requirement, or maybe they are? 
            // Conceptually P2P is already net money. I'll credit without extra tax for now).
            $receiverWallet = $receiver->wallet ?: $receiver->wallet()->create(['balance' => 0]);
            
            $transaction = $receiverWallet->transactions()->create([
                'amount' => $amount,
                'type' => 'p2p',
                'description' => "Transferencia recibida de {$sender->name}: $description",
                'rfc_sender' => $sender->rfc,
                'metadata' => ['sender_id' => $sender->id],
            ]);

            $receiverWallet->increment('balance', $amount);

            return $transaction;
        });
    }
}
