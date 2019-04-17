<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Services\UserService;
use App\User;
use Auth;
use Illuminate\Http\Request;
use Validator;

class UserController extends Controller
{
    //
    /**
     * @var UserService $userService
     */
    private $userService;
    public $successStatus = 200;

    /**
     * UserController constructor.
     * Initialize all class instances.
     *
     * @param UserService $userService
     */
    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    /**
     * Method to show users list.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function index()
    {

        $user = User::paginate(10);
        return response()->json(['success' => $user], $this->successStatus);
    }
    // try {
    //     $table = $this->userService->getAllUsers();
    //     // dd($table);
    // } catch (\ErrorException $exception) {
    //     return redirect('/users')->with('errorMessage',
    //         __('frontendMessages.EXCEPTION_MESSAGES.SHOW_USERS_LIST'));
    // }

    // return view('admin.users.usersList', ['table' => $table]);

    public function filter(Request $request)
    {
        // if ($request->has('username')) {
        //     return $user->where('username', $request->input('username'))->get();
        //  }
        //  if ($request->has('email')) {
        //     return $user->where('email', $request->input('email'))->get();
        // }
        // if ($request->has('first_name')) {
        //     return $user->where('first_name', $request->input('first_name'))->get();
        // }
        // return User::all();
        // if ($title = $filters->get('username')) {
        //     $query->where('users.username', 'like', "{$title}%");
        // }
        // Search for a user based on their name.

        // if ($authors = $filters->get('authors')) {
        //     $query->whereIn('posts.user_id', $authors);
        // }
        
        $data = $request->get('data');
        
        $search_users = User::where('username', 'like', "%{$data}%")
                            ->orWhere('first_name', 'like', "%{$data}%")
                            ->orWhere('last_name', 'like', "%{$data}%")
                            ->get();
    
                            return response()->json(['data' => $search_users]);
    }

    // public function sort(Request $request)
    // {
    //      User::orderBy()
    // }
    public function sortUser(Request $request,User $user)
            {
           
            $data = $request->get('data');
            $sortColumn = $request->get('sortColumn');
            $sort = $request->get('sort');
            
               
                $sort_users =  User::orderBy($sortColumn,$sort)    
                 ->get();
                 return $sort_users;
                 return response()->json(['data'=>$ $user]);
                
            }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.users.user');
    }

    /**
     * Store a newly created user in the database.
     *
     * @param  CreateUserRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateUserRequest $request)
    {
        // dd($request);
        $validator = Validator::make($request->all(), [
            // 'id'=>'required',
            'first_name' => 'required',
            'last_name' => 'required',
            'username' => 'required',
            'email' => 'required|email',
            'password' => 'required',
            'password_confirmation' => 'required|same:password',
            'address' => 'required',
            'house_number' => 'required',
            'postal_code' => 'required',
            'city' => 'required',
            'telephone_number' => 'required',

        ]);
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 401);
        }
        $input = $request->all();
        $input['password'] = bcrypt($input['password']);
        $user = User::create($input);
        $success['token'] = $user->createToken('MyApp')->accessToken;
        $success['username'] = $user->username;
        return response()->json(['success' => $success], $this->successStatus);

        // $result = $this->userService->createUser($request);

        // if (!$result) {
        //     return redirect('/users')->with('errorMessage',
        //         __('frontendMessages.EXCEPTION_MESSAGES.CREATE_USER_MESSAGE'));
        // }

        // return redirect('/users')->with('successMessage', __('frontendMessages.SUCCESS_MESSAGES.USER_CREATED'));
    }

    /**
     * Method to show a particular user.
     *
     * @param $id
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        // dd($id);
        $user = $this->userService->getUser($id);
        if ($user == null) {
            return redirect('/users')->with('errorMessage',
                __('frontendMessages.EXCEPTION_MESSAGES.FIND_USER_MESSAGE'));
        }

        return view('admin.users.user', ['user' => $user]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  UpdateUserRequest $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateUserRequest $request, $id)
    {
        // dd($id);
        $result = $this->userService->updateUser($request, $id);
        if ($result == null) {
            return redirect('/users/edit')->with('errorMessage',
                config('frontendMessages.EXCEPTION_MESSAGES.UPDATE_USER_MESSAGE'));
        }

        return redirect('/users')->with('successMessage', __('frontendMessages.SUCCESS_MESSAGES.USER_UPDATED'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $result = $this->userService->deleteUser($id);

        if (!$result) {
            return redirect('/users')->with('errorMessage',
                __('frontendMessages.EXCEPTION_MESSAGES.DELETE_USER_MESSAGE'));
        }

        return redirect('/users')->with('successMessage', __('frontendMessages.SUCCESS_MESSAGES.USER_DELETED'));
    }

    public function logout(Request $request)
    {
        $request->user()->token()->revoke();
        return response()->json([
            'message' => 'Successfully logged out',
        ]);
    }

    public function login(Request $request)
    {
        // $this->validateLogin($request);
        if (Auth::attempt(['email' => request('email'), 'password' => request('password')])) {
            $user = Auth::user();
            $success['token'] = $user->createToken('MyApp')->accessToken;
            return response()->json(['success' => $success], $this->successStatus);
        } else {
            return response()->json(['error' => 'Unauthorised'], 401);
        }
    }

}
