<?php

namespace App\Http\Controllers;

use App\Http\Requests\RoleRequests\AddRoleRequest;
use App\Http\Requests\RoleRequests\UpdateRoleRequest;
use App\Models\Role;
use Exception;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class RoleController extends Controller
{
    public function index()
    {
        $app_theme=config('app.theme');

        return view('themes.'.$app_theme.'.roles.index', [
            // 'deploy_route' => route('admin.roles.index'),
            'ajax_route' => route('admin.roles.ajax'),
            'create_route' => route('admin.roles.create'),
        ]);
    }
    public function create()
    {
        $app_theme=config('app.theme');

        return view('themes.'.$app_theme.'.roles.manage', [
            'form_action' => route('admin.roles.store'),
            'edit' => 0
        ]);
    }
    public function edit(Request $request)
    {
        $app_theme=config('app.theme');

        return view('themes.'.$app_theme.'.roles.manage', [
            'form_action' => route('admin.roles.update'),
            'edit' => 1,
            'data' => Role::where('id', '=', $request->id)->first()
        ]);
    }
    public function store(AddRoleRequest $request)
    {
        $app_theme=config('app.theme');
        try {
            $role = Role::createRecord($request->all());

            return redirect()->to(route('admin.roles.index'))->with('success', 'New role has been added.');
        } catch (Exception $e) {
            return $e->getMessage();
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
    public function update(UpdateRoleRequest $request)
    {
        $app_theme=config('app.theme');

        try {

            if (is_null($request->password)) {
                $request->request->remove('password');
            } else {
                $request->request->add([
                    'password' => bcrypt($request->password)
                ]);
            }
            Role::updateRecord($request->except(['_token', 'id']), $request->id);
            return redirect()->to(route('admin.roles.index'))->with('success', 'Role has been updated');
        } catch (Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }

    }
    public function ajax(Request $request)
    {
        $app_theme=config('app.theme');

        $edit_route = route('admin.roles.edit');
        $current_page = $request->page_number;
        if (isset($request->limit)) {
            $limit = $request->limit;
        } else {
            $limit = 10;
        }
        $offset = (($current_page - 1) * $limit);
        $modalObject = new Role();
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

        return view('themes.'.$app_theme.'.roles.ajax', compact('edit_route', 'data', 'page_number', 'limit', 'offset', 'pagination'));
    }
    
    public function delete()
    {
        try{
            $role = Role::find(request()->data_id);
            $role->delete();
            return 1;
        } catch (Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
}
