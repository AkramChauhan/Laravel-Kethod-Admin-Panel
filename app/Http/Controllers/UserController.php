<?php

namespace App\Http\Controllers;

use App\Models\User as Table;
use App\Models\Role;
use Exception;
use App\Http\Requests\UserRequests\UpdateUser;
use App\Http\Requests\UserRequests\AddUser;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Auth;

class UserController extends Controller
{
    protected $handle_name = "user";
    protected $handle_name_plural = "users";
    
    public function index()
    {
        $all_count = Table::count();
        $trashed_count = Table::onlyTrashed()->count();
        return kview($this->handle_name_plural.'.index', [
            'ajax_route' => route('admin.'.$this->handle_name_plural.'.ajax'),
            'delete_route'=> route('admin.'.$this->handle_name_plural.'.delete'),
            'create_route' => route('admin.'.$this->handle_name_plural.'.create'),
            'table_status'=> 'all', //all , trashed
            'all_count'=>$all_count,
            'trashed_count'=>$trashed_count,
        ]);

    }
    public function create()
    {
        $roles = Role::get();
        return kview($this->handle_name_plural.'.manage', [
            'form_action' => route('admin.'.$this->handle_name_plural.'.store'),
            'edit' => 0,
            'roles'=>$roles,
        ]);
    }
    public function edit(Request $request)
    {
        $roles = Role::get();
        return kview($this->handle_name_plural.'.manage', [
            'form_action' => route('admin.'.$this->handle_name_plural.'.update'),
            'edit' => 1,
            'data' => Table::where('id', '=', $request->id)->first(),
            'roles'=>$roles,
        ]);
    }
    public function store(AddUser $request)
    {
        try {
            $table = Table::create([
                'name'=>$request->name,
                'email'=>$request->email,
                'password'=>$request->password,
            ]);
            if(isset($request->role)){
                $table->roles()->sync($request->role);
            }
            return redirect()->to(route('admin.'.$this->handle_name_plural.'.index'))->with('success', 'New '.ucfirst($this->handle_name).' has been added.');
        } catch (Exception $e) {
            return $e->getMessage();
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
    public function update(UpdateUser $request)
    {
        try {
            $update_data = [
                'name'=>$request->name,
                'email'=>$request->email,
            ];
            if(isset($request->password)){
                $update_data['password']= bcrypt($request->password);
            }
            $table = Table::updateOrCreate(
            [
                'id'=>$request->id,
            ],
            $update_data);
            if(isset($request->role)){
                $table->roles()->sync($request->role);
            }else{
                $table->roles()->detach();
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
        $modalObject = new Table();
        if (isset($request->string)) {
            $string = $request->string;
            $modalObject = $modalObject->where('name', 'like', "%" . $request->string . "%");
            // $modalObject = $modalObject->orWhere('name','like',"%".$request->string."%");
        }
        
        $all_trashed = $request->all_trashed;
        if($all_trashed=="trashed"){
            $modalObject = $modalObject->onlyTrashed();
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
    public function delete(Request $request)
    {
        if(isset($request->action)){
            $action = $request->action;
            $is_bulk = $request->is_bulk;
            $data_id = $request->data_id;
        }
        switch ($action){
            case 'restore':
                try{
                    if($is_bulk==1){
                        $data_id = explode(",",$data_id);
                        $table = Table::onlyTrashed()->whereIn('id',$data_id);
                        $table->restore();
                        return 1;
                    }else{
                        $table = Table::onlyTrashed()->find($data_id);
                        $table->restore();
                        return 1;
                    }
                } catch (Exception $e) {
                    return redirect()->back()->with('error', $e->getMessage());
                }
                break;
            case 'delete' :
                try{
                    if($is_bulk==1){
                        $data_id = explode(",",$data_id);
                        $table = Table::whereIn('id',$data_id);
                        $table->delete();
                        return 1;
                    }else{
                        $table = Table::find($data_id);
                        // $table->users()->detach();
                        $table->delete();
                        return 1;
                    }
                } catch (Exception $e) {
                    return redirect()->back()->with('error', $e->getMessage());
                }
                break;
            default : 
        }
    }
}
