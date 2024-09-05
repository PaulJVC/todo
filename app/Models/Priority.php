<?php

namespace App\Models;

use App\Models\Task;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Priority extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'level'
    ];

    public function Task() {
        return $this->hasMany(Task::class);
    }
}
