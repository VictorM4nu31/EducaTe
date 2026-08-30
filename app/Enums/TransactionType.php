<?php

namespace App\Enums;

enum TransactionType: string
{
    case Income = 'income';
    case Expense = 'expense';
    case Tax = 'tax';
    case P2p = 'p2p';
    case Reward = 'reward';

    /**
     * Mapea tipos heredados ('deposit'/'withdraw') al vocabulario actual.
     */
    public static function fromLegacy(string $type): self
    {
        return match ($type) {
            'deposit' => self::Income,
            'withdraw' => self::Expense,
            default => self::from($type),
        };
    }
}
