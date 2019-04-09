<?php

namespace App\Observers;

use App\Repositories\UserRepository;
use App\Services\UserService;
use App\User;
use Illuminate\Support\Facades\Auth;


class UserObserver
{
    private $userService;
    private $userRepository;
    /**
     * Handle the user "created" event.
     *
     * @param  \App\User  $user
     * @return void
     */
    public function __construct(UserService $userService, UserRepository $userRepository){
        $this->userService = $userService;
        $this->userRepository = $userRepository;
    }

    public function created(User $user)
    {
        //
    }

    /**
     * Handle the user "updated" event.
     *
     * @param  \App\User  $user
     * @return void
     */
    public function updating(User $user)
    {
        //
        $userBeforeUpdated = $this->userRepository->find($user->id);
        
        $this->userService->trackUserActivity(Auth::id(),User::class, config('constants.TRACK_USER_FIELDS'),
            $userBeforeUpdated, $user);
    }

    /**
     * Handle the user "deleted" event.
     *
     * @param  \App\User  $user
     * @return void
     */
    public function deleted(User $user)
    {
        //
    }

    /**
     * Handle the user "restored" event.
     *
     * @param  \App\User  $user
     * @return void
     */
    public function restored(User $user)
    {
        //
    }

    /**
     * Handle the user "force deleted" event.
     *
     * @param  \App\User  $user
     * @return void
     */
    public function forceDeleted(User $user)
    {
        //
    }
}
