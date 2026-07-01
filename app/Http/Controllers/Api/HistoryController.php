<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\History;

class HistoryController extends Controller
{
    /**
     * Get all histories
     */
    public function index()
    {
        $histories = History::with('user')->latest()->get();
        return response()->json(['data' => $histories, 'message' => 'Histories fetched successfully']);
    }

    /**
     * Get histories by user_id
     */
    public function getByUser($user_id)
    {
        $histories = History::where('user_id', $user_id)
                            ->latest()
                            ->get();

        if ($histories->isEmpty()) {
            return response()->json(['message' => 'No history found for this user'], 404);
        }

        return response()->json(['data' => $histories, 'message' => 'Histories fetched successfully']);
    }

    /**
     * Store a new history (optional helper)
     */
    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'description' => 'required|string',
        ]);

        $history = History::create($request->only('user_id', 'description'));

        return response()->json(['message' => 'History created successfully', 'data' => $history]);
    }
}
