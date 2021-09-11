<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Validator;
Use App\Models\Client;

class ClientsController extends Controller
{
    public function showAllData(Request $request){
        $last_name = $request->get('last_name');
        $first_name = $request->get('first_name');

        $clients = Client::where('last_name', 'LIKE', '%' . $last_name . '%')
            ->where('first_name', 'LIKE', '%' . $first_name . '%')
            ->paginate(15);

        return view('clients.clientsList')->with('clients', $clients);
    }

    public function show($id)
    {
        $client = Client::findOrFail($id);
        $details = Order::where('client_id',$id)
            ->select(DB::raw('COUNT(*) as total_orders, SUM(required_amount) as total_amount'))
            ->first();

        return view('clients.preview_client')
            ->with(compact('client','details'));
    }

    public function add(){
        return view('clients.add_client');
    }


    public function store(Request $request){
        $validated = $request->validate([
            'last_name' => 'required',
            'first_name' => 'required',
            'father_name' => 'required',
            'address' => 'required',
            'phone1' => 'required|numeric|unique:clients',
            'phone2' => 'nullable|numeric|unique:clients',
        ]);
        $client = Client::Create($validated);
        return redirect(Route('previewClient',$client->id));
    }


    public function edit($id)
    {
        $client = Client::findOrFail($id);
        return view('clients.edit_client')->with('client', $client);
    }

    public function update($id, Request $request)
    {
        //$request->flash();
        $validated = $request->validate([
            'last_name' => 'alpha|required',
            'first_name' => 'alpha|required',
            'father_name' => 'alpha|required',
            'address' => 'required',
            'phone1' => 'required|numeric|unique:clients,phone1,'.$id,
            'phone2' => 'nullable|numeric|unique:clients,phone2,'.$id,
        ]);
        $client = Client::find($id)->Update($validated);
        return redirect(Route('previewClient', $id));
    }

    public function destroy($id)
    {
        Client::find($id)->delete();
        return redirect(Route('clientsList'));
    }

}
