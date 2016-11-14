<?php

namespace App\Repositories;



use Log;
use App\Models\staff, App\Models\Role , App\Models\user;
use GuzzleHttp\Client;

class StaffRepository extends BaseRepository
{


	/**
	*The client instance external API 
	*
	*/
	protected $clientAPI;
	protected $responsJson;

	/**
	 * The Role instance.
	 *
	 * @var App\Models\Role
	 */	
	protected $role;

	/**
	 * The Role instance.
	 *
	 * @var App\Models\Role
	 */	
	protected $staff;

	/**
	 * Create a new UserRepository instance.
	 *
   	 * @param  App\Models\User $user
	 * @param  App\Models\Role $role
	 * @return void
	 */
	public function __construct(
		User $user, 
		Role $role, Staff $staff)
	{
		
		$this->clientAPI = new Client();
		$this->model = $user;
		$this->role = $role;
		$this->staff = $staff;
	}



	/**
	 * Save the User.
	 *
	 * @param  App\Models\User $user
	 * @param  Array  $inputs
	 * @return void
	 */
  	private function save($staff, $inputs)
	{		
		if(isset($inputs['seen'])) 
		{
			$staff->valid = $inputs['seen'] == 'true';		
		} else {
			$staff->staff_last_name = $inputs['staff_last_name'];
			$staff->staff_first_name = $inputs['staff_first_name'];
			$staff->staff_first_email = $inputs['staff_first_email'];
			$staff->contract_number = $inputs['contract_number'];

		}

		$staff->save();
	}

	/**
	 * Get users collection paginate.
	 *
	 * @param  int  $n
	 * @param  string  $role
	 * @return Illuminate\Support\Collection
	 */
	public function index($n, $role)
	{
		if($role != 'total')
		{
			return $this->model
			->with('role')
			->whereHas('role', function($q) use($role) {
				$q->whereSlug($role);
			})		
			->oldest('seen')
			->latest()
			->paginate($n);			
		}

		

		return $this->model
		->with('role')		
		->oldest('seen')
		->latest()
		->paginate($n);
	}

	/**
	 * Count the staff by .
	 *
	 * @param  string  $role
	 * @return int
	 */
	public function count($role = null)
	{

		
		if($role)
		{
			$responsJson = $this->clientAPI->request('GET', 'https://kraken-api.tpch.fr/employerByJob', 
			['json' => ['email' => $request->input('log'),
						'password' =>$request->input('password')]]
			);


			return $this->model
			->whereHas('role', function($q) use($role) {
				$q->whereSlug($role);
			})->count();
		}

		return $this->model->count();
	}

	/**
	 * Count the users.
	 *
	 * @param  string  $role
	 * @return int
	 */
	public function counts()
	{

		$res = $this->clientAPI->request('GET', 'https://kraken-api.tpch.fr/job');
		$count = json_decode($res->getBody(), true);

		/*$counts = [
			'admin' => $this->count('admin'),
			'redac' => $this->count('redac'),
			'user' => $this->count('user'),
			'staff' =>$this->count('staff'),
			'employer' =>$this->count('employer'),
		];*/

		for ($i=0; $i < $counts.sizeof() ; $i++) { 
		 	$counts[i] = count[i] => $this->count(count[i]);
		 } 

		$counts['total'] = array_sum($counts);

	
		return $counts;
	}

	public function allStaff2(){

		Log::info($this->staff->all());
		return $this->staff->all();
	}

	public function allStaff(){
		   
		$res = $this->clientAPI->get("https://kraken-api.tpch.fr/staffer");
		$responsJson = json_decode($res->getBody(), true);

		return $responsJson;
	}

	/**
	 * Create a user.
	 *
	 * @param  array  $inputs
	 * @param  int    $confirmation_code
	 * @return App\Models\User 
	 */
	public function store($inputs, $confirmation_code = null)
	{


		
		$staff = new $this->staff;

		//$staff->password = bcrypt($inputs['password']);

		/*if($confirmation_code) {
			$user->confirmation_code = $confirmation_code;
		} else {
			$user->confirmed = true;
		}*/

		$this->save($staff, $inputs);

		return $staff;
	}

	/**
	 * Update a user.
	 *
	 * @param  array  $inputs
	 * @param  App\Models\User $user
	 * @return void
	 */
	public function update($inputs, $staff)
	{
		//$staff->confirmed = isset($inputs['confirmed']);

		$this->save($staff, $inputs);
	}

	/**
	 * Get statut of authenticated user.
	 *
	 * @return string
	 */
	public function getStatut()
	{
		return session('statut');
	}

	/**
	 * Valid user.
	 *
     * @param  bool  $valid
     * @param  int   $id
	 * @return void
	 */
	public function valid($valid, $id)
	{
		$user = $this->getById($id);

		$user->valid = $valid == 'true';

		$user->save();
	}

	/**
	 * Destroy a user.
	 *
	 * @param  App\Models\User $user
	 * @return void
	 */
    public function destroyStaff(Staff $staff)
    {
        /*$user->comments()->delete();

        $posts = $user->posts()->get();

        foreach ($posts as $post) {
            $post->tags()->detach();
            $post->delete();
        }*/
        
        $staff->delete();
    }

	/**
	 * Confirm a user.
	 *
	 * @param  string  $confirmation_code
	 * @return App\Models\User
	 */
	public function confirm($confirmation_code)
	{
		/*$user = $this->model->whereConfirmationCode($confirmation_code)->firstOrFail();

		$user->confirmed = true;
		$user->confirmation_code = null;
		$user->save();*/
	}

}
