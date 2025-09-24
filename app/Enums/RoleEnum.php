<?php

namespace App\Enums;

enum RoleEnum: string
{
    case SUPER_ADMIN = 'superadmin';
    case ADMIN = 'admin';
    case STAFF = 'staff';

    public static function getValues(): array
    {
        return array_column(self::cases(), 'value');
    }
}
