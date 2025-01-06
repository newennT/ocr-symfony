<?php

namespace App\Enum;

enum CommentStatus: string
{
    case Pending = 'pending';
    case Published = 'published';
    case Moderated = 'Moderated';
    
    public function getLabel(): string
    {
        return match ($this) {
            self::Pending => 'En cours de modération',
            self::Published => 'Publié',
            self::Moderated => 'Modéré',
        };
    }
}