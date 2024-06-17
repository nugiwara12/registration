<?php


namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Mail;
use App\Mail\RegistrationSuccessEmail;

class RegisterController extends Controller
{
    public function showRegistrationForm()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $this->validator($request->all())->validate();

        $user = $this->create($request->all());

        // Send registration success email
        Mail::to($user->email)->send(new RegistrationSuccessEmail($user));

        // Redirect to home page with the user's name
        return redirect('/')->with('name', $user->name);
    }

    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255'],
            'telephone' => ['required', 'numeric', 'min:11'],
            'add1' => ['required', 'string', 'max:255'],
            'add2' => ['required', 'string', 'max:255'],
            'city' => ['required', 'string', 'max:255'],
            'state' => ['required', 'string', 'max:255'],
            'zip' => ['required', 'numeric'],
            'user' => ['required', 'string', 'max:255'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
    }

    protected function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'telephone' => $data['telephone'],
            'add1' => $data['add1'],
            'add2' => $data['add2'],
            'city' => $data['city'],
            'state' => $data['state'],
            'zip' => $data['zip'],
            'username' => $data['user'],
            'password' => Hash::make($data['password']),
        ]);
    }
}