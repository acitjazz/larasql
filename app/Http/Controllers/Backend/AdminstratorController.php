<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\Administrator\AdministratorRequest;
use App\Http\Requests\Administrator\AdministratorUpdatePasswordRequest;
use App\Http\Resources\Backend\AdministratorResource;
use App\Models\Admin;
use App\Models\AdminPassword;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Facades\App\Http\Repositories\AdministratorRepository;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Hash;
use Inertia\Inertia;

class AdminstratorController extends Controller
{
    //
    public function index()
    {
        if(request('trash')==1){
            $adminstrators = AdministratorRepository::paginateTrash(20);
        }else{
            $adminstrators = AdministratorRepository::paginate(20);
        }
        return Inertia::render('Views/administrator/index', [
            'administrators' => AdministratorResource::collection($adminstrators),
           'title' => request('trash') ? 'Trash' : 'Adminstrators ',
           'count_trash' =>  AdministratorRepository::countTrash(),
            'trash' => request('trash') ? true : false,
            'breadcumb' => [
                [
                    'text' => 'Dashboard',
                    'url' => '/backend'
                ],
                [
                    'text' => 'Administrators',
                    'url' => '/backend/administrator'
                ],
            ],
        ]);
    }
    /**
     * Display the user's profile form.
     */
    public function create(Request $request)
    {
        $adminstrators = [
            'name'=>'',
            'bod'=>'',
            'email'=>'',
            'password'=>'',
            'repassword' =>'',
        ];
        return Inertia::render('Views/backend/administrator/form', [
            'status' => session('status'),
            'administrators' =>  $adminstrators,
            'method' => 'store'
        ]);
    }
     /**
     * Display the user's profile form.
     */
    public function store(AdministratorRequest $request)
    {
        try{
            $post = $request->post();

            $banners = [
                'name' => $post['name'],
                'bod' => $post['bod'],
                'email' => $post['email'],
                'password' => Hash::make($post['password']),
            ];
            $admin = Admin::create( $banners );
            $admin->adminPassword()->create(['password'=> Hash::make($post['password'])]);

            Cache::tags('administrator')->flush();
            return redirect('backend/administrator')->with('message', 'proses menambah  administrator berhasil');
        } catch (\Throwable $th) {
             dd( $th);
            return redirect('backend/administrator')->with('message', 'mohon maaf proses menambah  administrator gagal');
        }
    }


        /**
  * Display the user's profile form.
  */
 public function changePassword(Request $request)
 {


     $administrator = Admin::find(auth()->guard('admin')->user()->id);
     $start = Carbon::now()->subMinutes(env('PASSWORD_EXPIRED',60*24*30*3));
     $lastPass =  AdminPassword::where('admin_id',$administrator->id)->latest('created_at')->first();
     $message = '';
     if(!is_null($lastPass)){
        if($lastPass->created_at < $start){
               $message = 'Your password has not been changed for 3 months, please change your password to be able to use the My Telin dashboard';
        }
     }
     $administrator = [
        'id'=> $administrator->id,
        'name' => $administrator->name,
        'email' => $administrator->email,
        'bod' => $administrator->bod,
        'old_password' => '',
        'password' => '',
        'repassword' => '',
     ];
     return Inertia::render('Views/administrator/changePassword', [
        'title' => 'Change Password ',
         'status' => session('status'),
          'method' => 'update',
         'administrators' =>  $administrator,
         'message' => $message,
         'breadcumb' => [
             [
                 'text' => 'Dashboard',
                 'url' => '/backend'
             ],
             [
                 'text' => 'Administrators',
                 'url' => '/backend/administrator'
             ],
             [
                 'text' => 'Edit - '.$administrator['name'] ,
                 'url' => ''
             ],
         ],
     ]);
 }

 public function updatePassword(AdministratorUpdatePasswordRequest $request)
 {

    $administrator = Admin::find($request->id);

     $administrator->password = Hash::make($request->password);
     $administrator->update();
     $administrator->adminPassword()->create(['password'=> Hash::make($request->password)]);
    Cache::tags('administrator')->flush();
    return redirect('backend/administrator')->with('message', 'proses update  administrator berhasil');
 }


 public function edit(Request $request, Admin  $administrator)
 {


     $administrator = $administrator;
     $dataAdminstrators = [
        'id'=> $administrator->id,
        'name'=> $administrator->name,
        'bod'=> $administrator->bod,
        'email'=> $administrator->email,
        'password'=>'',
        'repassword' =>'',
    ];

     return Inertia::render('Views/backend/administrator/form', [
         'status' => session('status'),
          'method' => 'update',
         'administrators' =>  $dataAdminstrators,
         'breadcumb' => [
             [
                 'text' => 'Dashboard',
                 'url' => '/backend'
             ],
             [
                 'text' => 'Administrators',
                 'url' => '/backend/administrator'
             ],
             [
                 'text' => 'Edit - '.$administrator->name ,
                 'url' => ''
             ],
         ],
     ]);
 }
     /**
     * Display the user's profile form.
     */
    public function update(AdministratorRequest $request)
    {
        try{
            $post = $request->all();

            $administrator = Admin::where(
                'id',
                $post['id']
            )->first();
            // dd($administrator->name);
            $administrator->name = $post['name'];
            $administrator->bod = $post['bod'];
            $administrator->email = $post['email'];
            if($post['password']!=''){
                $administrator->password = Hash::make($post['password']);
            }

             $administrator->save();
             $administrator->adminPassword()->create(['password'=> Hash::make($post['password'])]);
            Cache::tags('administrator')->flush();
            return redirect('backend/administrator')->with('message', 'proses update  administrator berhasil');
        } catch (\Throwable $th) {
            dd($th);
            return redirect('backend/administrator')->with('message', 'mohon maaf sedang ada gangguan silahkan coba bebrapa saat lagi');
        }
    }

    /**
    * Remove the specified resource from storage temporary.
    */
    public function delete($administrator)
    {
        $administrator = Admin::find($administrator);
        $administrator->delete();

        Cache::tags(['administrator'])->flush();
        return redirect()->back()->with('message', toTitle($administrator->name . ' hase been deleted'));
    }

    /**
     * Remove data permanently
     */
    public function destroy($administrator)
    {
        $administrator = Admin::withTrashed()->find($administrator);
        $administrator->forceDelete();

        Cache::tags(['administrator'])->flush();
        return redirect()->back()->with('message', toTitle($administrator->name. ' hase been destroyed'));
    }

    public function destroyAll()
    {
       $ids = explode(',',request('selected'));
       $administrators = Admin::whereIn('id',$ids)->withTrashed()->get();
       foreach ($administrators as $administrator) {
          $administrator->forceDelete();
       }
       Cache::tags(['administrator'])->flush();
       return redirect()->back()->with('message', toTitle($administrator->name) . ' has been destroyed');
    }

    /**
     * Restore Data from trash
     */
    public function restore($administrator)
    {
       $administrator = Admin::withTrashed()->find($administrator);
       $administrator->restore();
       Cache::tags(['administrator'])->flush();
       return redirect()->back()->with('message', toTitle($administrator->name) . ' has been restored');
    }
}
