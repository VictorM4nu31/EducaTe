<?php

namespace App\Support;

/**
 * Utilidades para operar con dinero de forma precisa.
 *
 * El sistema trabaja internamente con centavos (enteros) para evitar errores
 * de redondeo en punto flotante; la conversión a unidades (AC) se hace solo
 * en el borde de entrada/salida.
 */
final class Money
{
    /**
     * Convierte una cantidad en AC a centavos enteros.
     */
    public static function toCents(float|int $amount): int
    {
        return (int) round(((float) $amount) * 100);
    }

    /**
     * Convierte centavos enteros a una cantidad en AC (hasta 2 decimales).
     */
    public static function fromCents(int $cents): float
    {
        return $cents / 100;
    }
}
