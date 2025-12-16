<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\Student;
use App\Models\ClassSelection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PaymentController extends Controller
{
    public function index(Student $student)
    {
        if ($student->user_id !== Auth::id()) abort(403);
        if ($student->status !== 'awaiting_payment') return redirect()->route('dashboard');

        // Determine amount from the selected class for this student
        $selection = ClassSelection::where('student_id', $student->id)->latest()->first();
        $amount = 0;
        if ($selection && $selection->schoolClass) {
            $amount = $selection->schoolClass->price;
        }

        return view('payment.index', compact('student', 'amount'));
    }

    public function store(Request $request, Student $student)
    {
        if ($student->user_id !== Auth::id()) abort(403);
        if ($student->status !== 'awaiting_payment') return redirect()->route('dashboard');

        $request->validate([
            'payment_method' => 'required|in:transfer,cash',
            'proof' => 'required_if:payment_method,transfer|file|mimes:jpg,jpeg,png,pdf|max:2048',
        ]);

        $path = null;
        if ($request->payment_method === 'transfer' && $request->hasFile('proof')) {
            $path = $request->file('proof')->store('payments/' . $student->id, 'public');
        }


        // Determine amount from the selected class
        $selection = ClassSelection::where('student_id', $student->id)->latest()->first();
        $amount = 0;
        if ($selection && $selection->schoolClass) {
            $amount = $selection->schoolClass->price;
        }

        Payment::create([
            'student_id' => $student->id,
            'amount' => $amount,
            'payment_method' => $request->payment_method,
            'proof_path' => $path,
            'status' => 'pending',
        ]);

        $student->update(['status' => 'paid']);

        $message = $request->payment_method === 'transfer' 
            ? 'Bukti pembayaran berhasil diunggah. Menunggu verifikasi admin.' 
            : 'Metode pembayaran Tunai dipilih. Silakan lakukan pembayaran di unit.';

        return redirect()->route('dashboard')->with('success', $message);
    }
}
