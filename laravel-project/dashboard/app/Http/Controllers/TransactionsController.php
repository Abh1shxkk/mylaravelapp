<?php
namespace App\Http\Controllers;

use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TransactionsController extends Controller
{
    public function index(Request $request)
    {
        $payments = Payment::where('user_id', Auth::id())
            ->orderByDesc('paid_at')
            ->orderByDesc('created_at')
            ->paginate(10);

        return view('transactions.index', compact('payments'));
    }

    public function invoice(Payment $payment)
    {
        // Authorize ownership
        abort_if($payment->user_id !== Auth::id(), 403);
        return view('transactions.invoice', compact('payment'));
    }

    public function invoicePartial(Payment $payment)
    {
        abort_if($payment->user_id !== Auth::id(), 403);
        return view('transactions._invoice_card', compact('payment'));
    }

    public function destroy(Payment $payment)
    {
        abort_if($payment->user_id !== Auth::id(), 403);
        $payment->delete();
        if (request()->wantsJson()) {
            return response()->json(['success' => true]);
        }
        return redirect()->route('transactions.index')->with('success', 'Transaction deleted');
    }
}
