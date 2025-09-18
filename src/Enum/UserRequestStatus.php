<?php

namespace App\Enum;

enum UserRequestStatus: string
{
    case Pending = 'pending';
    case InProgress = 'in_progress';
    case Completed = 'completed';

    public function label(): string {
        return match($this) {
            self::Pending => 'En attente',
            self::InProgress => 'En cours',
            self::Completed => 'Terminé',
        };
    }
}
