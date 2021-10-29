<?php

namespace App\Models;

use App\Enums\Gender;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property string $name
 * @property string $surname
 * @property string|null $patronymic
 * @property int $age
 * @property int $gender @see Gender
 * @property string|null $email
 * @property string $message
 * @property string|null $phone
 */
class Appeal extends Model
{
    use HasFactory;
}
