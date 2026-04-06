<?php

namespace App\Http\Controllers;

use App\Models\Item;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ItemController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $items = Item::all();
        return view('items', compact('items'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'stock' => 'required|integer|min:0',
            'harga_sewa_perhari' => 'required|numeric|min:0',
            'kondisi' => 'required|in:baik,rusak,perbaikan',
            'foto' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $data = $request->all();

        if ($request->hasFile('foto')) {
            $file = $request->file('foto');
            $filename = time() . '_' . Str::slug($request->name) . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('assets/img'), $filename);
            $data['foto'] = $filename;
        }

        Item::create($data);

        return redirect()->route('items')->with('success', 'Barang berhasil ditambahkan!');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Item $item)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'stock' => 'required|integer|min:0',
            'harga_sewa_perhari' => 'required|numeric|min:0',
            'kondisi' => 'required|in:baik,rusak,perbaikan',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $data = $request->all();

        if ($request->hasFile('foto')) {
            if ($item->foto && file_exists(public_path('assets/img/' . $item->foto))) {
                unlink(public_path('assets/img/' . $item->foto));
            }
            
            $file = $request->file('foto');
            $filename = time() . '_' . Str::slug($request->name) . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('assets/img'), $filename);
            $data['foto'] = $filename;
        }

        $item->update($data);

        return redirect()->route('items')->with('success', 'Barang berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Item $item)
    {
        if ($item->foto && file_exists(public_path('assets/img/' . $item->foto))) {
            unlink(public_path('assets/img/' . $item->foto));
        }
        
        $item->delete();

        return redirect()->route('items')->with('success', 'Barang berhasil dihapus!');
    }
}