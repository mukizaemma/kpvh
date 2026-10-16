<?php

namespace App\Http\Controllers;

use DB;
use App\Models\Blog;
use App\Models\Room;
use App\Models\Trip;
use App\Models\About;
use App\Models\Slide;
use App\Models\Review;
use App\Models\Message;
use App\Models\Program;
use App\Models\Reservation;
use App\Models\Setting;
use App\Models\Facility;
use App\Models\Promotion;
use App\Models\Subscriber;
use App\Models\BlogComment;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\QueryException;
use Carbon\Carbon;

use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;


class HomeController extends Controller
{
    public function index(Request $request)
    {

        $setting = Setting::first();
        $slides = Slide::oldest()->get();
        $about = About::first();
        $rooms = Room::oldest()->get();
        $blogs = Blog::latest()->paginate(9);
        $facilities = Facility::with('images')->oldest()->take(3)->get();

        return view('frontend.home',[
            'setting'=>$setting,
            'slides'=>$slides,
            'about'=>$about,
            'rooms'=>$rooms,
            'blogs'=>$blogs,
            'facilities'=>$facilities,
            
        ]);

    }

    public function about(){
        $rooms = Room::oldest()->get();
        $setting = Setting::first();
        $about = About::first();
        return view('frontend.about',[
            'rooms'=>$rooms,
            'setting'=>$setting,
            'about'=>$about,
        ]);
    }

    public function rooms(){
        $facility = Facility::where('title','Accommodation')->firstOrFail();
        $rooms = Room::with('amenities')->oldest()->get();
        $setting = Setting::first();
        $about = About::first();
        return view('frontend.rooms',[
            'facility'=>$facility,
            'rooms'=>$rooms,
            'setting'=>$setting,
            'about'=>$about,
        ]);
    }

    public function room($slug){
        $room = Room::with('amenities')->where('slug', $slug)->firstOrFail();
        $amenities = $room->amenities;
        $images = $room->images;
        $allRooms = Room::where('id','!=',$room->id)->get();
        $setting = Setting::first();
        $about = About::first();
        return view('frontend.room',[
            'room'=>$room,
            'images'=>$images,
            'amenities'=>$amenities,
            'allRooms'=>$allRooms,
            'setting'=>$setting,
            'about'=>$about,
        ]);
    }

    public function facilities(){
        $facilities = Facility::with('images')->oldest()->get();
        $setting = Setting::first();
        $about = About::first();
        return view('frontend.facilities',[
            'facilities'=>$facilities,
            'setting'=>$setting,
            'about'=>$about,
        ]);
    }

    public function facility($slug){
        $facility = Facility::with('images')->where('slug', $slug)->firstOrFail();

        $images = $facility->images;
        $allFacilities = Facility::where('id','!=',$facility->id)->get();
        $facilities = Facility::all();
        $setting = Setting::first();
        $about = About::first();
        return view('frontend.facility',[
            'facility'=>$facility,
            'images'=>$images,
            'allFacilities'=>$allFacilities,
            'facilities'=>$facilities,
            'setting'=>$setting,
            'about'=>$about,
        ]);
    }


    public function promotions(){
        $promotions = Promotion::oldest()->get();
        $setting = Setting::first();
        $about = About::first();
        return view('frontend.promotions',[
            'promotions'=>$promotions,
            'about'=>$about,
            'setting'=>$setting,
        ]);
    }

        public function promotion($slug){
        $promotion = Promotion::where('slug', $slug)->firstOrFail();
        $allPromotions = Promotion::where('id','!=',$promotion->id)->get();

        $setting = Setting::first();
        $about = About::first();
        return view('frontend.promotion',[
            'promotion'=>$promotion,
            'allPromotions'=>$allPromotions,
            'setting'=>$setting,
            'about'=>$about,
        ]);
    }

    public function events(){
        $event = Eventpage::with('images')->first();
        $images = $event->images;
        return view('frontend.events',[
            'event'=>$event,
            'images'=>$images,
        ]);
    }

public function gallery()
{
    // Fetch images from both tables
    $roomImages = \DB::table('rooms')
        ->select('image', 'created_at')
        ->addSelect(\DB::raw("'room' as type"))
        ->get();

    $facilityImages = \DB::table('facilities')
        ->select('image', 'created_at')
        ->addSelect(\DB::raw("'facility' as type"))
        ->get();

    // Merge & sort by latest
    $merged = $roomImages
        ->merge($facilityImages)
        ->sortByDesc('created_at')
        ->values();

    // Paginate manually
    $perPage = 12;
    $page = request()->get('page', 1);
    $offset = ($page - 1) * $perPage;

    $gallery = new LengthAwarePaginator(
        $merged->slice($offset, $perPage)->values(),
        $merged->count(),
        $perPage,
        $page,
        ['path' => request()->url(), 'query' => request()->query()]
    );

    $setting = Setting::first();

    return view('frontend.gallery', [
        'gallery' => $gallery,
        'setting' => $setting,
    ]);
}



    public function terms(){
        $rooms = Room::all();
        $trips = Trip::all();
        $setting = Setting::first();
        $about = About::first();
        return view('frontend.terms',[
            'setting'=>$setting,
            'about'=>$about,
            'rooms'=>$rooms,
            'trips'=>$trips,
        ]);
    }

public const WHATSAPP_NUMBER = '250788316330';

public function bookNow(Request $request)
{
    $validated = $request->validate([
        'names' => 'required|string|max:255',
        'phone' => 'required|string|max:30',
        'email' => 'nullable|email|max:255',
        'room_id' => 'nullable|exists:rooms,id',
        'facility_id' => 'nullable|exists:facilities,id',
        'nights' => 'nullable|integer|min:1|max:365',
        'guests' => 'nullable|integer|min:1|max:100',
        'date_in' => 'nullable|date',
        'date_out' => 'nullable|date|after_or_equal:date_in',
        'message' => 'nullable|string|max:2000',
    ]);

    $nights = $validated['nights'] ?? null;
    if (!$nights && !empty($validated['date_in']) && !empty($validated['date_out'])) {
        $nights = (int) abs(Carbon::parse($validated['date_in'])->diffInDays(Carbon::parse($validated['date_out'])));
        $nights = $nights > 0 ? $nights : null;
    }

    $payload = [
        'room_id' => $validated['room_id'] ?? null,
        'facility_id' => $validated['facility_id'] ?? null,
        'nights' => $nights,
        'guests' => $validated['guests'] ?? null,
        'date_in' => $validated['date_in'] ?? null,
        'date_out' => $validated['date_out'] ?? null,
        'arrival_date' => $validated['date_in'] ?? null,
        'message' => $validated['message'] ?? null,
        'names' => $validated['names'],
        'email' => $validated['email'] ?? null,
        'phone' => $validated['phone'],
        'channel' => 'WhatsApp',
    ];

    try {
        $booking = Reservation::create($payload + ['status' => 'Pending']);
    } catch (QueryException $exception) {
        try {
            $booking = Reservation::create($payload + ['status' => 'pending']);
        } catch (QueryException $fallback) {
            report($fallback);

            return redirect()->back()
                ->withInput()
                ->with('error', 'Your booking could not be saved. Please try again, or send the details on WhatsApp.');
        }
    }

    $booking->load(['room', 'facility']);

    return redirect()->back()
        ->with('success', 'Your booking is saved. Please send the WhatsApp message so the hotel has every detail.')
        ->with('whatsapp_url', $this->whatsappUrl($booking));
}

private function whatsappUrl(Reservation $booking): string
{
    $lines = [
        'Hello Kivu Peace View Hotel, I would like to book a stay.',
        '',
        'Name: '.$booking->names,
        'Phone: '.$booking->phone,
        'Email: '.($booking->email ?: 'Not specified'),
        'Room: '.($booking->room?->title ?? 'Not specified'),
        'Service: '.($booking->facility?->title ?? 'Not specified'),
        'Check-in: '.($booking->date_in ?: 'Not specified'),
        'Check-out: '.($booking->date_out ?: 'Not specified'),
        'Nights: '.($booking->nights ?: 'Not specified'),
        'Guests: '.($booking->guests ?: 'Not specified'),
        'Request: '.($booking->message ?: 'None'),
    ];

    return 'https://wa.me/'.self::WHATSAPP_NUMBER.'?text='.rawurlencode(implode("\n", $lines));
}



    public function tours(){
        $tours = Trip::oldest()->get();
        $setting = Setting::first();
        $about = About::first();
        return view('frontend.tours',[
            'tours'=>$tours,
            'setting'=>$setting,
            'about'=>$about,
        ]);
    }

    public function tour($slug){
        $tour = Trip::with('images')->where('slug',$slug)->firstOrFail();
        $images = $tour->images ?? collect();
        $tours = Trip::where('id','!=',$tour->id)->oldest()->get();
        $allTrips = Trip::all();
        $setting = Setting::first();
        $about = About::first();
        return view('frontend.tour',[
            'tour'=>$tour,
            'images'=>$images,
            'tours'=>$tours,
            'allTrips'=>$allTrips,
            'setting'=>$setting,
            'about'=>$about,
        ]);
    }

    public function connect(){
        $rooms = Room::latest()->get();
        $facilities = Facility::latest()->get();
        $setting = Setting::first();
        $about = About::first();
        return view('frontend.contact',[

            'setting'=>$setting,
            'about'=>$about,
            'rooms'=>$rooms,
            'facilities'=>$facilities,
            'whatsappNumber'=>self::WHATSAPP_NUMBER,
        ]);
    }


    public function singleBlog($slug) {
        $blog = Blog::where('slug', $slug)->firstOrFail();
        $latestBlogs = Blog::where('status', 'Published')->where('id', '!=',$blog->id)->latest()->paginate(10);

        $setting = Setting::first();

        if ($blog) {
            $blog->increment('views');
            $comments = BlogComment::where('status','Published')->latest()->get();
            $commentsCount = $comments->count();

            $relatedBlogs = Blog::where('id', '!=', $blog->id)
                                    ->where('status', 'Published')
                                    ->take(5) 
                                    ->get();
        } else {

            return redirect()->route('blogs')->with('error', 'Article not found');
        }
    

        return view('frontend.blog', [
            'blog' => $blog, 
            'latestBlogs' => $latestBlogs, 
            'comments' => $comments, 
            'commentsCount' => $commentsCount, 
            'setting' => $setting, 
            'relatedBlogs'=>$relatedBlogs,
        ]);
    }
    public function blogs() {
        $articles = Blog::where('status', 'Published')->latest()->get();
        $latestBlogs = Blog::where('status', 'Published')->latest()->paginate(10);
        $setting = Setting::first();
        $rooms = Room::oldest()->get();
        return view('frontend.blogs', [
            'articles' => $articles, 
            'latestBlogs' => $latestBlogs, 
            'setting' => $setting, 
            'rooms'=>$rooms,
        ]);
    }


    public function subscribe(Request $request) {
        $request->validate([
            'email' => [
                'required',
                'email',
                Rule::unique('subscribers', 'email'),
            ],
        ]);

        $email = $request->input('email');

        $subscribed = Subscriber::create([
            'email' => $email,
        ]);


        if($subscribed){
            //$subscriber = Subscriber::where('email', $email)->firstOrFail();
            //Mail::to("mukizaemma34@gmail.com")->send(new NewSubscriberNotification($subscriber));
    
            return redirect()->back()->with('success', 'Thank you for subscribing to Kivu Peace View Hotel Resort, we will get back to you');
        }

        else{
            return redirect()->back()->with('error', 'Something Went Wrong. Try again later!');
        }        
    
    }
   

    public function sendMessage(Request $request) {
        $validatedData = $request->validate([
            'names' => 'required|string',
            'email' => 'required|email',
            'subject' => 'required|string',
            'message' => 'required|string',
        ]);
    
        // Now create the message with the validated data
        $message = Message::create($validatedData);  // Pass validated data
    
        // Mail::to("mukizaemma34@gmail.com")->send(new MessageNotification($message));
    
        return redirect()->back()->with('success', 'Thank you for reaching out... we will get back to you soon');
    }
    
    

    public function testimony(Request $request){

        $review = Review::create([
            'names' => $request->input('names'),
            'email' => $request->input('email'),
            'testimony' => $request->input('testimony'),
        ]);
    
        if (!$review) {
            return redirect()->back()->with('error', 'Failed to submit your testimony. Please try again.');
        }
    
        return redirect()->back()->with('success', 'Your testimony has submitted successfully!');
    }

    public function sendComment(Request $request) {
        $user = auth()->user();
    
        $comment = BlogComment::create([
            'blog_id' => $request->input('blog_id'),
            'names' => $request->input('names'),
            'email' => $request->input('email'),
            'comment' => $request->input('comment'),
            'user_id' => $user ? $user->id : null,
        ]);
    
        if ($comment) {
            // Mail::to('mukizaemma34@gmail.com')->send(new BlogCommentsNotofications($comment));
            return redirect()->back()->with('success', 'Comment added successfully');
        }
    
        else{
            return redirect()->back()->with('error', 'Failed to add the comment. Please try again.');
        }
    }

        public function logouts()
    {
        Auth::logout();                       // logout the user
        session()->invalidate();              // invalidate the session
        session()->regenerateToken();         // regenerate CSRF token
        return redirect()->route('home');            // redirect to login page
    }


}
