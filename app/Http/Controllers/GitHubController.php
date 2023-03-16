<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Services\GitHubService;
use GrahamCampbell\GitHub\Facades\GitHub;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class GitHubController extends Controller
{
    private GitHubService $gitHubService;

    public function __construct( GitHubService $gitHubService)
    {
        $this->gitHubService = $gitHubService;
    }

    public function gitRedirect()
    {
        return $this->gitHubService->redirect();
    }

    public function gitCallback()
    {
        try {

            $user = $this->gitHubService->getLoginedUser();

            $searchUser = User::where('github_id', $user->id)->first();
            if($searchUser){

                Auth::login($searchUser);

              return  redirect()->route('git.profile', ['gitId'=>$user->id]);

            }else{
                $gitUser = User::create([
                    'name' => $user->nickname,
                    'email' => $user->email,
                    'github_id'=> $user->id,
                    'auth_type'=> 'github',
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
        return view('git.profile',$this->gitHubService->getProfileData($gitId));
    }
}
