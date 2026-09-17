<?php

namespace App\Http\Controllers\Api\Patient;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\Poli;
use Illuminate\Http\Request;

/**
 * Mengembalikan 50 slot nomor antrian per poli per hari
 * beserta status masing-masing: available / booked / mine
 */
class QueueSlotController extends Controller
{
    /**
     * GET /api/queue-slots?poli_id=&date=
     *
     * Response per slot:
     *   number   : int  (1–50)
     *   label    : string  (contoh: "UMUM-001")
     *   status   : "available" | "booked" | "mine"
     *   is_mine  : bool  (true jika milik user yang request, null jika guest)
     */
    public function index(Request $request)
    {
        $request->validate([
            'poli_id' => 'required|exists:polis,id',
            'date'    => 'nullable|date',
        ]);

        $poli   = Poli::findOrFail($request->poli_id);
        $date   = $request->filled('date') ? $request->date : today()->toDateString();
        $max    = 50; // fixed sesuai blueprint
        $code   = strtoupper($poli->code);
        $userId = $request->user()?->id;

        // Ambil semua appointment hari ini di poli ini (aktif)
        $booked = Appointment::where('poli_id', $poli->id)
            ->whereDate('appointment_date', $date)
            ->whereNotIn('status', ['cancelled', 'no_show'])
            ->get(['user_id', 'queue_number'])
            ->keyBy(function ($a) use ($code) {
                // Ekstrak angka dari queue_number, contoh "UMUM-007" → 7
                $parts = explode('-', $a->queue_number);
                return (int) end($parts);
            });

        $slots = [];
        for ($n = 1; $n <= $max; $n++) {
            $label     = $code . '-' . str_pad($n, 3, '0', STR_PAD_LEFT);
            $isMine    = false;
            $isBooked  = isset($booked[$n]);

            if ($isBooked && $userId !== null) {
                $isMine = (int) $booked[$n]->user_id === (int) $userId;
            }

            $slots[] = [
                'number'  => $n,
                'label'   => $label,
                'status'  => $isMine ? 'mine' : ($isBooked ? 'booked' : 'available'),
                'is_mine' => $isMine,
            ];
        }

        $availableCount = collect($slots)->where('status', 'available')->count();
        $bookedCount    = collect($slots)->where('status', 'booked')->count()
                        + collect($slots)->where('status', 'mine')->count();

        return response()->json([
            'data' => [
                'poli_id'         => $poli->id,
                'poli_name'       => $poli->name,
                'poli_code'       => $code,
                'date'            => $date,
                'max_slots'       => $max,
                'available_count' => $availableCount,
                'booked_count'    => $bookedCount,
                'is_full'         => $availableCount === 0,
                'slots'           => $slots,
            ],
        ]);
    }
}
