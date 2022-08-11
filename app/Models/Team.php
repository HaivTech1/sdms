<?php
namespace App;

use Mpociot\Teamwork\TeamworkTeam;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Team extends TeamworkTeam
{
    public function tasks(): HasMany
    {
        return $this->hasMany(Task::class);
    }
    
    public function id(): string
    {
        return (string) $this->id;
    }

    public function name(): string
    {
        return $this->name;
    }
}