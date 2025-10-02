<?php

use Illuminate\Support\Facades\Route;


Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/dashboard', [App\Http\Controllers\AdminController::class, 'index'])->name('dashboard');
    Route::get('/logouts', [App\Http\Controllers\AdminController::class, 'logouts'])->name('logouts');
    Route::get('/Users', [App\Http\Controllers\AdminController::class, 'users'])->name('users');
    Route::get('/Users/{id}', [App\Http\Controllers\AdminController::class, 'makeAdmin'])->name('makeAdmin');
    Route::get('/deleteUser/{id}', [App\Http\Controllers\AdminController::class, 'deleteUser'])->name('deleteUser');

 
    Route::get('/Comments', [App\Http\Controllers\AdminController::class, 'blogsComment'])->name('blogsComment');
    Route::post('/Comment/approve/{comment}', [App\Http\Controllers\AdminController::class, 'commentApprove'])->name('commentApprove');
    Route::get('/CommentDelete/{id}', [App\Http\Controllers\AdminController::class, 'destroyBlogComment'])->name('destroyBlogComment');

    Route::get('/Subscribers', [App\Http\Controllers\AdminController::class, 'subscribers'])->name('subscribers');
    Route::get('/Subscribers/{id}', [App\Http\Controllers\AdminController::class, 'destroySub'])->name('destroySub');

    Route::get('/getMessages', [App\Http\Controllers\AdminController::class, 'getMessages'])->name('getMessages');
    Route::get('/deleteMessages/{id}', [App\Http\Controllers\AdminController::class, 'deleteMessages'])->name('deleteMessages');

    
    Route::get('/setting',[App\Http\Controllers\SettingsController::class,'setting'])->name('setting');
    Route::post('/saveSetting',[App\Http\Controllers\SettingsController::class,'saveSetting'])->name('saveSetting');
    
    Route::get('/homePage',[App\Http\Controllers\SettingsController::class,'homePage'])->name('homePage');
    Route::post('/saveHome',[App\Http\Controllers\SettingsController::class,'saveHome'])->name('saveHome');
    
    Route::get('/aboutPage',[App\Http\Controllers\SettingsController::class,'aboutPage'])->name('aboutPage');
    Route::post('/saveAbout',[App\Http\Controllers\SettingsController::class,'saveAbout'])->name('saveAbout');

    Route::get('/eventsPage',[App\Http\Controllers\PagesController::class,'eventsPage'])->name('eventsPage');
    Route::post('/saveEvent',[App\Http\Controllers\PagesController::class,'saveEvent'])->name('saveEvent');    
    Route::post('/addEventImage', [App\Http\Controllers\PagesController::class, 'addEventImage'])->name('addEventImage');
    Route::get('/deleteEventImage/{id}', [App\Http\Controllers\PagesController::class, 'deleteEventImage'])->name('deleteEventImage');

    Route::get('/restoPage',[App\Http\Controllers\PagesController::class,'resto'])->name('resto');
    Route::post('/updateRestaurant',[App\Http\Controllers\PagesController::class,'saveResto'])->name('saveResto');    
    Route::post('/addRestoImage', [App\Http\Controllers\PagesController::class, 'addRestoImage'])->name('addRestoImage');
    Route::get('/deleteRestoImage/{id}', [App\Http\Controllers\PagesController::class, 'deleteRestoImage'])->name('deleteRestoImage');
    

        
    // Categories
    Route::get('/getCategories', [App\Http\Controllers\CategoriesController::class, 'index'])->name('getCategories');
    Route::post('/postCategory', [App\Http\Controllers\CategoriesController::class, 'store'])->name('postCategory');
    Route::get('/editCategory/{id}', [App\Http\Controllers\CategoriesController::class, 'edit'])->name('editCategory');
    Route::post('/updateCategory/{id}', [App\Http\Controllers\CategoriesController::class, 'update'])->name('updateCategory');
    Route::get('/deleteCategory/{id}', [App\Http\Controllers\CategoriesController::class, 'destroy'])->name('deleteCategory');
        
    // BLogs
    Route::get('/getBlogs', [App\Http\Controllers\BlogsController::class, 'index'])->name('getBlogs');
    Route::post('/saveBlog', [App\Http\Controllers\BlogsController::class, 'store'])->name('saveBlog');
    Route::get('/blog/{id}', [App\Http\Controllers\BlogsController::class, 'edit'])->name('editBlog');
    Route::get('/blogView/{id}', [App\Http\Controllers\BlogsController::class, 'view'])->name('viewBlog');
    Route::post('/updateBlog/{id}', [App\Http\Controllers\BlogsController::class, 'update'])->name('updateBlog');
    Route::get('/deleteBlog/{id}', [App\Http\Controllers\BlogsController::class, 'destroy'])->name('deleteBlog');
    Route::get('/Blog/{blog}/publish', [App\Http\Controllers\BlogsController::class, 'publish'])->name('publishBlog');


    // Services
    Route::get('/getServices', [App\Http\Controllers\ServicesController::class, 'index'])->name('getServices');
    Route::post('/storeService', [App\Http\Controllers\ServicesController::class, 'store'])->name('storeService');
    Route::get('/EditService/{id}', [App\Http\Controllers\ServicesController::class, 'edit'])->name('editService');
    Route::post('/UpdateService/{id}', [App\Http\Controllers\ServicesController::class, 'update'])->name('updateService');
    Route::get('/DeleteService/{id}', [App\Http\Controllers\ServicesController::class, 'destroy'])->name('deleteService');

    // Rooms
    Route::get('/getRooms', [App\Http\Controllers\RoomsController::class, 'index'])->name('getRooms');
    Route::post('/storeRoom', [App\Http\Controllers\RoomsController::class, 'store'])->name('storeRoom');
    Route::get('/editRoom/{id}', [App\Http\Controllers\RoomsController::class, 'edit'])->name('editRoom');
    Route::post('/updateRoom/{id}', [App\Http\Controllers\RoomsController::class, 'update'])->name('updateRoom');
    Route::get('/deleteRoom/{id}', [App\Http\Controllers\RoomsController::class, 'destroy'])->name('deleteRoom');

    Route::post('/addRoomImage', [App\Http\Controllers\RoomsController::class, 'addRoomImage'])->name('addRoomImage');
    Route::get('/deleteRoomImage/{id}', [App\Http\Controllers\RoomsController::class, 'deleteRoomImage'])->name('deleteRoomImage');

    // Facilities
    Route::get('/getFacilities', [App\Http\Controllers\FacilitiesController::class, 'index'])->name('getFacilities');
    Route::post('/storeFacility', [App\Http\Controllers\FacilitiesController::class, 'store'])->name('storeFacility');
    Route::get('/editFacility/{id}', [App\Http\Controllers\FacilitiesController::class, 'edit'])->name('editFacility');
    Route::post('/updateFacility/{id}', [App\Http\Controllers\FacilitiesController::class, 'update'])->name('updateFacility');
    Route::get('/deleteFacility/{id}', [App\Http\Controllers\FacilitiesController::class, 'destroy'])->name('deleteFacility');

    Route::post('/addFacilityImage', [App\Http\Controllers\FacilitiesController::class, 'addFacilityImage'])->name('addFacilityImage');
    Route::get('/deleteFacilityImage/{id}', [App\Http\Controllers\FacilitiesController::class, 'deleteFacilityImage'])->name('deleteFacilityImage');

    // Trips
    Route::get('/getTrips', [App\Http\Controllers\TripsController::class, 'index'])->name('getTrips');
    Route::post('/storeTrip', [App\Http\Controllers\TripsController::class, 'store'])->name('storeTrip');
    Route::get('/editTrip/{id}', [App\Http\Controllers\TripsController::class, 'edit'])->name('editTrip');
    Route::post('/updateTrip/{id}', [App\Http\Controllers\TripsController::class, 'update'])->name('updateTrip');
    Route::get('/deleteTrip/{id}', [App\Http\Controllers\TripsController::class, 'destroy'])->name('deleteTrip');

    Route::post('/addTripImage', [App\Http\Controllers\TripsController::class, 'addTripImage'])->name('addTripImage');
    Route::get('/deleteTripImage/{id}', [App\Http\Controllers\TripsController::class, 'deleteTripImage'])->name('deleteTripImage');

    // Tours
    Route::get('/getTours', [App\Http\Controllers\ToursController::class, 'index'])->name('getTours');
    Route::post('/storeTour', [App\Http\Controllers\ToursController::class, 'store'])->name('storeTour');
    Route::get('/editTour/{id}', [App\Http\Controllers\ToursController::class, 'edit'])->name('editTour');
    Route::post('/updateTour/{id}', [App\Http\Controllers\ToursController::class, 'update'])->name('updateTour');
    Route::get('/deleteTour/{id}', [App\Http\Controllers\ToursController::class, 'destroy'])->name('deleteTour');
    Route::post('/addTourImage', [App\Http\Controllers\ToursController::class, 'addTourImage'])->name('addTourImage');
    Route::get('/deleteTourImage/{id}', [App\Http\Controllers\ToursController::class, 'deleteTourImage'])->name('deleteTourImage');

    // Promotions
    Route::get('/getPromotions', [App\Http\Controllers\PromotionsController::class, 'index'])->name('getPromotions');
    Route::post('/storePromotion', [App\Http\Controllers\PromotionsController::class, 'store'])->name('storePromotion');
    Route::get('/editPromotion/{id}', [App\Http\Controllers\PromotionsController::class, 'edit'])->name('editPromotion');
    Route::post('/updatePromotion/{id}', [App\Http\Controllers\PromotionsController::class, 'update'])->name('updatePromotion');
    Route::get('/deletePromotion/{id}', [App\Http\Controllers\PromotionsController::class, 'destroy'])->name('deletePromotion');
    // Projects
    Route::get('/getPosts', [App\Http\Controllers\OpportunitiesController::class, 'index'])->name('getPosts');
    Route::post('/storePost', [App\Http\Controllers\OpportunitiesController::class, 'store'])->name('storePost');
    Route::get('/EditPost/{id}', [App\Http\Controllers\OpportunitiesController::class, 'edit'])->name('editPost');
    Route::post('/UpdatePost/{id}', [App\Http\Controllers\OpportunitiesController::class, 'update'])->name('updatePost');
    Route::get('/DeletePost/{id}', [App\Http\Controllers\OpportunitiesController::class, 'destroy'])->name('deletePost');
    // Route::get('/DeleteallProjects', [App\Http\Controllers\OpportunitiesController::class, 'deleteAllProjects'])->name('deleteAllProjects');


    // Gallery
    Route::get('/slides', [App\Http\Controllers\SlidesController::class, 'index'])->name('slides');
    Route::post('/saveSlide', [App\Http\Controllers\SlidesController::class, 'store'])->name('saveSlide');
    Route::get('/editSlide/{id}', [App\Http\Controllers\SlidesController::class, 'edit'])->name('editSlide');
    Route::post('/updateSlide/{id}', [App\Http\Controllers\SlidesController::class, 'update'])->name('updateSlide');
    Route::get('/destroySlide/{id}', [App\Http\Controllers\SlidesController::class, 'destroy'])->name('destroySlide');

    // Images
    Route::get('/images', [App\Http\Controllers\ImagesController::class, 'index'])->name('images');
    Route::post('/saveImage', [App\Http\Controllers\ImagesController::class, 'store'])->name('saveImage');
    Route::get('/editImage/{id}', [App\Http\Controllers\ImagesController::class, 'edit'])->name('editImage');
    Route::post('/updateImage/{id}', [App\Http\Controllers\ImagesController::class, 'update'])->name('updateImage');
    Route::get('/destroyImage/{id}', [App\Http\Controllers\ImagesController::class, 'destroy'])->name('destroyImage');
    // Gallery
    Route::get('/getPartners', [App\Http\Controllers\PartnersController::class, 'index'])->name('getPartners');
    Route::post('/savePartner', [App\Http\Controllers\PartnersController::class, 'store'])->name('savePartner');
    Route::get('/editPartner/{id}', [App\Http\Controllers\PartnersController::class, 'edit'])->name('editPartner');
    Route::post('/updatePartner/{id}', [App\Http\Controllers\PartnersController::class, 'update'])->name('updatePartner');
    Route::get('/destroyPartner/{id}', [App\Http\Controllers\PartnersController::class, 'destroy'])->name('destroyPartner');

    // Gallery
    Route::get('/getImages', [App\Http\Controllers\SlidesController::class, 'getImages'])->name('getImages');
    Route::post('/saveGallery', [App\Http\Controllers\SlidesController::class, 'saveImage'])->name('saveGallery');
    Route::get('/editGallery/{id}', [App\Http\Controllers\SlidesController::class, 'editGallery'])->name('editGallery');
    Route::post('/updateGallery/{id}', [App\Http\Controllers\SlidesController::class, 'updateGallery'])->name('updateGallery');
    Route::get('/destroyImage/{id}', [App\Http\Controllers\SlidesController::class, 'destroyImage'])->name('destroyImage');
    

});

Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/about-us', [App\Http\Controllers\HomeController::class, 'about'])->name('about');
Route::get('/our-rooms', [App\Http\Controllers\HomeController::class, 'rooms'])->name('rooms');
Route::get('/our-rooms/{slug}', [App\Http\Controllers\HomeController::class, 'room'])->name('room');
Route::get('/events', [App\Http\Controllers\HomeController::class, 'events'])->name('events');
Route::get('/tours', [App\Http\Controllers\HomeController::class, 'tours'])->name('tours');
Route::get('/tour/{slug}', [App\Http\Controllers\HomeController::class, 'tour'])->name('tour');
Route::get('/gallery', [App\Http\Controllers\HomeController::class, 'gallery'])->name('gallery');
Route::get('/contact', [App\Http\Controllers\HomeController::class, 'contact'])->name('contact');
Route::get('/promotions', [App\Http\Controllers\HomeController::class, 'promotions'])->name('promotions');
Route::get('/promotions/{slug}', [App\Http\Controllers\HomeController::class, 'promotion'])->name('promotion');
Route::get('/facilities', [App\Http\Controllers\HomeController::class, 'facilities'])->name('facilities');
Route::get('/facilities/{slug}', [App\Http\Controllers\HomeController::class, 'facility'])->name('facility');
Route::get('/articles', [App\Http\Controllers\HomeController::class, 'blogs'])->name('blogs');
Route::get('/articles/{slug}', [App\Http\Controllers\HomeController::class, 'singleBlog'])->name('singleBlog');
Route::get('/terms-and-conditions', [App\Http\Controllers\HomeController::class, 'terms'])->name('terms');

Route::get('/connect', [App\Http\Controllers\HomeController::class, 'connect'])->name('connect');

Route::get('/logouts', [App\Http\Controllers\HomeController::class, 'logouts'])->name('logouts');
Route::post('/subscribe', [App\Http\Controllers\HomeController::class, 'subscribe'])->name('subscribe');

Route::post('/sendMessage', [App\Http\Controllers\HomeController::class, 'sendMessage'])->name('sendMessage');
Route::post('/sendComment', [App\Http\Controllers\HomeController::class, 'sendComment'])->name('sendComment');
Route::post('/registerNow', [App\Http\Controllers\HomeController::class, 'registerNow'])->name('registerNow');
Route::post('/testimony', [App\Http\Controllers\HomeController::class, 'testimony'])->name('testimony');

