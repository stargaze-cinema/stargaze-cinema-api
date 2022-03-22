<?php

declare(strict_types=1);

namespace App\Enum;

enum Role: string {
    case User = 'User';
    case Moder = 'Moderator';
    case Admin = 'Administrator';
}
