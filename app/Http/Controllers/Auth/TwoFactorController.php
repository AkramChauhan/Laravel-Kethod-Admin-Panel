<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Notifications\TwoFactorCode;

class TwoFactorController extends Controller
{
    public function __construc(){
        $this->middleware(['auth','twofactor']);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return kview('auth.two_factor');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request) {
    $ecrypted_id = $request->encrypted_id;
    $id = Crypt::decryptString($ecrypted_id);
    $data = Table::where('id', '=', $id)->first();

    return kview($this->handle_name_plural . '.show', [
      'form_action' => route('admin.' . $this->handle_name_plural . '.update'),
      'edit' => 1,
      'data' => $data,
      'module_names' => [
        'singular' => $this->handle_name,
        'plural' => $this->handle_name_plural,
      ],
    ]);
  }
public function store(Request $request)
    {
        $request->validate([
            'two_factor_code'=>'integer|required',
        ]);
        $user = auth()->user();

        if($user->two_factor_expires_at->lt(now())){
            $user->resetTwoFactorCode();
            auth()->logout();
            return redirect()->route('login')->withMessage('The two factor code has expired. Please login again');
        }

        if($request->input('two_factor_code')==$user->two_factor_code){
            $user->resetTwoFactorCode();
            return redirect()->route('admin.dashboard');
        }
        return redirect()->back()->withErrors([
            'two_factor_code'=>'The two factor code you have entered does not match',
        ]);
    }
    
    public function resend(){
        $user = auth()->user();
        $user->generateTwoFactorCode();
        $user->notify(new TwoFactorCode());
        return redirect()->back()->withMessage('The verification code has been sent again.');
    }
}
