<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class Twitter
{
    /**
     * @var
     */
    protected $username;

    /**
     * @var array
     */
    protected $users = [];

    /**
     * Twitter constructor.
     * @param $username
     */
    public function __construct($username)
    {
        $this->username = $username;
    }

    /**
     * @return array|mixed
     */
    public function getUser()
    {
        $user = Http::withToken(config('twitter.token'))->get("https://api.twitter.com/1.1/users/show.json?screen_name={$this->username}");

        if (!$user->ok()) {
            abort(404);
        }

        return $user->json();
    }

    /**
     * generate circle users
     */
    public function generateCircle()
    {
        $this->calculateFavorites();
        usort($this->users, function ($a, $b) {
            return strcmp($b['score'], $a['score']);
        });

        return array_slice($this->users, 0, 52);
    }

    /**
     * calculate favorites
     */
    protected function calculateFavorites()
    {
        $list = Http::withToken(config('twitter.token'))->get("https://api.twitter.com/1.1/favorites/list.json?count=300&screen_name={$this->username}");
        if (!$list->ok()) {
            abort(404);
        }

        foreach ($list->json() as $fav) {
            $user = $fav['user'];
            $score = 1;
            if ($fav['in_reply_to_user_id']) {
                $score = 1.1;
            }
            if (isset($this->users[$user['id_str']])) {
                $existUser = $this->users[$user['id_str']];
                $this->setUser($user, $existUser['fav'] + 1, $existUser['reply'], $existUser['retweet'], $existUser['score'] + $score);
            } else {
                $this->setUser($user, 1, 0, 0, $score);
            }
        }
    }

    /**
     * @param $user
     * @param $fav
     * @param $reply
     * @param $retweet
     * @param $score
     */
    protected function setUser($user, $fav, $reply, $retweet, $score)
    {
        $this->users[$user['id_str']] = [
            'id' => $user['id_str'],
            'name' => $user['name'],
            'screen_name' => $user['screen_name'],
            'avatar' => str_replace('normal', '400x400', $user['profile_image_url_https']),
            'fav' => $fav,
            'reply' => $reply,
            'retweet' => $retweet,
            'score' => $score
        ];
    }
}
