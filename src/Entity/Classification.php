<?php

namespace App\Entity;

enum Classification: string
{
    case CHILD = 'CHILD';
    case ADULT = 'ADULT';

    public function isChild(): bool
    {

        return $this === self::CHILD;
    }

    public static function getClassification(int $age): Classification
    {

        return $age >= 18 ? self::ADULT : self::CHILD;
    }
}
