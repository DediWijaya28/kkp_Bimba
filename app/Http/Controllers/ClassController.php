<?php

namespace App\Http\Controllers;

use App\Models\SchoolClass;
use Illuminate\Http\Request;

class ClassController extends Controller
{
    public function index()
    {
        $classes = SchoolClass::latest()->get();
        return view('admin.classes.index', compact('classes'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'program' => 'nullable|string|max:255',
            'day' => 'required|string|max:255',
            'time' => 'required|string|max:255',
            'quota' => 'required|integer|min:1',
            'price' => 'required|integer|min:0',
        ]);

        SchoolClass::create($request->only(['name','program','day','time','quota','price']));

        return back()->with('success', 'Kelas berhasil ditambahkan.');
    }

    public function edit(SchoolClass $class)
    {
        return view('admin.classes.edit', compact('class'));
    }

    public function update(Request $request, SchoolClass $class)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'program' => 'nullable|string|max:255',
            'day' => 'required|string|max:255',
            'time' => 'required|string|max:255',
            'quota' => 'required|integer|min:1',
            'price' => 'required|integer|min:0',
        ]);

        $class->update($request->only(['name','program','day','time','quota','price']));

        return redirect()->route('admin.classes.index')->with('success', 'Kelas berhasil diperbarui.');
    }

    public function destroy(SchoolClass $class)
    {
        // Prevent deletion if there are students selected/assigned
        if ($class->selections()->exists()) {
            return back()->with('error', 'Kelas tidak dapat dihapus karena masih memiliki pendaftar. Hapus atau pindahkan pendaftar terlebih dahulu.');
        }

        $class->delete();
        return back()->with('success', 'Kelas berhasil dihapus.');
    }
}
