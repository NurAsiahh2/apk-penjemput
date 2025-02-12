<?php

namespace App\Http\Controllers;

use App\Models\Pickup;
use App\Models\Student;
use Illuminate\Http\Request;

class PickupController extends Controller
{
    public function index()
    {
        $pickups = Pickup::with('student')->get();
        return view('admin.pickups.index', compact('pickups'));
    }

    public function create()
    {
        $pickups = Pickup::all();
        return view('admin.pickups.index', compact('pickups'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'student_id' => 'required|exists:students,id',
            'pickup_name' => 'required|string|max:255',
        ]);

        Pickup::create($validated);
        return redirect()->route('pickups.index')->with('success', 'Data penjemputan berhasil ditambahkan.');
    }

    public function edit(Pickup $pickup)
    {
        $students = Student::all();
        return view('admin.pickups.index', compact('pickup', 'students'));
    }
    
    public function update(Request $request, Pickup $pickup)
    {
        $validated = $request->validate([
            'student_id' => 'required|exists:students,id',
            'pickup_name' => 'required|string|max:255',
        ]);

        if ($request->hasFile('pickup_image')) {
            $validated['pickup_image'] = $request->file('pickup_image')->store('pickups', 'public');
        }

        $pickup->update($validated);
        return redirect()->route('pickups.index')->with('success', 'Data penjemputan berhasil diperbarui.');
    }

    public function show(Pickup $pickup)
    {
        return view('admin.pickups.show', compact('pickup'));
    }

    public function destroy(Pickup $pickup)
    {
        $pickup->delete();
        return redirect()->route('pickups.index')->with('success', 'Data penjemputan berhasil dihapus.');
    }
}