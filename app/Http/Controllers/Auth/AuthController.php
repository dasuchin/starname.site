<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\Models\Role;
use App\Models\SocialLogin;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;

class AuthController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Registration & Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users, as well as the
    | authentication of existing users. By default, this controller uses
    | a simple trait to add these behaviors. Why don't you explore it?
    |
    */

    use AuthenticatesAndRegistersUsers, ThrottlesLogins;

    /**
     * Create a new authentication controller instance.
     *
     */
    public function __construct()
    {
        $this->middleware('guest', ['except' => 'logout']);
    }

    /**
     * @param $provider
     * @return mixed
     */
    public function redirectToProvider($provider)
    {
        $providerKey = \Config::get('services.' . $provider);
        if (empty($providerKey)) {
            return \View::make('errors.404');
        }

        return Socialite::driver($provider)->redirect();
    }

    /**
     * @param $provider
     * @return mixed
     */
    public function handleProviderCallback($provider)
    {
        try {
            $user = Socialite::driver($provider)->user();
        } catch (Exception $e) {
            return redirect('auth/' . $provider);
        }

        $authUser = $this->findOrCreateUser($user, $provider);

        Auth::login($authUser, true);
        //dd(Auth::getUser());

        return \Redirect::intended();
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|confirmed|min:6',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return User
     */
    protected function create(array $data)
    {
        $params = [
            'name' => (!empty($data['name'])) ? $data['name'] : '',
            'email' => $data['email']
        ];

        if (!empty($data['password'])) {
            $params['password'] = bcrypt($data['password']);
        }

        $user = User::create($params);

        // Assign default role of user
        $role = Role::where('name', 'user')->first();
        $user->assignRole($role);

        return $user;
    }

    /**
     * @param $user
     * @param $provider
     * @return User
     */
    private function findOrCreateUser($user, $provider)
    {
        $socialRecord = SocialLogin::where('social_id', $user->id)->where('provider', $provider)->first();

        if (!empty($socialRecord)) {
            return $socialRecord->user;
        }

        $authUser = User::where('email', $user->email)->first();
        if ($authUser){
            $this->createSocial($authUser->id, $user, $provider);
            return $authUser;
        }

        $newUser = $this->create((array)$user);
        $this->createSocial($newUser->id, $user, $provider);

        return $newUser;
    }

    private function createSocial($userId, $user, $provider)
    {
        SocialLogin::create([
            'user_id' => $userId,
            'provider' => $provider,
            'social_id' => $user->id,
            'avatar' => $user->avatar
        ]);
    }
}