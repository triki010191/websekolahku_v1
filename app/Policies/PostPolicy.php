<?php

namespace App\Policies;

use App\Models\Post;
use App\Models\User;

class PostPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->isSuperAdmin() || $user->hasRole(User::ROLE_ADMIN_BERITA);
    }

    public function create(User $user): bool
    {
        return $this->viewAny($user);
    }

    public function update(User $user, Post $post): bool
    {
        return $this->viewAny($user);
    }

    public function delete(User $user, Post $post): bool
    {
        return $this->viewAny($user);
    }
}
