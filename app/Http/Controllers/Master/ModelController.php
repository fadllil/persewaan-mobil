<?php

namespace App\Http\Controllers\Master;

use App\DataTables\ModelDataTable;
use App\Http\Controllers\Controller;
use App\Models\MasterModel;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class ModelController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(ModelDataTable $dataTable)
    {
        return $dataTable->render('master_model.index');
    }

    public function create()
    {
        return view('master_model.create');
    }

    public function store (Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|unique:master_models',
        ]);

        MasterModel::create($request->all());

        return redirect('master-model');
    }

    public function edit($id)
    {
        $data = MasterModel::find($id);

        return view('master_model.update', compact('data'));
    }

    public function update (Request $request, $id)
    {
        $validated = $request->validate([
            'nama' => [
                'required',
                Rule::unique('master_models')->ignore($id),
            ]
        ]);

        MasterModel::find($id)->update($request->all());

        return redirect('master-model');
    }

    public function delete ($id)
    {
        $data = MasterModel::find($id);

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
