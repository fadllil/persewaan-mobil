<?php

namespace App\Http\Controllers\Master;

use App\DataTables\MerekDataTable;
use App\Http\Controllers\Controller;
use App\Models\MasterMerek;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class MerekController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(MerekDataTable $dataTable)
    {
        return $dataTable->render('master_merek.index');
    }

    public function create()
    {
        return view('master_merek.create');
    }

    public function store (Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|unique:master_mereks',
        ]);

        MasterMerek::create($request->all());

        return redirect('master-merek');
    }

    public function edit($id)
    {
        $data = MasterMerek::find($id);

        return view('master_merek.update', compact('data'));
    }

    public function update (Request $request, $id)
    {
        $validated = $request->validate([
            'nama' => [
                'required',
                Rule::unique('master_mereks')->ignore($id),
            ]
        ]);

        MasterMerek::find($id)->update($request->all());

        return redirect('master-merek');
    }

    public function delete ($id)
    {
        $data = MasterMerek::find($id);

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
