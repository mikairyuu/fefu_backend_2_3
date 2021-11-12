<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int suggestion_freq //каждые сколько запросов мы показываем предложение
 * @property int suggestion_max_count //каждые сколько предложений мы прекращаем их показывать
 */

class Setting extends Model
{
    use HasFactory;
}
