<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\RegisterRequest;
use App\Http\Resources\Backend\CountryResource;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Facades\App\Http\Repositories\PicRepository;
use Facades\App\Http\Repositories\CountryRepository;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Inertia\Inertia;
use Inertia\Response;
use App\Rules\Recaptcha;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): Response
    {
        cache()->flush();
        $getPic = PicRepository::all();

        $arrayRoles = [
            [
                "row" => 1,
                'label'=> 'Admin',
                'value' => 'admin',
            ],
            [
                "row" => 2,
                'label'=> 'Sales',
                'value' => 'sales',
            ],
            [
                "row" => 3,
                'label'=> 'Finance',
                'value' => 'finance',
            ],
            [
                "row" => 4,
                'label'=> 'NOC',
                'value' => 'noc',
            ],
            [
                "row" => 5,
                'label'=> 'Provisioning',
                'value' => 'provisioning',
            ]
        ];
        $country = CountryRepository::all();

        return Inertia::render('Auth/Register', [
            'roles' => $arrayRoles,
            'pics'=> $getPic,
            'countrys' => $country
        ]);
    }
    public function thank(): Response
    {

        return Inertia::render('Auth/Thankyou', [
            'title' => 'Thank you',
            'message'=> 'Thank you for registration on myTelin Portal.
            We will immediately follow up on your request.',
        ]);
    }


    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(RegisterRequest $request)
    {
        try{
        $user = User::create([
            'name' => $request->name,
            'last_name' => $request->last_name,
            'country' => $request->country,
            'phone' => $request->phone_code.$request->phone,
            'email' => $request->email,
            'pic_id' => $request->pic,
            'company' => $request->company,
            'roles' => json_encode($request->roles),
            'customer_role' => json_encode($request->roles),
            'status' => 0,
        ]);
        return Inertia::location(route('register.thank'));
        return redirect()->back();
        } catch (\Throwable $th) {
            
            return redirect()->back();
        }
    }
}
