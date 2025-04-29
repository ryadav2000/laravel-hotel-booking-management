<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

/* Frontend Controller */
use App\Http\Controllers\UserController;
use App\Http\Controllers\Frontend\FrontendRoomController;
use App\Http\Controllers\Frontend\BookingController;
use App\Http\Controllers\Frontend\ContactController;



/* Backend Controller */
use App\Http\Controllers\Backend\TeamController;
use App\Http\Controllers\Backend\RoomTypeController;
use App\Http\Controllers\Backend\RoomController;
use App\Http\Controllers\Backend\RoomListController;
use App\Http\Controllers\Backend\SettingController;
use App\Http\Controllers\Backend\TestimonialController;
use App\Http\Controllers\Backend\BlogController;
use App\Http\Controllers\Backend\CommentController;
use App\Http\Controllers\Backend\ReportController;
use App\Http\Controllers\Backend\GalleryController;
use App\Http\Controllers\Backend\RoleController;



/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });

/*  Homepage Route */
Route::get('/', [UserController::class, 'Index']);

Route::get('/dashboard', function () {
    return view('frontend.dashboard.user_dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');



Route::middleware('auth')->group(function () {
    /* User Profile Route */ 
    Route::get('/profile', [UserController::class, 'UserProfile'])->name('user.profile');

    /* User Profile Update */
    Route::post('/profile/store', [UserController::class, 'UserStore'])->name('profile.store');

    /* User Profile logout */
    Route::get('/user/logout', [UserController::class, 'UserLogout'])->name('user.logout');

    /* User Change Password Page*/
    Route::get('/user/change/password', [UserController::class, 'UserChangePassword'])->name('user.change.password');

    /* User Change Password functionality */
    Route::post('/password/change/store', [UserController::class, 'ChangePasswordStore'])->name('password.change.store');
    
});

require __DIR__ . '/auth.php';

/* Admin Group midddleware */
/* AdminController */
Route::middleware(['auth', 'roles:admin'])->group(function () {

    Route::get('/admin/dashboard', [AdminController::class, 'AdminDashboard'])->name('admin.dashboard');

    /* Admin logout Route */
    Route::get('/admin/logout', [AdminController::class, 'AdminLogout'])->name('admin.logout');

    /* Admin Profile Route to open */
    Route::get('admin/profile', [AdminController::class, 'AdminProfile'])->name('admin.profile');

    /* Admin Profile Store Route */
    Route::post('/admin/profile/store', [AdminController::class, 'AdminProfileStore'])->name('admin.profile.store');

    /* Admin Change Pasword Route */
    Route::get('admin/change/password', [AdminController::class, 'AdminChangePassword'])->name('admin.change.password');

    /* Admin Password Update Route */
    Route::post('/admin/password/update', [AdminController::class, 'AdminPasswordUpdate'])->name('admin.password.update');


});  // End Admin Group Middleware


/* Admin Login Page Route */
Route::get('/admin/login', [AdminController::class, 'AdminLogin'])->name('admin.login');


// Admin Group Middleware 
/* Group Route for team Controller */
Route::middleware(['auth','roles:admin'])->group(function(){

    // Team All Route
    Route::controller(TeamController::class)->group(function(){
        
        // Team All Page
        Route::get('/all/team', 'AllTeam')->name('all.team')->middleware('permission:team.all');

        // Add Team Data
        Route::get('/add/team', 'AddTeam')->name('add.team')->middleware('permission:team.add');

        // Add Team Store Data 
        Route::post('/team/store', 'StoreTeam')->name('team.store');

        // Edit Team Data 
        Route::get('/edit/team/{id}', 'EditTeam')->name('edit.team');

        // Update Team Data 
        Route::post('/team/update', 'UpdateTeam')->name('team.update');

        // Delete Team Data 
        Route::get('/delete/team/{id}', 'DeleteTeam')->name('delete.team');
    });

    // Book Area All Route
    Route::controller(TeamController::class)->group(function(){

        // Edit Page For Book Area
        Route::get('/book/area', 'BookArea')->name('book.area');

        // Update Page For Book Area
        Route::post('/book/area/update', 'BookAreaUpdate')->name('book.area.update');

    });


        // RoomTypeController All Route
        Route::controller(RoomTypeController::class)->group(function(){

            // Room Type Page Route 
            Route::get('/room/type/list', 'RoomTypeList')->name('room.type.list');

            // Add Room Type Route Page 
            Route::get('/add/room/type', 'AddRoomType')->name('add.room.type');

            // Store Room Type Route Page 
            Route::post('/room/type/store', 'RoomTypeStore')->name('room.type.store');
    
        });


        // RoomController All Route
        Route::controller(RoomController::class)->group(function(){

            // Room edit Page Route 
            Route::get('/edit/room/{id}', 'EditRoom')->name('edit.room');

            // Room Update Page Route 
            Route::post('/update/room/{id}', 'UpdateRoom')->name('update.room');

            // Delete Multi Image route Route 
            Route::get('/multi/image/delete/{id}', 'MultiImageDelete')->name('multi.image.delete');
   
            // Room Store Route 
            Route::post('/store/room/no/{id}', 'StoreRoomNumber')->name('store.room.no');

            // Room Edit Route
            Route::get('/edit/roomno/{id}', 'EditRoomNumber')->name('edit.roomno');

            // Update Room Data route 
            Route::post('/update/roomno/{id}', 'UpdateRoomNumber')->name('update.roomno');

            // Room Delete Number
            Route::get('/delete/roomno/{id}', 'DeleteRoomNumber')->name('delete.roomno');

            // Delete Room From RoomType List Page
            Route::get('/delete/room/{id}', 'DeleteRoom')->name('delete.room');

        });




        // Admin Booking All Route
        Route::controller(BookingController::class)->group(function(){

            // Booking Page Route 
            Route::get('/booking/list', 'BookingList')->name('booking.list');

            // Edit Booking Page Route 
            Route::get('/edit_booking/{id}', 'EditBooking')->name('edit_booking');

            // Booking Update Route On edit_booking page
            Route::post('/update/booking/status/{id}', 'UpdateBookingStatus')->name('update.booking.status');

            // Manage Room and Date Route On edit_booking page
            Route::post('/update/booking/{id}', 'UpdateBooking')->name('update.booking');

            // Assign Room Route
            Route::get('/assign_room/{id}', 'AssignRoom')->name('assign_room');

            // Route Assign Room into edit Booking Page
            Route::get('/assign_room/store/{booking_id}/{room_number_id}', 'AssignRoomStore')->name('assign_room_store');

            // Delete Assigned room in Edit Booking Page Route
            Route::get('/assign_room_delete/{id}', 'AssignRoomDelete')->name('assign_room_delete');

            // Download invoice Route on edit_booking page
            Route::get('/download/invoice/{id}', 'DownloadInvoice')->name('download.invoice');


        });


        // Admin Room List All Route
        Route::controller(RoomListController::class)->group(function(){

        // view All Rooms Avaliable in the Hotel Route on View_room_list 
        Route::get('/view/room/list', 'ViewRoomList')->name('view.room.list');

        // Add Room From Admin Dashboard From view_room_list Page
        Route::get('/add/room/list', 'AddRoomList')->name('add.room.list');

        // Store Room Data from the view_room_list Page Route
        Route::post('/store/roomlist', 'StoreRoomList')->name('store.room.list');

    });    


        // Admin STMT Setting All Route
        Route::controller(SettingController::class)->group(function(){

            // Smtp Setting View Route on smtp_update Page 
            Route::get('/smtp/setting', 'SmtpSetting')->name('smtp.setting');

            // Update Smtp Values
            Route::post('/smtp/update', 'SmtpUpdate')->name('smtp.update');


        }); 

        // Testimonial All Route
        Route::controller(TestimonialController::class)->group(function(){

            // All Testimonial Page
            Route::get('/all/testimonial', 'AllTestimonial')->name('all.testimonial');

            // Add Testimonial Route View Page
            Route::get('/add/testimonial', 'AddTestimonial')->name('add.testimonial');

            // Store Testimonial Route View Page
            Route::post('/store/testimonial', 'StoreTestimonial')->name('testimonial.store');

            // Edit Testimonial Route View Page
            Route::get('/edit/testimonial/{id}', 'EditTestimonial')->name('edit.testimonial');

            // Update Testimonial Route View Page
            Route::post('/update/testimonial', 'UpdateTestimonial')->name('testimonial.update');

            // Delete Testimonial Route View Page
            Route::get('/delete/testimonial/{id}', 'DeleteTestimonial')->name('delete.testimonial');

        });    


        // BlogCategory All Route
        Route::controller(BlogController::class)->group(function(){

            // All Blog Category Route Page
            Route::get('/blog/category', 'BlogCategory')->name('blog.category');

            // Store Blog Category Route Page
            Route::post('/store/blog/category', 'StoreBlogCategory')->name('store.blog.category');

            // Edit Blog Category Route
            Route::get('/edit/blog/category/{id}', 'EditBlogCategory');

            // Update Blog Category Route Page
            Route::post('/update/blog/category', 'UpdateBlogCategory')->name('update.blog.category');

            // Delete Blogcategory
            Route::get('/delete/blog/category/{id}', 'DeleteBlogCategory')->name('delete.blog.category');
            
        });



        // Blog Post All Route
        Route::controller(BlogController::class)->group(function(){

            // All Blog Post Route at all_post Page
            Route::get('/all/blog/post', 'AllBlogPost')->name('all.blog.post');

            // Add Blog Post Route on add_post
            Route::get('/add/blog/post', 'AddBlogPost')->name('add.blog.post');

            // Store Blog Post Route on add_post
            Route::post('/store/blog/post', 'StoreBlogPost')->name('store.blog.post');

            // Edit Blog Post Route on all_post
            Route::get('/edit/blog/post/{id}', 'EditBlogPost')->name('edit.blog.post');

             // Update Blog Post Route on all_post
             Route::post('/update/blog/post', 'UpdateBlogPost')->name('update.blog.post');

            // Edit Blog Post Route on all_post
            Route::get('/delete/blog/post/{id}', 'DeleteBlogPost')->name('delete.blog.post');
           
            
        });

        // Comment All Route
        Route::controller(CommentController::class)->group(function(){

            // All comment route
            Route::get('/all/comment/', 'AllComment')->name('all.comment');

            // Update comment status using switcher
            Route::post('/update/comment/status', 'UpdateCommentStatus')->name('update.comment.status'); 
    
    
        });




        // Booking Report All Route
        Route::controller(ReportController::class)->group(function(){

            // All Booking Report route
            Route::get('/booking/report/', 'BookingReport')->name('booking.report');


            // Search Booking History Route
            Route::post('/search-by-date', 'SearchByDate')->name('search-by-date');
            
    
    
        });




        // Admin Site Setting All Route
        Route::controller(SettingController::class)->group(function(){

            // Site Setting View Route on smtp_update Page 
            Route::get('/site/setting', 'SiteSetting')->name('site.setting');

            // Update Site Status Data
            Route::post('/site/update', 'SiteUpdate')->name('site.update');


        }); 


        // Admin Gallery All Route
        Route::controller(GalleryController::class)->group(function(){

            // Gallery Route on smtp_update Page 
            Route::get('/all/gallery', 'AllGallery')->name('all.gallery');

            // Add Gallery Page Route
            Route::get('/add/gallery', 'AddGallery')->name('add.gallery');
    
            // Store Gallery Route 
            Route::post('/store/gallery', 'StoreGallery')->name('store.gallery');

            // Edit Gallery Page Route
            Route::get('/edit/gallery/{id}', 'EditGallery')->name('edit.gallery');

            // Update Gallery Route 
            Route::post('/update/gallery', 'UpdateGallery')->name('update.gallery');

            // Delete Gallery Route
            Route::get('/delete/gallery/{id}', 'DeleteGallery')->name('delete.gallery');

            // Delete Gallery multiple
            Route::post('/delete/gallery/multiple', 'DeleteGalleryMultiple')->name('delete.gallery.multiple');


        }); 



        // Admin Contact Controller All Route
        Route::controller(ContactController::class)->group(function(){

            // Contact message Admin View 
            Route::get('/contact/message', 'AdminContactMessage')->name('contact.message');

        }); 


        // Permission RoleController All Route
        Route::controller(RoleController::class)->group(function(){

            // All Roles page 
            Route::get('/all/permission', 'AllPermission')->name('all.permission');

            // Add Peermission Route on all_permission_page
            Route::get('/add/permission', 'AddPermission')->name('add.permission');

            // Store Permission Route
            Route::post('/store/permission', 'StorePermission')->name('store.permission');

            // Edit Permission Route
            Route::get('/edit/permission/{id}', 'EditPermission')->name('edit.permission');

            // Update Permission Route
            Route::post('/update/permission/', 'UpdatePermission')->name('update.permission');

            // Delete Permission Route
            Route::get('/delete/permission/{id}', 'DeletePermission')->name('delete.permission');

            // Import Permission Route
            Route::get('/import/permission', 'ImportPermission')->name('import.permission');

            // Export Route from import_permission page
            Route::get('/export', 'Export')->name('export');

            // Import Route from import_permission page
            Route::post('/import', 'Import')->name('import');

        }); 




        // Role RoleController All Route
        Route::controller(RoleController::class)->group(function(){

            // Contact message Admin View 
            Route::get('/all/roles', 'AllRoles')->name('all.roles');

            // Add Roles Route on all_roles_page
            Route::get('/add/roles', 'AddRoles')->name('add.roles');

            // Store Roles Route
            Route::post('/store/roles', 'StoreRoles')->name('store.roles');

            // Edit Roles Route
            Route::get('/edit/roles/{id}', 'EditRoles')->name('edit.roles');

            // Update Roles Route
            Route::post('/update/roles/', 'UpdateRoles')->name('update.roles');

            // Delete Roles Route
            Route::get('/delete/roles/{id}', 'DeleteRoles')->name('delete.roles');


            // New Routes For Role In Permissions

            // Role in Permission Route 
            Route::get('/add/roles/permission', 'AddRolesPermission')->name('add.roles.permission');


            // Role Permission Store route
            Route::post('/role/permission/store', 'RolePermissionStore')->name('role.permission.store');

            // All Role in Permission Route 
            Route::get('/all/roles/permission', 'AllRolesPermission')->name('all.roles.permission');

            // Edit Role in Permission Route 
            Route::get('/admin/edit/roles/{id}', 'AdminEditRoles')->name('admin.edit.roles');

            // Update Role Permission Store route
            Route::post('/admin/roles/update/{id}', 'AdminRolesUpdate')->name('admin.roles.update');

            // Delete Role Permission Route
            Route::get('admin/delete/roles/{id}', 'AdminDeleteRoles')->name('admin.delete.roles');


        }); 

        // Admin User Controller All Route
        Route::controller(AdminController::class)->group(function(){

            // All Admin User Route 
            Route::get('/all/admin', 'AllAdmin')->name('all.admin');

            // Add Admin User Route
            Route::get('/add/admin', 'AddAdmin')->name('add.admin');

            // Store Admin User Route
            Route::post('/store/admin', 'StoreAdmin')->name('store.admin');

            // Edit Admin User Route
            Route::get('/edit/admin/{id}', 'EditAdmin')->name('edit.admin');

            // Update Admin User Route
            Route::post('/update/admin/{id}', 'UpdateAdmin')->name('update.admin');

            // Delete Admin User Route
            Route::get('/delete/admin/{id}', 'DeleteAdmin')->name('delete.admin');

        }); 




    }); // End Admin Group Middleware



     /// Frontend Blog  All Route 
    Route::controller(BlogController::class)->group(function(){

        Route::get('/blog/details/{slug}', 'BlogDetails');

        Route::get('/blog/cat/list/{id}', 'BlogCatList');

        // Blog list route for navbar menu
        Route::get('/blog', 'BlogList')->name('blog.list');

    });



    /// Frontend Comment on Blog Detail Page All Route 
        Route::controller(CommentController::class)->group(function(){

        Route::post('/store/comment/', 'StoreComment')->name('store.comment');


    });




    /// Frontend Gallery  All Route 
    Route::controller(GalleryController::class)->group(function(){

        Route::get('/gallery', 'ShowGallery')->name('show.gallery');


    });




    // FrontendRoomController All Route
    Route::controller(FrontendRoomController::class)->group(function(){


        // All Room route
        Route::get('/rooms/', 'AllFrontendRoomList')->name('froom.all');

        // Room- Detail route for single page
        Route::get('/room/details/{id}', 'RoomDetailsPage');

        // Booking Route for the form
        Route::get('bookings', 'BookingSearch')->name('booking.search');

        // Search Book Page to room-details route
        Route::get('/search/room/details/{id}', 'SearchRoomDetails')->name('search_room_details');

        // Route for check room availability
        Route::get('/check_room_availability', 'CheckRoomAvailability')->name('check_room_availability');

    });





    // Contact Controller All Route
    Route::controller(ContactController::class)->group(function(){

        // All Contact Controller All Route
        Route::get('/contact', 'ContactUs')->name('contact.us');

        // Store Contact Form Route
        Route::post('/store/contact', 'StoteContactUs')->name('store.contact');
    });






// Auth Middleware User must have login for access this route
Route::middleware(['auth'])->group(function(){

    // Checkout All Route
    Route::controller(BookingController::class)->group(function(){


        // Checkout route to checkout page
        Route::get('/checkout/', 'Checkout')->name('checkout');

        // User booking Store route
        Route::post('/booking/store/', 'BookingStore')->name('user_booking_store');

        // Store Checkout Form Data
        Route::post('/checkout/store/', 'CheckoutStore')->name('checkout.store');

        // Payment Route
        Route::match(['get', 'post'],'/stripe_pay', [BookingController::class, 'stripe_pay'])->name('stripe_pay');
      


        ///// User Booking Route

        // Route for the froentend usr booking 
        Route::get('/user/booking', 'UserBooking')->name('user.booking');

        // Use invoice Route on user_booking
        Route::get('user/invoice/{id}', 'UserInvoice')->name('user.invoice');

    });


}); // End Group Auth Middleware


    // Notification All Route in Booking Controller
    Route::controller(BookingController::class)->group(function(){

        Route::post('/mark-notification-as-read/{notification}', 'MarkAsRead');
    
    
    });
