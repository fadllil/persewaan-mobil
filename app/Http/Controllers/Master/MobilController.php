<?php

namespace App\Http\Controllers\Master;

use App\DataTables\MobilDataTable;
use App\Http\Controllers\Controller;
use App\Models\MasterMerek;
use App\Models\MasterMobil;
use App\Models\MasterModel;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class MobilController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(MobilDataTable $dataTable)
    {
        return $dataTable->render('master_mobil.index');
    }

    public function create()
    {
        $dataMerek = MasterMerek::orderBy('nama', 'asc')->get();
        $dataModel = MasterModel::orderBy('nama', 'asc')->get();

        return view('master_mobil.create', compact('dataMerek', 'dataModel'));
    }

    public function store (Request $request)
    {
        $validated = $request->validate([
            'id_merek' => 'required',
            'id_model' => 'required',
            'nama' => 'required',
            'no_plat' => 'required|unique:master_mobils,no_plat',
            'tahun' => 'required',
            'tarif' => 'required',
            'status' => 'required',
        ]);

        $request['tarif'] = preg_replace("/[^0-9]/", "", $request->tarif);

        MasterMobil::create($request->all());

        return redirect('master-mobil');
    }

    public function edit($id)
    {
        $dataMerek = MasterMerek::orderBy('nama', 'asc')->get();
        $dataModel = MasterModel::orderBy('nama', 'asc')->get();
        $data = MasterMobil::find($id);

        return view('master_mobil.update', compact('data', 'dataMerek', 'dataModel'));
    }

    public function update (Request $request, $id)
    {
        $validated = $request->validate([
            'id_merek' => 'required',
            'id_model' => 'required',
            'nama' => 'required',
            'no_plat' => [
                'required',
                Rule::unique('master_mobils')->ignore($id),
            ],
            'tahun' => 'required',
            'tarif' => 'required',
            'status' => 'required',
        ]);

        $request['tarif'] = preg_replace("/[^0-9]/", "", $request->tarif);

        MasterMobil::find($id)->update($request->all());

        return redirect('master-mobil');
    }

    public function delete ($id)
    {
        $data = MasterMobil::find($id);

        if(!$data){
            return response()->json([
                'message' => 'Data tidak ditemukan'
            ],404);
        }

        try{
            DB::beginTransaction();

            $data->delete();

            DB::commit();

            return response()->json([
                'message' => "Berhasil menghapus data"
            ], 200);
        }catch (Exception $e){
            DB::rollBack();

            return response()->json([
                'message' => "Terjadi kesalahan server"
            ], 500);

        }
    }
}
