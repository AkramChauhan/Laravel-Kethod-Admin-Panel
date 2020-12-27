<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequests\AddUserRequest;
use App\Http\Requests\UserRequests\UpdateUserRequest;
use App\Models\User;
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
        $app_theme=config('app.theme');

        return view('themes.'.$app_theme.'.users.index', [
            // 'deploy_route' => route('admin.users.index'),
            'ajax_route' => route('admin.users.ajax'),
            'create_route' => route('admin.users.create'),
        ]);
    }

    /**
     * @return Factory|View
     */
    public function create()
    {
        $app_theme=config('app.theme');

        return view('themes.'.$app_theme.'.users.manage', [
            'form_action' => route('admin.users.store'),
            'edit' => 0
        ]);
    }

    /**
     * @param Request $request
     * @return Factory|View
     */
    public function edit(Request $request)
    {
        $app_theme=config('app.theme');

        return view('themes.'.$app_theme.'.users.manage', [
            'form_action' => route('admin.users.update'),
            'edit' => 1,
            'data' => User::where('id', '=', $request->id)->first()
        ]);
    }

    /**
     * @param AddUserRequest $request
     * @return RedirectResponse
     */
    public function store(AddUserRequest $request)
    {
        $app_theme=config('app.theme');

        try {
            $request->request->add([
                'password' => bcrypt($request->password)
            ]);
            User::createUser($request->all());
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
        $app_theme=config('app.theme');

        try {

            if (is_null($request->password)) {
                $request->request->remove('password');
            } else {
                $request->request->add([
                    'password' => bcrypt($request->password)
                ]);
            }
            User::updateUser($request->except(['_token', 'id']), $request->id);
            return redirect()->to(route('admin.users.index'))->with('success', 'User has been updated');
        } catch (Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }

    }

    /**
     * @param Request $request
     * @return Factory|View
     */
    public function ajax(Request $request)
    {
        $app_theme=config('app.theme');

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

        return view('themes.'.$app_theme.'.users.ajax', compact('edit_route', 'data', 'page_number', 'limit', 'offset', 'pagination'));
    }
}
