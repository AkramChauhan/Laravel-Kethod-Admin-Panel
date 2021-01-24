<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequests\AddUserRequest;
use App\Http\Requests\UserRequests\UpdateUserRequest;
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
    /**
     * @return Factory|View
     */
    public function index()
    {
        return kview('users.index', [
            'ajax_route' => route('admin.users.ajax'),
            'delete_route'=> route('admin.users.delete'),
            'create_route' => route('admin.users.create'),
        ]);
    }

    /**
     * @return Factory|View
     */
    public function create()
    {
        $roles = Role::get();
        return kview('users.manage', [
            'form_action' => route('admin.users.store'),
            'edit' => 0,
            'roles' => $roles
        ]);
    }

    /**
     * @param Request $request
     * @return Factory|View
     */
    public function edit(Request $request)
    {
        $roles = Role::get();

        return kview('users.manage', [
            'form_action' => route('admin.users.update'),
            'edit' => 1,
            'roles' => $roles,
            'data' => User::where('id', '=', $request->id)->with('roles')->first()
        ]);
    }

    /**
     * @param AddUserRequest $request
     * @return RedirectResponse
     */
    public function store(AddUserRequest $request)
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
            return redirect()->to(route('admin.users.index'))->with('success', 'New user has been added.');
        } catch (Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    /**
     * @param UpdateUserRequest $request
     * @return RedirectResponse
     */
    public function update(UpdateUserRequest $request)
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
            return redirect()->to(route('admin.users.index'))->with('success', 'User has been updated');
        } catch (Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }

    }

    public function ajax(Request $request)
    {

        $edit_route = route('admin.users.edit');
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

        return kview('users.ajax', compact('edit_route', 'data', 'page_number', 'limit', 'offset', 'pagination'));
    }
    
    public function delete()
    {
        $user = User::find(request()->data_id);
        $user->roles()->detach();
        $user->delete();
        return 1;
    }
}
