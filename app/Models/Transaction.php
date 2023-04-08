<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class Transaction extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'from',
        'to',
        'amount',
        'reference_number'
    ];

    protected $appends = [
        'diffForHumans'
    ];

    protected static function boot()
    {
        parent::boot();
        // auto-sets values on creation
        static::creating(function ($query) {
            if(!$query->reference_number){
                $query->reference_number = now()->year . now()->timestamp;
            }
        });
    }

    public function from(){
        return $this->hasOne(User::class, 'id', 'from');
    }

    public function to(){
        return $this->hasOne(User::class, 'id', 'to');
    }

    public function getDiffForHumansAttribute() {
        return $this->created_at->diffForHumans();
    }
}
