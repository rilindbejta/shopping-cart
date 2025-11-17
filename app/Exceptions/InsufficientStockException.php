<?php

namespace App\Exceptions;

use Exception;

class InsufficientStockException extends Exception
{
    public static function forProduct(string $productName, int $available): self
    {
        return new self("Insufficient stock for {$productName}. Only {$available} available.");
    }

    public static function forQuantity(int $requested, int $available): self
    {
        return new self("Cannot add {$requested} items. Only {$available} available in stock.");
    }
}

