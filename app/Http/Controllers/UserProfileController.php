<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\User;
use App\Repositories\PostRepository;
use App\Repositories\UserRepository;
use Illuminate\Http\Request;
use Inertia\Inertia;

class UserProfileController extends Controller
{
    protected $userRepository;
    protected $postRepository;

    public function __construct(UserRepository $userRepository, PostRepository $postRepository)
    {
        $this->userRepository = $userRepository;
        $this->postRepository = $postRepository;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $posts = $this->postRepository->postsWithUserAndCommentsNoUserMedia();

        return Inertia::render('Dashboard', ['posts' => $posts]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
{
        $posts = $user->append('profilePicture')->posts()->with('media')->paginate(5);

        if (!$user) {
            return abort(404, 'User not found');
        }

        $pageData = [
            'pageTitle' =>  $user->name . "(@" . $user->username . ")",
            'postsCount' => $user->posts->count(),
            'followCount' => $user->following()->count(),
            'followersCount' => $user->followers()->count()
        ];

        return Inertia::render('Users/Show', ['user' => $user, 'posts' => $posts, 'pageData' => $pageData]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
