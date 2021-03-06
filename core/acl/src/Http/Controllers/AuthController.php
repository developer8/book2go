<?php

namespace Botble\ACL\Http\Controllers;

use AclManager;
use Auth;
use Botble\ACL\Repositories\Interfaces\UserInterface;
use Botble\Base\Http\Controllers\BaseController;
use Exception;
use Socialite;

class AuthController extends BaseController
{
    /**
     * @var UserInterface
     */
    protected $userRepository;

    /**
     * UserController constructor.
     * @param UserInterface $userRepository
     */
    public function __construct(
        UserInterface $userRepository
    ) {
        $this->userRepository = $userRepository;
    }

    /**
     * Redirect the user to the {provider} authentication page.
     *
     * @param $provider
     * @return mixed
     * @author Sang Nguyen
     */
    public function redirectToProvider($provider)
    {
        return Socialite::driver($provider)->redirect();
    }

    /**
     * Obtain the user information from {provider}.
     * @param $provider
     * @return \Illuminate\Http\RedirectResponse
     * @author Sang Nguyen
     */
    public function handleProviderCallback($provider)
    {
        try {
            /**
             * @var \Laravel\Socialite\AbstractUser $oAuth
             */
            $oAuth = Socialite::driver($provider)->user();
        } catch (Exception $ex) {
            return redirect()->route('access.login')->with('error_msg', $ex->getMessage());
        }

        $user = $this->userRepository->getFirstBy(['email' => $oAuth->getEmail()]);

        if ($user) {
            if (!AclManager::getActivationRepository()->completed($user)) {
                return redirect()->back()->with('error_msg', trans('core.acl::auth.login.not_active'));
            }

            Auth::login($user, true);
            return redirect()->route('dashboard.index')->with('success_msg', trans('core.acl::auth.login.success'));
        }
        return redirect()->route('access.login')->with('error_msg', trans('core.acl::auth.login.dont_have_account'));
    }
}
