<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function index()
    {
        $payments = \App\Models\Payment::with(['project', 'stage'])->latest()->get();
        return view('admin.payments.index', compact('payments'));
    }
}
