<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property string|null $name
 * @property string|null $email
 * @property string|null $message
 * @property string|null $phone
 */
class Appeal extends Model
{
    use HasFactory;
}
