<?php

namespace App\Http\Controllers;

use App\Models\Movie;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use RealRashid\SweetAlert\Facades\Alert;

class MovieController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $movies = Movie::orderBy('tanggal_rilis', 'desc')->paginate(8);
        return view('movies', compact('movies'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        request()->validate([
            'poster' => 'required|file|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'nama' => 'required|string|max:255',
            'tanggal_rilis' => 'required|date',
        ]);

        $movie = new Movie;
        if ($request->hasFile('poster')) {
            $file = $request->file('poster');
            $filename = time() . '.' . $file->getClientOriginalExtension();
            $file->move('poster', $filename);
            $movie->poster = $filename;
        }

        $movie->nama = $request->nama;
        $movie->tanggal_rilis = $request->tanggal_rilis;
        $movie->save();

        Alert::success('Success', 'Data Berhasil Ditambahkan');

        return to_route('movies.index');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Movie  $movie
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Movie $movie)
    {
        request()->validate([
            'poster' => 'file|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'nama' => 'required|string|max:255',
            'tanggal_rilis' => 'required|date',
        ]);

        if ($request->hasFile('poster')) {
            if (File::exists(public_path('poster/' . $movie->poster))) {
                File::delete(public_path('poster/' . $movie->poster));
            }

            $file = $request->file('poster');
            $filename = time() . '.' . $file->getClientOriginalExtension();
            $file->move('poster', $filename);
            $movie->poster = $filename;
        }

        $movie->nama = $request->nama;
        $movie->tanggal_rilis = $request->tanggal_rilis;
        $movie->save();

        Alert::success('Berhasil', 'Data berhasil diubah');

        return to_route('movies.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Movie  $movie
     * @return \Illuminate\Http\Response
     */
    public function destroy(Movie $movie)
    {
        if (File::exists(public_path('poster/' . $movie->poster))) {
            File::delete(public_path('poster/' . $movie->poster));
        }
        $movie->delete();

        Alert::success('Berhasil', 'Data berhasil dihapus');

        return to_route('movies.index');
    }
}
