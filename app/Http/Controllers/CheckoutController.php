<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Event;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class CheckoutController extends Controller
{
    public function create(Event $event)
    {
        $categories = Category::all();
        return view('checkout.create', compact('event', 'categories'));
    }

    public function store(Request $request, Event $event)
    {
        $request->validate([
            'customer_name'  => 'required|string|max:255',
            'customer_email' => 'required|email|max:255',
            'customer_phone' => 'required|string|max:20',
        ]);

        if ($event->stock <= 0) {
            return back()->with('error', 'Mohon maaf, tiket untuk acara ini sudah habis.');
        }

        $orderId    = 'TRX-' . time() . '-' . Str::random(5);
        $totalPrice = $event->price > 0 ? $event->price + 5000 : 0;

        $transaction = Transaction::create([
            'event_id'       => $event->id,
            'order_id'       => $orderId,
            'customer_name'  => $request->customer_name,
            'customer_email' => $request->customer_email,
            'customer_phone' => $request->customer_phone,
            'total_price'    => $totalPrice,
            'status'         => 'Pending',
        ]);

        // ===== SOAL 2: BYPASS EVENT GRATIS =====
        if ($event->price == 0) {
            // Langsung tandai sukses tanpa lewat Midtrans
            $transaction->update(['status' => 'success']);

            // Kurangi stok langsung
            $event->stock = $event->stock - 1;
            $event->save();

            // Kirim email tiket langsung
            try {
                Mail::to($transaction->customer_email)
                    ->send(new \App\Mail\EventTicketMail($transaction));
            } catch (\Exception $e) {
                Log::error('Gagal kirim email tiket gratis: ' . $e->getMessage());
            }

            return redirect()->route('checkout.success', $orderId)
                ->with('success', 'Pendaftaran event gratis berhasil! E-Ticket sudah dikirim ke email Anda.');
        }
        // ===== AKHIR BYPASS =====

        // Event berbayar — lanjut ke Midtrans
        \Midtrans\Config::$serverKey    = env('MIDTRANS_SERVER_KEY');
        \Midtrans\Config::$isProduction = false;
        \Midtrans\Config::$isSanitized  = true;
        \Midtrans\Config::$is3ds        = true;

        $params = [
            'transaction_details' => [
                'order_id'     => $orderId,
                'gross_amount' => $totalPrice,
            ],
            'customer_details' => [
                'first_name' => $request->customer_name,
                'email'      => $request->customer_email,
                'phone'      => $request->customer_phone,
            ],
        ];

        try {
            $snapToken = \Midtrans\Snap::getSnapToken($params);
            $transaction->update(['snap_token' => $snapToken]);
            return redirect()->route('checkout.payment', $transaction->order_id);
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal memproses pembayaran: ' . $e->getMessage());
        }
    }

    public function payment($order_id)
    {
        $categories  = Category::all();
        $transaction = Transaction::with('event')
                        ->where('order_id', $order_id)
                        ->firstOrFail();
        return view('checkout.payment', compact('transaction', 'categories'));
    }

    public function success($order_id)
    {
        $categories  = Category::all();
        $transaction = Transaction::with('event')
                        ->where('order_id', $order_id)
                        ->firstOrFail();

        // Kalau sudah success (event gratis / webhook sudah masuk), langsung tampilkan
        if (in_array(strtolower($transaction->status), ['success', 'settlement'])) {
            return view('checkout.success', compact('transaction', 'categories'));
        }

        // Fallback: cek status ke Midtrans langsung
        try {
            \Midtrans\Config::$serverKey    = env('MIDTRANS_SERVER_KEY');
            \Midtrans\Config::$isProduction = false;
            \Midtrans\Config::$isSanitized  = true;
            \Midtrans\Config::$is3ds        = true;

            $status    = \Midtrans\Transaction::status($order_id);
            $trxStatus = is_array($status) ? ($status['transaction_status'] ?? '') : ($status->transaction_status ?? '');

            if (in_array($trxStatus, ['settlement', 'capture'])) {
                if (strtolower($transaction->status) === 'pending') {
                    $transaction->update(['status' => 'success']);

                    if ($transaction->event && $transaction->event->stock > 0) {
                        $transaction->event->stock -= 1;
                        $transaction->event->save();

                        try {
                            Mail::to($transaction->customer_email)
                                ->send(new \App\Mail\EventTicketMail($transaction));
                        } catch (\Exception $e) {
                            Log::error('Gagal kirim email: ' . $e->getMessage());
                        }
                    }
                }
            }
        } catch (\Exception $e) {
            // Midtrans key tidak valid (misal sandbox belum aktif) — tampilkan halaman sukses apa adanya
        }

        return view('checkout.success', compact('transaction', 'categories'));
    }
}