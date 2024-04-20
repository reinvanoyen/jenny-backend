<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reply extends Model
{
    use HasFactory;

    protected $table = 'replies';

    const TYPE_ADDED = 0;
    const TYPE_DELETED = 1;
    const TYPE_HELP = 2;
    const TYPE_DAILY = 3;
    const TYPE_WEEKLY = 4;
    const TYPE_FRIDAY = 5;
    const TYPE_RANDOM = 6;
}
