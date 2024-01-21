<?php

namespace App\Models;

use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Task extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'is_done',
        'project_id'  
    ];
    protected $casts=[
        'is_done'=>'boolean'
    ];

    // protected $hidden=[
    //     'updated_at'
    // ];

    public function creator():BelongsTo
    {
        return $this->belongsTo(User::class, 'creator_id');
    }
    public function project():BelongsTo
    {
        return $this->belongsTo(Project::class);
    }
    //Filters Tasks only created by the logged in 
    protected static function booted():void{
        static::addGlobalScope('member', function(Builder $builder){
            $builder->where('creator_id', Auth::id())
            ->orWhereIn('project_id', Auth::user()->memberships->pluck('id'));
        });
    }
}
