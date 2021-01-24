<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequests\AddUserRequest as AddRequest;
use App\Http\Requests\UserRequests\UpdateUserRequest as UpdateRequest;
use App\Models\User;
use App\Models\Role;
use App\Models\RoleUser;
use Exception;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class UserController extends Controller
{
    protected $handle_name = "user";
    protected $handle_name_plural = "users";
   
    public function index()
    {
        return kview($this->handle_name_plural.'.index', [
            'ajax_route' => route('admin.'.$this->handle_name_plural.'.ajax'),
            'delete_route'=> route('admin.'.$this->handle_name_plural.'.delete'),
            'create_route' => route('admin.'.$this->handle_name_plural.'.create'),
        ]);
    }

    public function create()
    {
        $roles = Role::get();
        return kview($this->handle_name_plural.'.manage', [
            'form_action' => route('admin.'.$this->handle_name_plural.'.store'),
            'edit' => 0,
            'roles' => $roles
        ]);
    }

    public function edit(Request $request)
    {
        $roles = Role::get();

        return kview($this->handle_name_plural.'.manage', [
            'form_action' => route('admin.'.$this->handle_name_plural.'.update'),
            'edit' => 1,
            'roles' => $roles,
            'data' => User::where('id', '=', $request->id)->with('roles')->first()
        ]);
    }

    public function store(AddRequest $request)
    {
        try {
            $request->request->add([
                'password' => bcrypt($request->password)
            ]);
            $user = User::createRecord($request->all());
            $user_id = ($user->id);
            // dd($request->role);
            if(isset($request->role) && $request->role!=0){
                $role_id = $request->role;

                $data=  RoleUser::updateOrCreate([
                    'user_id'=>$user_id,
                    'role_id'=>$role_id,
                ]);
            }
            return redirect()->to(route('admin.'.$this->handle_name_plural.'.index'))->with('success', 'New '.ucfirst($this->handle_name).' has been added.');
        } catch (Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function update(UpdateRequest $request)
    {

        try {

            if (is_null($request->password)) {
                $request->request->remove('password');
            } else {
                $request->request->add([
                    'password' => bcrypt($request->password)
                ]);
            }
            $user = User::updateRecord($request->except(['_token', 'id', 'role']), $request->id);
            $user_id = $user->id; 
            $existing_role_id = $user->role_id;
            if(isset($request->role) && $request->role!=$existing_role_id){
                $role_id = $request->role;
                if($role_id==0){
                    RoleUser::where([
                        'user_id'=>$user_id
                    ])->delete();
                }else{
                    RoleUser::updateOrCreate([
                        'role_id'=>$role_id,
                        'user_id'=>$user_id,
                    ]);    
                }
            }
            return redirect()->to(route('admin.'.$this->handle_name_plural.'.index'))->with('success', ucfirst($this->handle_name).' has been updated');
        } catch (Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }

    }

    public function ajax(Request $request)
    {

        $edit_route = route('admin.'.$this->handle_name_plural.'.edit');
        $current_page = $request->page_number;
        if (isset($request->limit)) {
            $limit = $request->limit;
        } else {
            $limit = 10;
        }
        $offset = (($current_page - 1) * $limit);
        $modalObject = new User();
        if (isset($request->string)) {
            $string = $request->string;
            $modalObject = $modalObject->where('name', 'like', "%" . $request->string . "%");
            // $modalObject = $modalObject->orWhere('name','like',"%".$request->string."%");
        }

        $total_records = $modalObject->count();
        $modalObject = $modalObject->offset($offset);
        $modalObject = $modalObject->take($limit);
        $data = $modalObject->get();

        if (isset($request->page_number) && $request->page_number != 1) {
            $page_number = $request->page_number + $limit - 1;
        } else {
            $page_number = 1;
        }
        $pagination = array(
            "offset" => $offset,
            "total_records" => $total_records,
            "item_per_page" => $limit,
            "total_pages" => ceil($total_records / $limit),
            "current_page" => $current_page,
        );

        return kview($this->handle_name_plural.'.ajax', compact('edit_route', 'data', 'page_number', 'limit', 'offset', 'pagination'));
    }
    
    public function delete()
    {
        $user = User::find(request()->data_id);
        $user->roles()->detach();
        $user->delete();
        return 1;
    }
}
