<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Ramsey\Uuid\Uuid;

class Task extends Model
{
    use HasFactory;
    protected $primaryKey = 'id'; // If using UUIDs, ensure it's of type UUID
    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'title', 'description', 'status', 'user_id', 'project_id'
    ];

    protected static function boot()
    {
        parent::boot();

        // Generate a UUID for new records
        static::creating(function ($model) {
            $model->id = (string)Uuid::uuid4();
        });
    }

    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getCreatedAtAttribute($value)
    {
        return \Carbon\Carbon::createFromTimeStamp(strtotime($value))->format('d/m/Y');
    }

}
