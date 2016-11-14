<?php namespace App\Http\Controllers;

use App\Repositories\UserRepository;
use App\Repositories\RoleRepository;
use App\Http\Requests\UserCreateRequest;
use App\Http\Requests\UserUpdateRequest;
use App\Http\Requests\RoleRequest;
use App\Http\Requests\StaffUpdateRequest;
use App\Http\Requests\StaffCreateRequest;
use App\Models\User;
use App\Models\Staff;
use Illuminate\Http\Request;
use Intervention\Image\ImageManager;
use GuzzleHttp\Client;
use Log;
use Illuminate\Pagination\Paginator;




class StaffControler extends Controller {

	/**
	 * The UserRepository instance.
	 *
	 * @var App\Repositories\UserRepository
	 */
	protected $user_gestion;

	/**
	 * The RoleRepository instance.
	 *
	 * @var App\Repositories\RoleRepository
	 */	
	protected $role_gestion;


	/**
	 * The RoleRepository instance.
	 *
	 * @var App\Repositories\StaffGestion
	 */	
	protected $staff_gestion;



	protected $jsonStaff;

	protected $jsonJob;

	protected $totalStaffer;

	protected $listStaffByJob;


	/**
	 * Create a new UserController instance.
	 *
	 * @param  App\Repositories\UserRepository $user_gestion
	 * @param  App\Repositories\RoleRepository $role_gestion
	 * @return void
	 */
	public function __construct(
		UserRepository $user_gestion,
		RoleRepository $role_gestion)
	{
		$this->user_gestion = $user_gestion;
		$this->role_gestion = $role_gestion;
		//$this->staff_gestion = $staff_repository;

		$this->middleware('admin');
		$this->middleware('ajax', ['only' => 'updateValidedaze']);
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{

		$client = new Client();
		
		$responsJson = $client->request('GET', 'https://kraken-api.tpch.fr/staffer', 
			['auth' => [session('user'), session('password')]
		]);

		$this->JsonStaff = json_decode($responsJson->getBody(), true);

		$responsJson = $client->request('GET', 'https://kraken-api.tpch.fr/job', 
			['auth' => [session('user'), session('password')]
		]);

		$this->JsonJob = json_decode($responsJson->getBody(), true);

		foreach($this->JsonJob as $key => $job){
			$this->JsonJob[$key]['skills'] = 0;
		}
	
		$this->totalStaffer=0;
		foreach($this->JsonStaff as $staff){
			foreach ($staff['jobs'] as $jobStaffer) {
				foreach($this->JsonJob as $key => $job){
					if($jobStaffer['name'] == $job['name']){
						$this->JsonJob[$key]['skills'] ++;
					}
					$this->totalStaffer++;
				}
			}
		} 

		Log::info($this->JsonJob);
		
 		
		return $this->indexSort('total');
	}

	/**
	 * Display a listing of the resource.
	 *
     * @param  string  $role
	 * @return Response
	 */
	public function indexSort($job)
	{

		if($job == "total"){

		}else if ($job == "") {

		}

		$counts = $this->user_gestion->counts();
		$users = $this->user_gestion->index(2, $job);
		$links = $users->render();
		$roles = $this->role_gestion->all();
		
		//$staffs = $this->JsonStaff->paginate(15);
		$staffs = new Paginator($this->JsonStaff, 4);
		$jobs = $this->JsonJob;
		$totalStafferView = $this->totalStaffer;
	
		//Log::info($totalStafferView);
		//Log::info($jobs);

		$img = "apple-touch-icon-precomposed.png";

		return view('back.staff.index', compact('links','img','jobs','staffs','totalStafferView'));		
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		//return view('back.staff.create', $this->role_gestion->getAllSelect());
		return view('back.staff.create');
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  App\requests\UserCreateRequest $request
	 *
	 * @return Response
	 */
	public function store(
		StaffCreateRequest $request)
	{

		//$this->staff_gestion->store($request->all());

		return redirect('staff')->with('ok', "Nouveau staff créé");
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  App\Models\User
	 * @return Response
	 */
	public function show(Staff $staff)
	{
		
		return view('back.staff.show',  compact('staff',$this->user_gestion->getById($staff->id_users)));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  App\Models\User
	 * @return Response
	 */
	public function edit(Staff $staff)
	{
		return view('back.staff.edit', array_merge(compact('staff'), $this->role_gestion->getAllSelect()));
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  App\requests\UserUpdateRequest $request
	 * @param  App\Models\User
	 * @return Response
	 */
	public function update(
		StaffUpdateRequest $request,
		Staff $staff)
	{
		$this->staff_gestion->update($request->all(), $staff);

		return redirect('staff')->with('ok', "Staff modifié");
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  Illuminate\Http\Request $request
	 * @param  App\Models\User $user
	 * @return Response
	 */
	public function updateValided(
		Request $request, 
		Staff $staff)
	{
		info($request->all());
		$this->staff_gestion->update($request->all(), $staff);

		return null;
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  App\Models\user $user
	 * @return Response
	 */
	public function destroy(Staff $staff)
	{
		$this->staff_gestion->destroyStaff($staff);

		return redirect('staff')->with('ok',"Le staff a correctement été supprimé ce fdp");
	}

	/**
	 * Display the roles form
	 *
	 * @return Response
	 */
	public function getRoles()
	{
		$roles = $this->role_gestion->all();

		return view('back.users.roles', compact('roles'));
	}

	/**
	 * Update roles
	 *
	 * @param  App\requests\RoleRequest $request
	 * @return Response
	 */
	public function postRoles(RoleRequest $request)
	{
		$this->role_gestion->update($request->except('_token'));
		
		return redirect('user/roles')->with('ok', trans('back/roles.ok'));
	}

}
