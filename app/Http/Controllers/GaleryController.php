<?php

namespace App\Http\Controllers;

use App\Models\Galery;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GaleryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $galery = Galery::where('iduser',Auth::user()->id)->get();
        return view('timeline',['galeris'=>$galery]);
        // return view('timeline');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'judul'=>'required',
            'foto'=>'required',
            'deskripsi'=>'required',
        ]);

        $namafoto = Auth::user()->id.'-' .date('YmdHis').$request->foto->getClientOriginalName();
        $data = [
            'judul'=>$request->judul,
            'foto' =>$namafoto,
            'deskripsi'=>$request->deskripsi,
            'tanggal' => now(),
            'iduser'=>Auth::user()->id,
        ];
        $request->foto->move(public_path('img'),$namafoto);
        Galery::create($data);
        return redirect('galeri');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Galery  $galery
     * @return \Illuminate\Http\Response
     */
    public function show(Galery $galery)
    {
        $galery->delete();
        return redirect('galeri');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Galery  $galery
     * @return \Illuminate\Http\Response
     */
    public function edit(Galery $galery)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Galery  $galery
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Galery $galery)
    {
        if ($request->hasFile('foto')) {
            $namafoto = Auth::user()->id.'-'.date('YmdHis').
            $request->foto->getClientOriginalName();
            $request->foto->move(public_path('img'),$namafoto);
            $galery->judul = $request->judul;
            $galery->foto = $namafoto;
            $galery->deskripsi = $request->deskripsi;
            $galery->tanggal = now();
            $galery->iduser = Auth::user()->id;
            $galery->save();
        } else {
            $galery->judul=$request->judul;
            $galery->foto=$request->foto;
            $galery->deskripsi=$request->deskripsi;
            $galery->tanggal=now();
            $galery->iduser = Auth::user()->id;
            $galery->save();
        }
        
        return redirect('galeri');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Galery  $galery
     * @return \Illuminate\Http\Response
     */
    public function destroy(Galery $galery)
    {
        //
    }
}
