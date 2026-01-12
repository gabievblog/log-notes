<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Models\TaskItem;

class Task extends Model
{
    protected $fillable = [
        'title',
        //'user_id'
    ];

    public function taskItems(): HasMany
    {
        return $this->hasMany(TaskItem::class);
    }
}
