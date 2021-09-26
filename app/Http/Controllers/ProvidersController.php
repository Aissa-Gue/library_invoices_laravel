<?php

namespace App\Http\Controllers;

use App\Exports\ProvidersExport;
use App\Imports\ProvidersImport;
use App\Models\Person;
use App\Models\Provider;
use App\Models\Purchase;
use App\Models\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class ProvidersController extends Controller
{
    public function showAllData(Request $request)
    {
        $last_name = $request->get('last_name');
        $first_name = $request->get('first_name');

        $providers = Provider::join('people', 'people.id', 'providers.person_id')
            ->where('last_name', 'LIKE', '%' . $last_name . '%')
            ->where('first_name', 'LIKE', '%' . $first_name . '%')
            ->orderBy('created_at', 'DESC')
            ->paginate(15);

        return view('providers.providersList')->with('providers', $providers);
    }

    public function show($id)
    {
        $provider = Provider::withTrashed()->where('person_id', $id)->first();
        $details = Purchase::where('provider_id', $id)
            ->select(DB::raw('COUNT(*) as total_purchases, SUM(required_amount) as total_required_amount'),
                DB::raw('sum(required_amount - paid_amount) As total_debts'))
            ->first();

        return view('providers.preview_provider')
            ->with(compact('provider', 'details'));
    }

    public function add()
    {
        return view('providers.add_provider');
    }


    public function store(Request $request)
    {
        $validatedPerson = $request->validate([
            'last_name' => 'required',
            'first_name' => 'required',
            'father_name' => 'required',
            'address' => 'nullable',
            'phone1' => 'required|numeric|unique:people,phone1|unique:people,phone2',
            'phone2' => 'required|numeric|unique:people,phone1|unique:people,phone2',
        ]);

        DB::beginTransaction();
        //Add to people table
        $person = Person::Create($validatedPerson);

        //Add person to providers table
        $request->request->set('person_id', $person->id);
        $validatedProvider = $request->validate([
            'person_id' => 'required|numeric',
            'establishment' => 'nullable',
        ]);
        $provider = Provider::Create($validatedProvider);

        if (!$person || !$provider) {
            DB::rollBack();
            return 'Error! : there is a problem';
        } else {
            DB::commit();
            return redirect(Route('previewProvider', $person->id));
        }
    }


    public function edit($id)
    {
        $provider = Provider::withTrashed()->where('person_id', $id)->first();
        return view('providers.edit_provider')->with('provider', $provider);
    }

    public function update($id, Request $request)
    {
        //$request->flash();
        $validatedPerson = $request->validate([
            'last_name' => 'alpha|required',
            'first_name' => 'alpha|required',
            'father_name' => 'alpha|required',
            'address' => 'nullable',
            'phone1' => 'required|numeric|unique:people,phone1,' . $id . '|unique:people,phone2,' . $id,
            'phone2' => 'nullable|numeric|unique:people,phone1,' . $id . '|unique:people,phone2,' . $id,
        ]);

        DB::beginTransaction();
        $person = Person::find($id)->Update($validatedPerson);

        $validatedProvider = $request->validate([
            'establishment' => 'nullable',
        ]);
        $provider = Provider::where('person_id', $id)->Update($validatedProvider);

        if (!$person || !$provider) {
            DB::rollBack();
            return 'Error! : there is a problem';
        } else {
            DB::commit();
            return redirect(Route('previewProvider', $id));
        }
    }

    public function destroy($id)
    {
        Provider::where('person_id', $id)->delete();
        return redirect(Route('providersList'));
    }

    public function settingProviders()
    {
        return view('settings.providers');
    }

    public function importExcel()
    {
        Excel::import(new ProvidersImport, request()->file('providers_file'));

        return redirect(Route('providersList'))->with('success', 'All good!');
    }

    function exportExcel()
    {
        return Excel::download(new ProvidersExport, 'قائمة المزودين.xlsx');
    }

    /******* TRASHED PROVIDERS *******/
    public function showTrashed()
    {
        $trashedProviders = Provider::onlyTrashed()->paginate(15);
        return view('trash.providers')
            ->with(compact('trashedProviders'));
    }

    public function restoreTrashed($id)
    {
        Provider::where('person_id', $id)->restore();
        return redirect()->back();
    }

    public function dropTrashed($id)
    {
        //test if provider has purchases
        $providerPurchases = Purchase::where('provider_id', $id)->get();
        //test if provider is also a client
        $client = Client::where('person_id', $id)->first();

        if ($providerPurchases->isEmpty()) {
            Provider::where('person_id', $id)->forceDelete();
            if (empty($client)) {
                //delete from people table
                Person::where('id', $id)->delete();
            }
            return redirect()->back();
        } else {
            $deleteProblem = 'لا يمكنك حذف المزود لوجود فواتير مرتبطة به';
            return redirect()->back()->with(compact('deleteProblem'));
        }

    }
}
