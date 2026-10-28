<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ActivityController extends Controller
{
    public function index(Request $request)
    {
        $query = Transaction::where('user_id', Auth::id());

        if ($request->filled('jenis') && $request->jenis !== 'semua') {
            $query->where('jenis', $request->jenis);
        }

        $transactions = $query->latest()->paginate(7)->withQueryString();

        return view('pages.activity.index', compact('transactions'));
    }
}
