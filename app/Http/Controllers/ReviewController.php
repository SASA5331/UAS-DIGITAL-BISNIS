<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Review;
use App\Models\Transaction;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    /**
     * Simpan ulasan baru dari pembeli.
     */
    public function store(Request $request, Event $event)
    {
        $request->validate([
            'rating'         => 'required|integer|min:1|max:5',
            'comment'        => 'nullable|string|max:1000',
            'reviewer_name'  => 'required|string|max:255',
            'reviewer_email' => 'required|email|max:255',
        ]);

        // Cek apakah event sudah selesai (hanya event yang sudah lewat bisa di-review)
        if ($event->date > now()) {
            return back()->with('error', 'Event belum selesai, ulasan belum bisa diberikan.');
        }

        // Cek apakah sudah pernah review (1 email = 1 review per event)
        $existing = Review::where('event_id', $event->id)
                        ->where('reviewer_email', $request->reviewer_email)
                        ->first();

        if ($existing) {
            return back()->with('error', 'Anda sudah memberikan ulasan untuk event ini.');
        }

        Review::create([
            'event_id'       => $event->id,
            'reviewer_name'  => $request->reviewer_name,
            'reviewer_email' => $request->reviewer_email,
            'rating'         => $request->rating,
            'comment'        => $request->comment,
        ]);

        return back()->with('success', 'Terima kasih! Ulasan Anda berhasil dikirim.');
    }
}