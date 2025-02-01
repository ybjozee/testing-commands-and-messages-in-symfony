<?php

namespace App\Message;

final class CreatePerson {
    public function __construct(
        public readonly string $name,
        public readonly int $age,
    ) {
    }
}
