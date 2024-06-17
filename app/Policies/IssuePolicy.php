<?php

namespace App\Policies;

use App\Models\Issue;
use App\Models\User;
use Illuminate\Auth\Access\Response;
use \Chiiya\FilamentAccessControl\Models\FilamentUser;
use App\Models\Engagement;

class IssuePolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(FilamentUser $user): bool
    {
        return $user->can('issue.view');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(FilamentUser $user, Issue $issue): bool
    {
        return $user->can('issue.view');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(FilamentUser $user): bool
    {
        return $user->can('issue.create');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(FilamentUser $user, Issue $issue): bool
    {
        $issueID = Issue::where('id', $issue->id)->value('engagement_id');
        $engagementID = Engagement::where('created_by', $user->id)
        ->where('id', $issueID)
        ->value('id');

        return $engagementID === $issueID;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(FilamentUser $user, Issue $issue): bool
    {
        $issueID = Issue::where('id', $issue->id)->value('engagement_id');
        $engagementID = Engagement::where('created_by', $user->id)
        ->where('id', $issueID)
        ->value('id');

        return $engagementID === $issueID;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(FilamentUser $user, Issue $issue): bool
    {
        return true;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    // public function forceDelete(FilamentUser $user, Issue $issue): bool
    // {
    //     return true;
    // }
}
