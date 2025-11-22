<?php

use App\Http\Controllers\Admin\AjouteRecap;
use App\Http\Controllers\Admin\DivisionController;
use App\Http\Controllers\Admin\ServiceController;
use App\Http\Controllers\PusherController;
use App\Http\Controllers\Admin\DiscussionAdminController;
use App\Http\Controllers\Admin\FrontendControllerAdmin;
use App\Http\Controllers\Admin\GestionDemandeController;
use App\Http\Controllers\Admin\GestionUserController;
use App\Http\Controllers\Admin\NotificationController;
use App\Http\Controllers\Fonct\DemandeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Fonct\FrontendController;
use App\Http\Controllers\ProfileController as ControllersProfileController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Fonct\ConversationFonctionnaireController;
use App\Http\Controllers\NotificationMessageController;
use App\Http\Controllers\RefreshMessageController;
use App\Http\Controllers\DiscussionPublicController;
use App\Http\Controllers\GanttDemande;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

//Route::get('/', function () {
  //  return view('welcome');
//});




Auth::routes();

Route::group(['prefix'=>'admin','middleware' => ['auth','isAdmin']], function () {
    

    Route::get('dashboardadmin', [FrontendControllerAdmin::class, 'index'])->name('admin.dashboardadmin');
    Route::resource('profileadmin', ProfileController::class);
    Route::get('/userprofile/{id}', [ProfileController::class, 'showuserprofile'])->name('user.profile');
    Route::resource('users', GestionUserController::class);
    Route::resource('listdemandes', GestionDemandeController::class);
    Route::resource('recapadd', AjouteRecap::class);
    Route::resource('division', DivisionController::class);
    Route::resource('service', ServiceController::class);

    Route::post('/notifications/mark-as-read/{id}', [NotificationController::class, 'markAsRead']);


    Route::get('conversations', [DiscussionAdminController::class, 'index'])->name('conversations.index');
    Route::get('conversations/{user}', [DiscussionAdminController::class, 'show'])->name('conversations.show');
    Route::post('/conversations/create/{user}', [DiscussionAdminController::class, 'createConversation'])->name('conversations.create');
    Route::post('conversations/{conversation}/message', [DiscussionAdminController::class, 'storeMessage'])->name('conversations.storeMessage');
    Route::get('/conversationstest/{user}', [DiscussionAdminController::class, 'getMessages'])->name('conversations.getMessages');
    Route::get('/user-statuses', [DiscussionAdminController::class, 'getUserStatuses'])->name('user.statuses');
    //filtrage user par age 
    Route::get('/users/age/filter', [GestionUserController::class, 'filterByAge'])->name('users.age.filter');
    //route excel
    Route::get('demande/exportword/{id}', [GestionDemandeController::class, 'exportword'])->name('demande/exportword');
    
    
    
 });

 Route::group(['prefix'=>'fonctionnaire','middleware' => ['auth','isFonctionnaire']], function () {
    

    Route::get('dashboard', [FrontendController::class,'index'])->name('fonctionnaire.dashboard');
    Route::resource('profile', ProfileController::class);

    //gestion du demande

    Route::resource('demandes', DemandeController::class);

    //conversations for fonctionnaire and admin RH
    Route::get('conversations', [ConversationFonctionnaireController::class, 'show'])->name('fonctionnaire.conversations.show');
    Route::post('conversations/{conversation}/message', [ConversationFonctionnaireController::class, 'storeMessage'])->name('fonctionnaire.conversations.storeMessage');
    Route::get('/conversationstest', [ConversationFonctionnaireController::class, 'getMessages'])->name('fonctionnaire.conversations.getMessages');
    //export word
    Route::get('demande/word_export/{id}', [DemandeController::class,'WordExport'])->name('demande/word_export');

 });

 Route::group(['middleware' => ['auth']], function () {
    Route::resource('notifications', NotificationController::class);
    Route::get('chat', [PusherController::class, 'index'])->name('chat');
    Route::post('/broadcast', [PusherController::class, 'broadcast']);
    Route::post('/receive', [PusherController::class, 'receive']);
    //notificaion messages
    Route::post('/notifications/mark-as-read/{id}', [NotificationMessageController::class, 'markAsRead']);
    Route::get('/notifications/redirect/{id}', [NotificationMessageController::class, 'redirectNotification'])->name('notifications.redirect');    
    //refresh page
    Route::get('/check-new-messages', [RefreshMessageController::class, 'checkNewMessages'])->name('check.new.messages');

    //notifications
    // routes/web.php
    Route::get('/notifications/get', [NotificationController::class, 'getNotifications'])->name('newnotifications');

//navbar notifications
    Route::get('/notifications/get-notifications', [NotificationController::class, 'getNotificationsDemandes'])->name('notifications.getNotifications');

//messages public
    Route::get('chat', [DiscussionPublicController::class, 'index'])->name('message.index');
    Route::post('/send-message', [DiscussionPublicController::class, 'storeMessage'])->name('message.storeMessage');
    Route::get('/get-messages', [DiscussionPublicController::class, 'getMessages'])->name('message.getMessages');
    //try notification rell time
    Route::post('/notifyMessage', [NotificationController::class, 'notifyMessage']);


    Route::get('gantt/export', [GanttDemande::class, 'generateGanttChart'])->name('gantt.export');
    //check user status
    Route::get('/user-status/{id}', [DiscussionAdminController::class, 'getUserStatus'])->name('user.status');
});
use App\Http\Controllers\SocialAuthController;

Route::get('auth/google', [SocialAuthController::class, 'redirectToGoogle']);
Route::get('auth/google/callback', [SocialAuthController::class, 'handleGoogleCallback']);
// routes/web.php
use App\Http\Controllers\AbsenceController;

Route::get('/absences', [AbsenceController::class, 'showAbsences'])->name('absences.show');

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');





use App\Http\Controllers\Home\AccueilController;
use App\Http\Controllers\Home\ContactController;
use App\Http\Controllers\Home\NewsController;
use App\Http\Controllers\Home\AboutUsController;
use App\Http\Controllers\Home\EventController;
use App\Http\Controllers\Home\WeatherController;
Route::get('/', [AccueilController::class, 'index'])->name('accueil');

Route::get('/contact', [ContactController::class, 'index'])->name('contact');


    Route::get('/news', [NewsController::class, 'index'])->name('news.index');
    Route::get('/news/events', [NewsController::class, 'events'])->name('news.events');
    Route::get('/news/journals', [NewsController::class, 'journals'])->name('news.journals');
    Route::get('/news/weather', [NewsController::class, 'weather'])->name('news.weather');
    //Route::get('/news/meteo', [NewsController::class, 'meteo'])->name('news.meteo');



    Route::get('/about', [AboutUsController::class, 'index'])->name('about.index');
    Route::get('/about/province-rhamna', [AboutUsController::class, 'provinceRhamna'])->name('about.provinceRhamna');
    Route::get('/about/directeur-rh', [AboutUsController::class, 'directeurRH'])->name('about.directeurRH');
    Route::get('/about/division-rh', [AboutUsController::class, 'divisionRH'])->name('about.divisionRH');
 //Route::get('/about/actualites/journaux', [NewsController::class, 'showJournaux'])->name('actualites.journaux');
//Route::get('/about/actualites/evenements', [EventController::class, 'showEvenements'])->name('actualites.evenements');
//Route::get('/about/actualites/meteo', [WeatherController::class, 'showMeteo'])->name('actualites.meteo');


/*se App\Http\Controllers\AIHelperController;

Route::get('/chat', [AIHelperController::class, 'showChat'])->name('chat.show');
Route::post('/chat/send', [AIHelperController::class, 'sendMessage'])->name('chat.send');*/

