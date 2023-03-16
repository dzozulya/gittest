<?php

namespace App\Services;

use GrahamCampbell\GitHub\GitHubManager;
use Laravel\Socialite\Facades\Socialite;
use Laravel\Socialite\SocialiteManager;

class GitHubService
{
   private const AUTH_TYPE_GIT_HUB ='github';
   private const CONNECTION_TYPE_GIT_HUB ='app';

   private $gitHubConnection;
   private $socialiteDriver;
   private string $authorGitId;

    public function __construct(GitHubManager  $gitHubManager, SocialiteManager $socialite)
    {
       $this->gitHubConnection = $gitHubManager->connection(self::CONNECTION_TYPE_GIT_HUB);
       $this->socialiteDriver = $socialite->driver(self::AUTH_TYPE_GIT_HUB);
       $this->authorGitId= env('AUTHOR_GIT_ID');
    }


    public function redirect ()
    {
        return $this->socialiteDriver->redirect();
    }
    public function getLoginedUser()
    {
        return $this->socialiteDriver->stateless()->user();
    }
    private function getUserbyGithubId(string $gitId) : array
    {
        return $this->gitHubConnection->user()->showById($gitId);
    }
    private function getUserReposByNickName(string $nickName) : array
    {
        return $this->gitHubConnection->user()->repositories($nickName);
    }
    public function  getProfileData(string $gitId) : array
    {
        $user= $this->getUserbyGithubId($gitId);
        $repos = $this->getUserReposByNickName($user['login']);

        return ['user'=>$user,
                'repos'=>$repos,
                'authorGitId'=>$this->authorGitId];
    }


}
