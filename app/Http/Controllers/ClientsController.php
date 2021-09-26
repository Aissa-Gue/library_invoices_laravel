<?php

namespace App\Http\Controllers;

use App\Exports\ClientsExport;
use App\Imports\ClientsImport;
use App\Models\Client;
use App\Models\Order;
use App\Models\Person;
use App\Models\Provider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use Validator;

class ClientsController extends Controller
{
    public function showAllData(Request $request)
    {
        $last_name = $request->get('last_name');
        $first_name = $request->get('first_name');

        $clients = Client::join('people', 'people.id', 'clients.person_id')
            ->where('last_name', 'LIKE', '%' . $last_name . '%')
            ->where('first_name', 'LIKE', '%' . $first_name . '%')
            ->orderBy('created_at', 'DESC')
            ->paginate(15);

        return view('clients.clientsList')->with('clients', $clients);
    }

    public function show($id)
    {
        $client = Client::withTrashed()->where('person_id', $id)->first();
        $details = Order::where('client_id', $id)
            ->select(DB::raw('COUNT(*) as total_orders, SUM(required_amount) as total_required_amount'),
                DB::raw('sum(required_amount - paid_amount) As total_debts'))
            ->first();

        return view('clients.preview_client')
            ->with(compact('client', 'details'));
    }

    public function add()
    {
        return view('clients.add_client');
    }


    public function store(Request $request)
    {
        $validated = $request->validate([
            'last_name' => 'required',
            'first_name' => 'required',
            'father_name' => 'required',
            'address' => 'nullable',
            'phone1' => 'required|numeric|unique:people,phone1|unique:people,phone2',
            'phone2' => 'nullable|numeric|unique:people,phone1|unique:people,phone2',
        ]);

        DB::beginTransaction();
        $person = Person::Create($validated);
        $client = Client::Create(['person_id' => $person->id]);
        if (!$person || !$client) {
            DB::rollBack();
            return 'Error : you have a problem !';
        } else {
            DB::commit();
            return redirect(Route('previewClient', $person->id));
        }
    }


    public function edit($id)
    {
        $client = Client::withTrashed()->where('person_id', $id)->first();
        return view('clients.edit_client')->with('client', $client);
    }

    public function update($id, Request $request)
    {
        //$request->flash();
        $validated = $request->validate([
            'last_name' => 'alpha|required',
            'first_name' => 'alpha|required',
            'father_name' => 'alpha|required',
            'address' => 'nullable',
            'phone1' => 'required|numeric|unique:people,phone1,' . $id . '|unique:people,phone2,' . $id,
            'phone2' => 'nullable|numeric|unique:people,phone1,' . $id . '|unique:people,phone2,' . $id,
        ]);
        $person = Person::find($id);

        DB::beginTransaction();
        $person->Update($validated);
        $client = Client::Where('person_id', $id)->Update(['person_id' => $person->id]);
        if (!$person || !$client) {
            DB::rollBack();
            return 'Error : you have a problem !';
        } else {
            DB::commit();
            return redirect(Route('previewClient', $id));
        }
    }

    public function destroy($id)
    {
        Client::Where('person_id', $id)->delete();
        return redirect(Route('clientsList'));
    }

    public function settingClients()
    {
        return view('settings.clients');
    }

    public function importExcel()
    {
        Excel::import(new ClientsImport, request()->file('clients_file'));

        return redirect(Route('clientsList'))->with('success', 'All good!');
    }

    function exportExcel()
    {
        return Excel::download(new ClientsExport, 'قائمة الزبائن.xlsx');
    }

    /******* TRASHED CLIENTS *******/
    public function showTrashed()
    {
        $trashedClients = Client::onlyTrashed()->paginate(15);
        return view('trash.clients')
            ->with(compact('trashedClients'));
    }

    public function restoreTrashed($id)
    {
        Client::Where('person_id', $id)->restore();
        return redirect()->back();
    }

    public function dropTrashed($id)
    {
        //test if client has orders
        $clientOrders = Order::where('client_id', $id)->get();
        //test if client is also a provider
        $provider = Provider::where('person_id',$id)->first();

        if ($clientOrders->isEmpty()) {
            Client::where('person_id', $id)->forceDelete();
            if(empty($provider)){
                //delete from people table
                Person::where('id',$id)->delete();
            }
            return redirect()->back();
        } else {
            $deleteProblem = 'لا يمكنك حذف الزبون لوجود فواتير مرتبطة به';
            return redirect()->back()->with(compact('deleteProblem'));
        }

    }
}
