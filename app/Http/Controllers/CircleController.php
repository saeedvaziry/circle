<?php

namespace App\Http\Controllers;

use App\Models\Limit;
use App\Services\Twitter;
use Exception;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class CircleController extends Controller
{
    /**
     * @return Application|Factory|View
     */
    public function index()
    {
        return view('index');
    }

    /**
     * @param Request $request
     * @return Application|Factory|View|RedirectResponse|Redirector
     * @throws ValidationException
     * @throws Exception
     */
    public function generate(Request $request)
    {
        $this->validate($request, [
            'username' => 'required'
        ]);

        $cache = Cache::get($request->username);
        if ($cache) {
            $cache = json_decode($cache, true);
            $currentUser = $cache['currentUser'];
            $users = $cache['users'];
            $fromCache = true;
        } else {
            try {
                DB::beginTransaction();
                $limit = Limit::query()->lockForUpdate()->first();
                if ($limit->available == 0) {
                    return redirect('/');
                }

                $limit->available = $limit->available - 1;
                $limit->save();
                DB::commit();
            } catch (Exception $e) {
                DB::rollBack();
                throw $e;
            }

            $twitter = new Twitter($request->username);
            $currentUser = $twitter->getUser();
            $users = $twitter->generateCircle();

            // cache data
            $this->cacheData($request->username, $users, $currentUser);

            $fromCache = false;
        }

        return view('result')->with([
            'users' => $users,
            'currentUser' => $currentUser,
            'fromCache' => $fromCache
        ]);
    }

    /**
     * @param $username
     * @param $users
     * @param $currentUser
     */
    protected function cacheData($username, $users, $currentUser)
    {
        Cache::put($username, json_encode([
            'users' => $users,
            'currentUser' => $currentUser
        ]), now()->addDay());
    }
}
