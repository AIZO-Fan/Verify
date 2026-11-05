<?php

namespace App\Http\Controllers;

use App\Services\UrlVerificationService;
use App\Models\CheckHistory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CheckLinkController extends Controller
{
    public function __construct(private UrlVerificationService $verificationService) {}

    public function index()
    {
        $recentHistory = [];
        if (auth()->check()) {
            $recentHistory = CheckHistory::where('user_id', auth()->id())
                ->orderBy('checked_at', 'desc')
                ->take(5)
                ->get();
        }
        return view('check-link.index', compact('recentHistory'));
    }

    public function check(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'url' => ['required', 'string', 'max:2048'],
        ], [
            'url.required' => 'Please enter a URL to check.',
            'url.max'      => 'The URL is too long (maximum 2048 characters).',
        ]);

        if ($validator->fails()) {
            if ($request->expectsJson()) {
                return response()->json(['errors' => $validator->errors()], 422);
            }
            return back()->withErrors($validator)->withInput();
        }

        $url = trim($request->input('url'));

        // Add scheme if missing
        if (!preg_match('/^https?:\/\//i', $url)) {
            $url = 'https://' . $url;
        }

        $result = $this->verificationService->verify($url);

        // Save to database if user is authenticated
        if (auth()->check()) {
            CheckHistory::create([
                'user_id'    => auth()->id(),
                'url'        => $url,
                'status'     => $result['status'],
                'result'     => $result,
                'checked_at' => now(),
            ]);
        }

        if ($request->expectsJson()) {
            return response()->json($result);
        }

        return view('check-link.result', compact('result', 'url'));
    }
}
