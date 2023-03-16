<?php

namespace App\Http\Controllers;

use App\Models\User;
use GrahamCampbell\GitHub\Facades\GitHub;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class GitHubController extends Controller
{
    const AUTH_TYPE_GIT_HUB ='github';

    public function gitRedirect()
    {
        return Socialite::driver(self::AUTH_TYPE_GIT_HUB)->redirect();
    }

    public function gitCallback()
    {
        try {

            $user = Socialite::driver(self::AUTH_TYPE_GIT_HUB)->stateless()->user();

            $searchUser = User::where('github_id', $user->id)->first();
            if($searchUser){

                Auth::login($searchUser);

              return  redirect()->route('git.profile', ['gitId'=>$user->id]);

            }else{
                $gitUser = User::create([
                    'name' => $user->nickname,
                    'email' => $user->email,
                    'github_id'=> $user->id,
                    'auth_type'=> self::AUTH_TYPE_GIT_HUB,
                    'password' => encrypt('gitpwd059')
                ]);

                Auth::login($gitUser);

                return  redirect()->route('git.profile', ['gitId'=>$user->id]);
            }

        } catch (Exception $e) {
            dd($e->getMessage());
        }
    }

    public function gitProfile(string $gitId)
    {
        $user =GitHub::connection('app')->user()-> showById($gitId);
       // dd($user);
        $repos=GitHub::connection('app')->user()->repositories('agent3030');



        return view('git.profile',['user'=>$user,
                                        'repos'=>$repos]);
    }
}
