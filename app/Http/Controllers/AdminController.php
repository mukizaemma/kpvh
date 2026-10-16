<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Order;
use App\Models\Setting;
use App\Models\Subscriber;
use App\Models\Room;
use Illuminate\Http\Request;
use App\Models\Articlecomment;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use App\Mail\CommentApprovalNotification;
use App\Models\BlogComment;
use App\Models\Reservation;

class AdminController extends Controller
{
    public function index()
    {
        $users = User::all();

        $blogCommets = BlogComment::latest()->get();
        $blogCommetsCount = $blogCommets->count();
        $data = Setting::first();
        $rooms = Room::count();

        $setting = Setting::first();
        return view('admin.dashboard',[
            'blogCommetsCount' =>$blogCommetsCount,
            'users'=>$users,
            'data'=>$data,
            'setting'=>$setting,
            'rooms'=>$rooms,
        ]);
    }

    public function users(){
        $users = User::all();
        $setting = Setting::first();
        return view('admin.users',[
            'users'=>$users,
            'setting'=>$setting
        ]);
    }

    public function makeAdmin($id){
        $user = User::find($id);
        $user->role = 1;
        $user->save();

        return redirect()->back()->with('success','User is now an admin');
    }

    
    public function deleteUser($id)
    {
        $post = User::findOrFail($id);
        if ($post->email === 'admin@iremetech.com') {
            return redirect()->back()->with('error', 'This admin account cannot be deleted.');
        }
        $post->delete();

        return redirect()->back()->with('success', 'User has been deleted');
    }

    public function storeAdmin(Request $request)
    {
        $this->ensureSuperAdmin();

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $user = new User();
        $user->name = $validated['name'];
        $user->email = $validated['email'];
        $user->password = Hash::make($validated['password']);
        $user->role = '1';
        $user->user_id = (string) Str::uuid();
        $user->status = 'Active';
        $user->email_verified_at = now();
        $user->save();

        return redirect()->route('users')->with('success', 'New admin added. Share the password with them directly. No email was sent.');
    }

    public function password()
    {
        $setting = Setting::first();

        return view('admin.password', [
            'setting' => $setting,
        ]);
    }

    public function updatePassword(Request $request)
    {
        $validated = $request->validate([
            'current_password' => 'required|string',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $user = $request->user();
        if (!Hash::check($validated['current_password'], $user->password)) {
            return redirect()->back()->with('error', 'The current password is incorrect.');
        }

        $user->password = Hash::make($validated['password']);
        $user->save();

        return redirect()->back()->with('success', 'Your password has been updated.');
    }

    public function resetUserPassword(Request $request, $id)
    {
        $this->ensureSuperAdmin();

        $validated = $request->validate([
            'password' => 'required|string|min:8|confirmed',
        ]);

        $user = User::findOrFail($id);
        $user->password = Hash::make($validated['password']);
        $user->save();

        return redirect()->route('users')->with('success', 'Password updated for '.$user->email.'.');
    }

    private function ensureSuperAdmin(): void
    {
        if (!auth()->check() || auth()->user()->email !== 'admin@iremetech.com') {
            abort(403, 'Only the main admin can manage admin accounts.');
        }
    }


    public function blogsComment(Request $request)
    {
        $filter = $request->input('filter', 'all'); // Get the filter type, default to 'all'
    
        $comments = BlogComment::query();
    
        if ($filter === 'published') {
            $comments->where('status', 'Published');
        } elseif ($filter === 'unpublished') {
            $comments->where('status', 'Unpublished');
        }
    
        $comments = $comments->latest()->paginate(2);
    
        return view('admin.posts.comments', [
            'comments' => $comments,
            'filter' => $filter, // Pass the current filter to the view
        ]);
    }
    

    public function commentApprove(BlogComment $comment){

        if($comment->status !=='Published'){
            $comment->status='Published';
            $comment->save();

            $user = $comment->user;

            if($user){
                $details = [
                    'greeting' => 'Hello ' . $user->name . '!',
                    'body' => 'Thank you so much for your helpful comment',
                    'lastline' => 'Blessings!',
                ];
                Mail::to($user->email)->queue(new CommentApprovalNotification($details));
                return redirect()->route('blogsComment')->with('success', 'Comment approved successfully');
            }
        }
        return redirect()->back()->with('error', 'Unable to approve comment');

    }

    public function destroyBlogComment($id)
    {
        $comment = BlogComment::find($id); 
        $comment->delete($id);
        return back()
            ->with('success', 'Comment deleted successfully');
    }

    public function subscribers(){
        $setting = Setting::first();
        $subscribers = Subscriber::latest()->paginate(20);
        return view('admin.posts.subscribers',[
            'subscribers'=>$subscribers,
            'setting'=>$setting,
        ]);
    }

    
    public function destroySub($id)
    {
        $subscriber = Subscriber::find($id); 
        $subscriber->delete($id);
        return back()
            ->with('success', 'Subscriber deleted successfully');
    }
    public function getMessages(){
        $reservations = Reservation::with(['room', 'facility'])->latest()->paginate(15);
        $setting = Setting::first();
        return view('admin.posts.messages',[
            'reservations'=>$reservations,
            'setting'=>$setting,
        ]);
    }

    
    public function deleteReservation($id)
    {
        $reservation = Reservation::find($id); 
        $reservation->delete($id);
        return back()
            ->with('success', 'Message deleted successfully');
    }

    // public function visits()
    // {
    //     $totalVisits = DB::table('visits')->count();
    //     $uniqueVisitors = DB::table('visits')->distinct('ip_address')->count();


    //     return view('admin.dashboard',[
    //         'totalVisits'=>$totalVisits,
    //         'uniqueVisitors'=>$uniqueVisitors,
    //     ]);
    // }

}
