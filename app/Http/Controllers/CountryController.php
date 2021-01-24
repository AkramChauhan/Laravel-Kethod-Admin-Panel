<?php

namespace App\Http\Controllers;

use App\Http\Requests\CountryRequests\AddCountryRequest as AddRequest;
use App\Http\Requests\CountryRequests\UpdateCountryRequest as UpdateRequest;
use App\Models\Country as Table;
use Exception;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CountryController extends Controller
{
    protected $handle_name = "country";
    protected $handle_name_plural = "countries";

    public function index()
    {        
        return kview($this->handle_name_plural.'.index', [
            // 'deploy_route' => route('admin.'.$this->handle_name_plural.'.index'),
            'ajax_route' => route('admin.'.$this->handle_name_plural.'.ajax'),
            'delete_route'=> route('admin.'.$this->handle_name_plural.'.delete'),
            'create_route' => route('admin.'.$this->handle_name_plural.'.create'),
        ]);
    }
    public function create()
    {
        return kview($this->handle_name_plural.'.manage', [
            'form_action' => route('admin.'.$this->handle_name_plural.'.store'),
            'edit' => 0
        ]);
    }
    public function edit(Request $request)
    {
        return kview($this->handle_name_plural.'.manage', [
            'form_action' => route('admin.'.$this->handle_name_plural.'.update'),
            'edit' => 1,
            'data' => Table::where('id', '=', $request->id)->first()
        ]);
    }
    public function store(AddRequest $request)
    {
        try {
            $table = Table::createRecord($request->all());

            return redirect()->to(route('admin.'.$this->handle_name_plural.'.index'))->with('success', 'New '.$handle_name.' has been added.');
        } catch (Exception $e) {
            return $e->getMessage();
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
            Table::updateRecord($request->except(['_token', 'id']), $request->id);
            return redirect()->to(route('admin.'.$this->handle_name_plural.'.index'))->with('success', $handle_name.' has been updated');
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

        $total_records = $modalObject->count();
        $modalObject = $modalObject->offset($offset);
        $modalObject = $modalObject->take($limit);
        $modalObject = $modalObject->orderBy('id','desc');
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
        try{
            $table = Table::find(request()->data_id);
            $table->delete();
            return 1;
        } catch (Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
}
