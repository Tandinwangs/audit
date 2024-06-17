<?php

namespace App\Policies;

use App\Models\Response;
use App\Models\User;
// use Illuminate\Auth\Access\Response;
use \Chiiya\FilamentAccessControl\Models\FilamentUser;
use App\Models\Engagement;
use App\Models\Issue;

class ResponsePolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(FilamentUser $user): bool
    {
        return $user->can('response.view');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(FilamentUser $user, Response $response): bool
    {
        return $user->can('response.view');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(FilamentUser $user): bool
    {
        return $user->can('response.create');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(FilamentUser $user, Response $response): bool
    {
        $responseID = Response::where('id', $response->id)->value('issue_id');
        $issueID = Issue::where('id', $responseID)->value('engagement_id');
        $engagementID = Engagement::where('created_by', $user->id)
        ->where('id', $issueID)
        ->value('id');

        return $engagementID === $issueID;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(FilamentUser $user, Response $response): bool
    {
        $responseID = Response::where('id', $response->id)->value('issue_id');
        $issueID = Issue::where('id', $responseID)->value('engagement_id');
        $engagementID = Engagement::where('created_by', $user->id)
        ->where('id', $issueID)
        ->value('id');

        return $engagementID === $issueID;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(FilamentUser $user, Response $response): bool
    {
        return true;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(FilamentUser $user, Response $response): bool
    {
        return false;
    }
}
