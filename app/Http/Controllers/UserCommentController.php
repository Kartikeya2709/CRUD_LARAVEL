<?php

namespace App\Http\Controllers;

use App\Models\UserProfile;
use App\Models\UserComment;
use Illuminate\Http\Request;
use App\Models\CommentLog;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;

class UserCommentController extends Controller
{
    public function index()
    {
        $currentPage = request()->get('page', 1);
        $perPage = 100;
        
        // Cache key includes the page number
        $cacheKey = 'users.page.' . $currentPage;
        
        // Get data from cache or database
        $users = Cache::remember($cacheKey, now()->addMinutes(5), function () use ($perPage) {
            return UserProfile::with('comment')
                ->orderBy('created_at', 'desc')
                ->paginate($perPage);
        });
        
        return view('users.index', compact('users'));
    }
    
    public function store(Request $request)
    {
        $request->validate([
            'email' => 'required|email|unique:user_profiles',
            'name' => 'required',
            'username' => 'required',
            'date_of_birth' => 'required|date',
            'gender' => 'required|in:male,female,other',
            'phone' => 'required|unique:user_profiles',
            'address' => 'required',
            'city' => 'required',
            'state' => 'required',
            'country' => 'required',
            'zip' => 'required',
            'comment' => 'required'
        ]);
        
        try {
            DB::beginTransaction();
            
            $userData = $request->except('comment');
            $user = UserProfile::create($userData);
            
            $comment = $user->comment()->create([
                'email' => $user->email,
                'comment' => $request->comment
            ]);
            
            CommentLog::create([
                'email' => $user->email,
                'old_comment' => null,
                'new_comment' => $request->comment,
                'action' => 'create'
            ]);
            
            DB::commit();
            
            // Clear first page cache when new user is added
            Cache::forget('users.page.1');
            Cache::forget('comment.logs.page.1');
            
            return redirect()->route('users.index')->with('success', 'User created successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Error creating user: ' . $e->getMessage())->withInput();
        }
    }
    
    public function update(Request $request, $email)
    {
        try {
            DB::beginTransaction();
            
            $user = UserProfile::findOrFail($email);
            
            if ($request->has('comment')) {
                $userComment = $user->comment;
                
                if (!$userComment) {
                    DB::rollBack();
                    return redirect()->back()->with('error', 'No comment found for this user.');
                }
                
                $oldComment = $userComment->comment;
                
                $userComment->update([
                    'comment' => $request->comment
                ]);
                
                CommentLog::create([
                    'email' => $user->email,
                    'old_comment' => $oldComment,
                    'new_comment' => $request->comment,
                    'action' => 'update'
                ]);
                
                DB::commit();
                cache()->forget('users.page.' . request()->get('page', 1));
                
                return redirect()->route('users.index')->with('success', 'Comment updated successfully.');
            }
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Error updating comment: ' . $e->getMessage());
        }
    }
    
    public function destroy($email)
    {
        try {
            DB::beginTransaction();
            
            $user = Cache::remember('user.' . $email, now()->addMinutes(5), function () use ($email) {
                return UserProfile::findOrFail($email);
            });
            
            $userComment = $user->comment;
            
            if (!$userComment) {
                DB::rollBack();
                return redirect()->back()->with('error', 'No comment found for this user.');
            }
            
            $oldComment = $userComment->comment;
            
            CommentLog::create([
                'email' => $user->email,
                'old_comment' => $oldComment,
                'new_comment' => 'Comment deleted',
                'action' => 'delete'
            ]);
            
            $user->delete(); // This will also delete the associated comment due to foreign key constraint
            
            DB::commit();
            
            // Clear all relevant caches
            Cache::forget('user.' . $email);
            Cache::forget('users.page.' . request()->get('page', 1));
            Cache::forget('comment.logs.page.1');
            
            return redirect()->route('users.index')->with('success', 'User deleted successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Error deleting user: ' . $e->getMessage());
        }
    }
}
