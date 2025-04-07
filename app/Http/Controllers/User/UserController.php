<?php

namespace App\Http\Controllers\User;

use Carbon\Carbon;
use App\Models\User;
use Illuminate\View\View;
use App\Helpers\RouterLink;
use App\Models\Log\LogModel;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Officer\OfficerModel;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Crypt;
use App\Http\Requests\User\UserFormRequest;

class UserController extends Controller
{
    protected $route;
    protected $carbon;

    public function __construct()
    {
        $this->route = RouterLink::string(Auth::user()->role);

        $this->carbon = new Carbon();
        $this->carbon->setTimezone(env('APP_TIMEZONE'));
    }
    public function index()
    {
        $breadCumbs = [
            ['title' => 'Dashboard', 'link' => route($this->route), 'page' => ''],
            ['title' => 'Users', 'link' => route('users.index'), 'page' => 'aria-current="page"']
        ];

        $data = [
            'title' => 'Users Manage' . env('APP_NAME'),
            'pageTitle' => 'Users Manage',
            'breadCumbs' => $breadCumbs,
            'users' => User::orderBy('created_at', 'desc')->get()
        ];

        return view('user.users', $data);
    }

    public function form(Request $request): RedirectResponse|View
    {
        // default breadcumbs
        $breadCumbs = [
            ['title' => 'Dashboard', 'link' => route($this->route), 'page' => ''],
            ['title' => 'Users', 'link' => route('users.index'), 'page' => '']
        ];

        // Checking parameters incoming
        if ($request->param == 'add') {
            $breadCumbs[] = ['title' => 'Add User', 'link' => route('users.form', ['param' => 'add', 'id' => Crypt::encrypt('null')]), 'page' => 'aria-current="page"'];
            $pageTitle = 'Add User';
            $user = null;
            $paramForm = Crypt::encrypt('save');
            $officers = OfficerModel::orderBy('created_at', 'desc')->get();
        } elseif ($request->param == 'edit') {
            $breadCumbs[] = ['title' => 'Edit User', 'link' => route('users.form', ['param' => 'edit', 'id' => $request->id]), 'page' => 'aria-current="page"'];
            $pageTitle = 'Edit User';
            $user = User::findOrFail(Crypt::decrypt($request->id));
            $paramForm = Crypt::encrypt('update');
            $officers = OfficerModel::where('block', 'N')->orderBy('created_at', 'desc')->get();
        } else {
            return redirect()->route('users.index')->with('error', 'Invalid Request');
        }

        $data = [
            'title' => $pageTitle . ' ' . env('APP_NAME'),
            'pageTitle' => $pageTitle,
            'breadCumbs' => $breadCumbs,
            'user' => $user,
            'paramForm' => $paramForm,
            'officers' => $officers,
        ];

        // Redirect to form user
        return view('user.form-user', $data);
    }

    public function store(UserFormRequest $request): RedirectResponse
    {
        // General validation request
        $request->validated();
        $paramForm = Crypt::decrypt($request->input('paramForm'));
        $save = null;

        // Search officer on database
        $searchOfficer = OfficerModel::findOrFail(htmlspecialchars($request->input('officer')));
        if (!$searchOfficer) {
            return redirect()->route('users.index')->with('error', 'Officer not found')->withInput();
        }

        $formData = [
            'name' => $searchOfficer->name,
            'email' => htmlspecialchars($request->input('email')),
        ];

        if ($paramForm == 'save') {
            // Check if the user is existing
            $searchUser = User::where('officer_id', htmlspecialchars($request->input('officer')))->first();
            if ($searchUser) {
                return redirect()->route('users.index')->with('error', 'User already exists !')->withInput();
            }
            // Required password validation
            $request->validate(
                [
                    'email' => 'unique:users',
                    'password' => 'required'
                ],
                [
                    'email.unique' => 'Email already exists',
                    'password.confirmed' => 'Password is required'
                ]
            );
            $formData = array_merge($formData, [
                'password' => htmlspecialchars($request->input('password')),
                'officer_id' => htmlspecialchars($request->input('officer')),
                'role' => htmlspecialchars($request->input('role')),
                'block' => htmlspecialchars($request->input('block')),
            ]);
            $save = User::create($formData);
            $error = 'User failed to save !';
            $success = 'User saved successfully !';
            $activity = Auth::user()->name . ' created a new user with name ' . $formData['name'] . ' at ' . $this->carbon->now();
        } elseif ($paramForm == 'update') {
            $searchUser = User::findOrFail(Crypt::decrypt(htmlspecialchars($request->input('id'))));
            if ($searchUser) {
                $password = htmlspecialchars($request->input('password'));
                if ($password) {
                    $formData['password'] = $password;
                }
                $formData = array_merge($formData, [
                    'officer_id' => htmlspecialchars($request->input('officer')),
                    'role' => htmlspecialchars($request->input('role')),
                    'block' => htmlspecialchars($request->input('block')),
                ]);
                $save = $searchUser->update($formData);
                $error = 'User failed to update !';
                $success = 'User updated successfully !';
                $activity = Auth::user()->name . ' updated user with name ' . $formData['name'] . ' at ' . $this->carbon->now();
            } else {
                return redirect()->route('users.index')->with('error', 'User not found');
            }
        } else {
            return redirect()->route('users.index')->with('error', 'Invalid Request')->withInput();
        }

        // Check if the save was successful
        if (!$save) {
            return redirect()->route('users.index')->with('error', $error)->withInput();
        }

        // Log the activity in the system
        LogModel::create([
            'user_id' => Auth::user()->id,
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
            'activity' => $activity,
        ]);

        // Redirect to the index page with success message
        return redirect()->route('users.index')->with('success', $success);

    }

    public function destroy(Request $request): RedirectResponse
    {
        $searchUser = User::findOrFail(Crypt::decrypt($request->id));
        if ($searchUser) {
            // Log the activity in the system
            LogModel::create([
                'user_id' => Auth::user()->id,
                'ip_address' => request()->ip(),
                'user_agent' => request()->userAgent(),
                'activity' => Auth::user()->name . ' Deleted user ' . $searchUser->name . ' at ' . $this->carbon->now()
            ]);
            $searchUser->delete();
            return redirect()->route('users.index')->with('success', 'User deleted successfully');
        } else {
            return redirect()->route('users.index')->with('error', 'User not found');
        }
    }

}
