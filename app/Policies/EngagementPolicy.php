<?php

namespace App\Policies;

use App\Models\Engagement;
use App\Models\User;
use Illuminate\Auth\Access\Response;
use \Chiiya\FilamentAccessControl\Models\FilamentUser;

class EngagementPolicy
{
    public function viewAny(FilamentUser $user): bool {
        return $user->can('engagement.view');
    }

    public function view(FilamentUser $user, Engagement $engagement): bool {
        return $user->can('engagement.view');
    }

    public function create(FilamentUser $user): bool {
        return $user->can('engagement.create');
    }

    public function update(FilamentUser $user, Engagement $engagement): bool {
        return $user->id === (int)$engagement->created_by;
    }

    public function delete(FilamentUser $user, Engagement $engagement): bool
    {
        return $user->id === (int)$engagement->created_by;
    }

    public function deleteAny(FilamentUser $user): bool
    {
        return false;
    }
}
