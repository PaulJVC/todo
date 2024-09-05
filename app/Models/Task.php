<?php

namespace App\Models;

use App\Models\User;
use App\Models\Priority;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Task extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'completed',
        'due_date',
        'archived',
        'attachment',
        'tags',
    ];

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function priority() {
        return $this->belongsTo(Priority::class);
    }
}
