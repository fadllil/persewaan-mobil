<?php

namespace App\Http\Controllers;

use App\DataTables\SewaMobilDataTable;
use App\Models\MasterMobil;
use App\Models\SewaMobil;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class SewaMobilController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(SewaMobilDataTable $dataTable)
    {
        return $dataTable->render('sewa_mobil.index');
    }

    public function pengembalian ($id)
    {
        try{
            DB::beginTransaction();

            $data = SewaMobil::find($id);
            MasterMobil::find($data->id_mobil)->update(['status' => "Tersedia"]);

            $data->update(['status' => "Selesai"]);

            DB::commit();
            return response()->json([
                'message' => "Berhasil mengembalikan mobil"
            ], 200);

        }catch (Exception $e){
            DB::rollBack();

            return response()->json([
                'message' => "Terjadi kesalahan server"
            ], 500);
        }
    }
}
