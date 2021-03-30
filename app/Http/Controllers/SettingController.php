<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Role;
use Exception;
use App\Http\Requests\UserRequests\UpdateUse;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Auth;
use Artisan;
use App;
use Config;

class SettingController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(){
        return kview('settings.general', [
            'form_action' => route('admin.settings.update'),
            'edit' => 1,
        ]);
    }
    public function edit_profile(){
        $user = Auth::user();
        $roles = Role::get();
        return kview('users.manage', [
            'form_action' => route('admin.users.update'),
            'edit' => 1,
            'data' => $user,
            'roles'=> $roles,
        ]);
    }
    public function update(Request $request){
        $update_array = [];
        if(isset($request->name)){
            $this->setEnvironmentValue('APP_NAME', 'app.name', $request->name);
        }
        if(isset($request->url)){
            $this->setEnvironmentValue('APP_URL', 'app.url', $request->url);
        }
        if(isset($request->theme)){
            $this->setEnvironmentValue('APP_THEME', 'app.theme', $request->theme);
        }
        
        return redirect()->back()->with('success','Settings has been updated');
    }
    private function setEnvironmentValue($environmentName, $configKey, $newValue) {
        $read = file_get_contents(App::environmentFilePath());
        
        $replaceFrom = $environmentName.'="'.config($configKey).'"';
        $replaceTo = $environmentName.'="'.$newValue.'"';
        $read = str_replace($replaceFrom,$replaceTo,$read);
        file_put_contents(App::environmentFilePath(),$read);
        // Reload the cached config       
        if (file_exists(App::getCachedConfigPath())) {
            Artisan::call("config:cache");
        }
    }
}