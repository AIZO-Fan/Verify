<?php

namespace App\Http\Controllers;

use App\Models\CheckHistory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class HistoryController extends Controller
{
    /**
     * Display the authenticated user's check history with search/filter support.
     */
    public function index(Request $request): View
    {
        $query = CheckHistory::where('user_id', Auth::id())
            ->orderBy('created_at', 'desc');

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->input('status'));
        }

        // Filter by date range
        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->input('date_from'));
        }

        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->input('date_to'));
        }

        // Search by URL
        if ($request->filled('search')) {
            $query->where('url', 'like', '%' . $request->input('search') . '%');
        }

        $histories = $query->paginate(15)->withQueryString();

        $statuses = ['safe', 'suspicious', 'dangerous', 'unknown'];

        return view('history.index', compact('histories', 'statuses'));
    }

    /**
     * Delete a specific history record owned by the authenticated user.
     */
    public function destroy(CheckHistory $history): RedirectResponse
    {
        // Ensure the history belongs to the authenticated user
        if ($history->user_id !== Auth::id()) {
            abort(403, 'You are not authorized to delete this record.');
        }

        $history->delete();

        return redirect()->route('history.index')
            ->with('success', 'History record deleted successfully.');
    }

    /**
     * Import guest (unauthenticated) check history into the authenticated user's account.
     * Accepts an array of history items from local storage.
     */
    public function importGuest(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'items'                => ['required', 'array', 'min:1', 'max:100'],
            'items.*.url'          => ['required', 'string', 'url', 'max:2048'],
            'items.*.status'       => ['required', 'string', 'in:safe,suspicious,dangerous,unknown'],
            'items.*.result'       => ['nullable', 'array'],
            'items.*.checked_at'   => ['nullable', 'date'],
        ]);

        $userId = Auth::id();
        $now = now();
        $insertData = [];

        foreach ($validated['items'] as $item) {
            $insertData[] = [
                'user_id'    => $userId,
                'url'        => $item['url'],
                'status'     => $item['status'],
                'result'     => isset($item['result']) ? json_encode($item['result']) : null,
                'created_at' => isset($item['checked_at']) ? $item['checked_at'] : $now,
                'updated_at' => $now,
            ];
        }

        CheckHistory::insert($insertData);

        return response()->json([
            'success' => true,
            'imported' => count($insertData),
            'message' => count($insertData) . ' history items imported successfully.',
        ]);
    }
}
