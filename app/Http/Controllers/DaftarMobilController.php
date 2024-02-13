<?php

namespace App\Http\Controllers;

use App\DataTables\DaftarMobilDataTable;
use App\Models\MasterMerek;
use App\Models\MasterMobil;
use App\Models\MasterModel;
use App\Models\SewaMobil;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DaftarMobilController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(DaftarMobilDataTable $dataTable)
    {
        return $dataTable->render('daftar_mobil.index');
    }

    public function sewa($id)
    {
        $dataMerek = MasterMerek::orderBy('nama', 'asc')->get();
        $dataModel = MasterModel::orderBy('nama', 'asc')->get();
        $data = MasterMobil::find($id);

        return view('daftar_mobil.sewa', compact('data', 'dataMerek', 'dataModel'));
    }

    public function store (Request $request, $id)
    {
        $validated = $request->validate([
            'tanggal_mulai' => 'required',
            'tanggal_selesai' => 'required'
        ]);

        $request['tarif'] = preg_replace("/[^0-9]/", "", $request->tarif);

        $start = Carbon::parse($request->tanggal_mulai);
        $end = Carbon::parse($request->tanggal_selesai);

        $diff = $start->diffInDays($end);

        $request['id_mobil'] = $id;
        $request['id_user'] = Auth::user()->id;
        $request['jumlah_hari'] = $diff;
        $request['total'] = $diff * $request['tarif'];
        $request['status'] = 'Disewa';

        try{
            DB::beginTransaction();


            SewaMobil::create($request->all());

            MasterMobil::where('id', $id)->update(['status'=>'Disewa']);

            DB::commit();

            return redirect('sewa-mobil');
        }catch (Exception $e){
            DB::rollBack();
            return redirect()->back()->with('error', 'Terjadi Kesalahan Server');
        }
    }
}
