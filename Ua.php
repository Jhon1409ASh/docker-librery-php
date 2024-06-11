<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class Ua extends Model
{
    use HasFactory, LogsActivity;

    /**
     * Logs config
     */
    protected static $logAttributes = ['*'];
    protected static $logOnlyDirty = true;
    protected static $submitEmptyLogs = false;

    protected $fillable = [
        'id', 'parent_id', 'type', 'key', 'abbreviation', 'name', 'owner', 'position'
    ];

    public function setAbbreviationAttribute($value)
    {
        $this->attributes['abbreviation'] = mb_strtoupper($value);
    }

    public function setNameAttribute($value)
    {
        $this->attributes['name'] = mb_strtoupper($value);
    }

    // scopes 
    public function scopeOfSearch($query, $search)
    {
        return $query->where("name", "like", "%{$search}%")
            ->orWhere("abbreviation", "like", "%{$search}%")
            ->orWhere("key", "like", "%{$search}%");
    }

    // relations
    public function children()
    {
        return $this->hasMany(Ua::class, 'parent_id')
            ->with('children')->orderBy('id');
    }
}
