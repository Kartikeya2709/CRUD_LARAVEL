<?php

namespace App\Http\Controllers;

use App\Models\CommentLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class CommentLogController extends Controller
{
    public function index()
    {
        $currentPage = request()->get('page', 1);
        $perPage = 100;
        
        // Cache key for logs includes page number
        $cacheKey = 'comment.logs.page.' . $currentPage;
        
        // Get logs from cache or database with 5-minute expiry
        $logs = Cache::remember($cacheKey, now()->addMinutes(5), function () use ($perPage) {
            return CommentLog::with(['userComment.userProfile'])
                ->orderBy('created_at', 'desc')
                ->paginate($perPage);
        });
        
        return view('logs.index', compact('logs'));
    }
}
