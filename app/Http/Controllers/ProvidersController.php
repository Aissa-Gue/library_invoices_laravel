<?php

namespace App\Http\Controllers;

use App\Exports\ProvidersExport;
use App\Imports\ProvidersImport;
use App\Models\Provider;
use App\Models\Purchase;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class ProvidersController extends Controller
{
    public function showAllData(Request $request){
        $last_name = $request->get('last_name');
        $first_name = $request->get('first_name');

        $providers = Provider::where('last_name', 'LIKE', '%' . $last_name . '%')
            ->where('first_name', 'LIKE', '%' . $first_name . '%')
            ->orderBy('created_at', 'DESC')
            ->paginate(15);

        return view('providers.providersList')->with('providers', $providers);
    }

    public function show($id)
    {
        $provider = Provider::withTrashed()->findOrFail($id);
        $details = Purchase::where('provider_id',$id)
            ->select(DB::raw('COUNT(*) as total_purchases, SUM(required_amount) as total_required_amount'),
                DB::raw('sum(required_amount - paid_amount) As total_debts'))
            ->first();

        return view('providers.preview_provider')
            ->with(compact('provider','details'));
    }

    public function add(){
        return view('providers.add_provider');
    }


    public function store(Request $request){
        $validated = $request->validate([
            'last_name' => 'required',
            'first_name' => 'required',
            'father_name' => 'required',
            'address' => 'nullable',
            'establishment' => 'nullable',
            'phone1' => 'required|numeric|unique:providers',
            'phone2' => 'nullable|numeric|unique:providers',
        ]);
        $provider = Provider::Create($validated);
        return redirect(Route('previewProvider',$provider->id));
    }


    public function edit($id)
    {
        $provider = Provider::findOrFail($id);
        return view('providers.edit_provider')->with('provider', $provider);
    }

    public function update($id, Request $request)
    {
        //$request->flash();
        $validated = $request->validate([
            'last_name' => 'alpha|required',
            'first_name' => 'alpha|required',
            'father_name' => 'alpha|required',
            'address' => 'nullable',
            'establishment' => 'nullable',
            'phone1' => 'required|numeric|unique:providers,phone1,'.$id,
            'phone2' => 'nullable|numeric|unique:providers,phone2,'.$id,
        ]);
        $provider = Provider::find($id)->Update($validated);
        return redirect(Route('previewProvider', $id));
    }

    public function destroy($id)
    {
        Provider::find($id)->delete();
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
    public function showTrashed(){
        $trashedProviders = Provider::onlyTrashed()->paginate(15);
        return view('trash.providers')
            ->with(compact('trashedProviders'));
    }

    public function restoreTrashed($id){
        $trashedProvider = Provider::onlyTrashed()->find($id);
        $trashedProvider->restore();
        return redirect()->back();
    }

    public function dropTrashed($id){
        //test if provider has purchases
        $providerPurchases = Purchase::where('provider_id',$id)->get();

        if($providerPurchases->isEmpty()){
            $trashedProvider = Provider::onlyTrashed()->find($id);
            $trashedProvider->forceDelete();
            return redirect()->back();
        }else{
            $deleteProblem = 'لا يمكنك حذف المزود لوجود فواتير مرتبطة به';
            return redirect()->back()->with(compact('deleteProblem'));
        }

    }
}
