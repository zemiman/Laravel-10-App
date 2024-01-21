<?php

namespace App\Policies;

use Illuminate\Auth\Access\Response;
use App\Models\project;
use App\Models\User;

class ProjectPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, project $project): bool
    {
        // if($user->id===$project->creator_id){
        //     return true;
        // }
        // if($user->memberships->contains($project)){
        //     return true;
        // }

        // return false;
        // the creator of the project simply a membership
        return $user->memberships->contains($project);
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, project $project): bool
    {
        return $user->id===$project->creator_id;
    }
    
    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, project $project): bool
    {
        return $user->id===$project->creator_id;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, project $project): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, project $project): bool
    {
        return false;
    }
}
