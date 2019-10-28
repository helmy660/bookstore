<?php

namespace App\Http\Controllers;

use App\User;
use App\Book;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Validator;
use Charts;

class UserController extends Controller
{   
     /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        $this->middleware('auth');

        $this->middleware('checkroll')->only(['admin_home','index','create','store','edit','update','destroy']);
    }
    
     public function show()
    {
        return view('user', ['user' => Auth::user()] );
    }

    public function index()
    {
        $users = User::all();
        return view('admin.users', compact('users'));
    }

      /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.users.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => ['required'],
            'email' => [
                'required',
                Rule::unique('users','email')
            ],
            'username' => [
                'required',
                Rule::unique('users','email')
            ],
            'nationalid' => [
                'required',
                Rule::unique('users','nationalid')
            ],
            'phone'=>'required',
            'password'=>'required',
            'user_image'=>'required',

        ]);

        if ($validator->fails()) {
            return redirect('users/create')
                        ->withErrors($validator)
                        ->withInput();
        }
        
        $user = new User([
            'name' =>  $request->get('name'),
            'username' => $request->get('username'),
            'email' => $request->get('email'),
            'nationalid' => $request->get('nationalid'),
            'phone' => $request->get('phone'),
            'user_image' => $request->get('user_image'),
            'password' => Hash::make($request->get('password')),
        ]);
        $user->save();
        return redirect('users')->with('success', 'User saved successfully!');
    }

    public function edit(User $user)
    {
        return view('admin.users.edit',compact('user',$user));
    }

    public function update(Request $request, User $user)
    {
        $validator = Validator::make($request->all(), [
            'name' => ['required'],
            'email' => [
                'required',
                Rule::unique('users','email')->ignore($user->id)
            ],
            'username' => [
                'required',
                Rule::unique('users','email')->ignore($user->id)
            ],
            'nationalid' => [
                'required',
                Rule::unique('users','nationalid')->ignore($user->id)
            ],
            'phone'=>'required',
            'isactive' => 'required'
        ]);

        if ($validator->fails()) {
            return redirect('users/'. $user->id .'/edit')
                        ->withErrors($validator)
                        ->withInput();
        }

        if($request->get('password') !== ''){
            $user->password = Hash::make($request->get('password'));
        }

        $user->name =  $request->get('name');
        $user->username = $request->get('username');
        $user->email = $request->get('email');
        $user->nationalid = $request->get('nationalid');
        $user->phone = $request->get('phone');
        $user->isactive = $request->get('isactive');
        $user->save();
        return redirect('/users')->with('success', 'User updated!');
    }


    public function updateProfile(Request $request, User $user)
    {
        $validator = Validator::make($request->all(), [
            'name' => ['required'],
            'email' => [
                'required',
                Rule::unique('users','email')->ignore($user->id)
            ],
            'username' => [
                'required',
                Rule::unique('users','username')->ignore($user->id)
            ],
            'nationalid' => [
                'required',
                Rule::unique('users','nationalid')->ignore($user->id)
            ],
            'phone'=>'required',
        ]);

        if ($validator->fails()) {
            return redirect('/home')->withErrors($validator)->withInput();
        }

        $user->name =  $request->get('name');
        $user->username = $request->get('username');
        $user->email = $request->get('email');
        $user->nationalid = $request->get('nationalid');
        $user->phone = $request->get('phone');

        // if(!empty($request->get('password'))){
        //     $user->password = Hash::make($request->get('password'));
        // }

        if ($request->hasFile('user_image')) {
            if($request->file('user_image')->isValid()) {
                try {                    
                    $image = 'data:image/' . $request->file('user_image')->getClientOriginalExtension()  . ';base64,' . base64_encode(file_get_contents($request->file('user_image')));                   
                    $user->user_image = $image;
                } 
                catch (FileNotFoundException $e) {
                    return redirect('/home')->withErrors('Book Image not saved')->withInput();
                }
            }
            else{  
                return redirect('/home')->withErrors('Image not valid')->withInput();
            }
        }
        $user->save();
        return redirect('/home')->with('success', 'User updated!');
    }

    public function destroy(User $user) {
        $user->delete();
        return redirect('users')->with('success', 'User deleted!');
    }

    public function admin_home(User $admin){
    
        $books = DB::table('books')
            ->join('user_books', 'books.id', '=', 'user_books.book_id')
            ->select(DB::raw('extract(week from user_books.created_at) as week'), DB::raw('sum(user_books.number_of_days * books.price) as total_amount'))
            ->where('user_books.leased', 1)
            ->groupBy('week')->get();
        
        $values=[];
        $labels=[];
        foreach ($books as $key => $value) {
            $labels[$key]= 'Week '.$books[$key]->week;
            $values[$key]= $books[$key]->total_amount;
        }

        $chart = Charts::create('bar', 'highcharts')

        ->title("Weekly Profit")

        ->elementLabel("Total Amount")
        ->labels($labels)
        ->values($values)
        ->dimensions(800, 500)
        ->responsive(true);     
        return view('admin.index', compact('admin', $admin, 'chart', $chart));
    }

    public function showChangePasswordForm(){
        return view('auth.changepassword');
    }

    public function changePassword(Request $request){
        if (!(Hash::check($request->get('current-password'), Auth::user()->password))) {
            // The passwords matches
            return redirect('/home/changePassword')->with("error","Your current password does not matches with the password you provided. Please try again.");
        }
        if(strcmp($request->get('current-password'), $request->get('new-password')) == 0){
            //Current password and new password are same
            return redirect('/home/changePassword')->with("error","New Password cannot be same as your current password. Please choose a different password.");
        }

        $validatedData = $request->validate([
            'current-password' => 'required',
            'new-password' => 'required|string|min:6|confirmed',
        ]);
        //Change Password
        $user = Auth::user();
        $user->password = bcrypt($request->get('new-password'));
        $user->save();
        return redirect('/home/changePassword')->with("success","Password changed successfully !");
    }
}
