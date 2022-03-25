<?php

declare(strict_types=1);

namespace App\Enum;

enum HallType: string {
    case TwoD = '2D';
    case ThreeD = '3D';
    case FourDX = '4DX';
    case FiveD = '5D';

    public static function getRandom(): self
    {
        $cases = HallType::cases();
        return $cases[array_rand($cases)];
    }
}
