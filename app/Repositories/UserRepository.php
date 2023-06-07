<?php

namespace App\Repositories;

use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;

class UserRepository
{
	protected $userId;

	public function __construct()
	{
		$this->userId = auth()->id();
	}

	/**
	 * Function should be an algorythm
	 * that simulates what intsagram does
	 * it's search feature first searches the user you follow, then i assume some nearby and then 
	 * total randoms from your area, for now it searches followers and then everyone else
	 * WHICH IS A TOTAL CATASTROPHE ON A MACRO SCALE
	 * 
	 * @param String $query
	 * @return Collection
	 * 
	 */

	public function returnUserFollowersWithoutAdmin(String $searchTerm): Collection
	{
		$followers = auth()->user()->followers();

		$followersResults = $this->applyFilters($followers->where('followers.user_id', '!=', $this->userId), $searchTerm);
		$otherUsersResults = $this->applyFilters(User::whereNotIn('users.id', $followers->pluck('user_id')), $searchTerm);

		return $followersResults->concat($otherUsersResults);
	}


	private function applyFilters($query, $searchTerm)
	{
		return $query->where('users.id', '!=', $this->userId)
			->doesntHave('roles', 'and', function ($query) {
				$query->where('name', 'admin');
			})
			->where(function ($queryBuilder) use ($searchTerm) {
				$queryBuilder->where('username', 'LIKE', '%' . $searchTerm . '%')
					->orWhere('name', 'LIKE', '%' . $searchTerm . '%');
			})
			->get();
	}
}
