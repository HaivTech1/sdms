<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Contest extends Model
{
    use HasFactory;

    const TABLE = 'contests';

    protected $table = self::TABLE;

    protected $fillable = [
        'title', 
        'theme', 
        'start', 
        'end', 
        'budget',
        'isAvailable'
     ];

     
    protected $casts = [
        'isAvailable'  => 'boolean',
        'start' => 'datetime',
        'end' => 'datetime',
    ];

     public function getAvailableBadgeAttribute()
     {
 
         $available = [
             '0' => 'Not Active',
             '1' => 'Active',
         ];
 
         return $available[$this->isAvailable];
     }

     public function contestants(): HasMany
     {
         return $this->hasMany(Contestant::class, 'contest_id');
     }

     public function id(): string
     {
         return (string) $this->id;
     }
 
     public function title(): string
     {
         return $this->title;
     }

     public function theme(): string
     {
         return $this->theme;
     }

     public function budget(): string
     {
         return $this->budget;
     }

     public function startDate(): string
     {
         return $this->start->format('d F Y');
     }
 
     public function endDate(): string
     {
         return $this->end->format('d F Y');
     }
}