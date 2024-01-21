<?php

namespace App\Models;

use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;


class Project extends Model
{
    use HasFactory;

    
    protected $fillable=[
        'title'
    ];
    public function tasks():HasMany{
        return $this->hasMany(Task::class);
    }

    public function creator():BelongsTo{
        return $this->belongsTo(User::class, 'creator_id');
    }

    public function members():BelongsToMany{
        return $this->belongsToMany(User::class, Member::class);
    }

    //Filters Projects only created by the logged in 
    protected static function booted():void{
        // static::addGlobalScope('creator', function(Builder $builder){
        //     $builder->where('creator_id', Auth::id());
        static::addGlobalScope('members', function(Builder $builder){
            $builder->whereRelation('members','user_id', Auth::id());
        });
    }

}
