<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    public function index(Request $request)
    {
        $query = Transaction::with('user')->latest();

        if ($request->filled('jenis') && $request->jenis !== 'semua') {
            $query->where('jenis', $request->jenis);
        }

        $transactions = $query->paginate(7)->withQueryString();

        return view('pages.admin.transaction.index', compact('transactions'));
    }
}
