<?php

use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    return view('welcome');
});

Route::prefix('monsite')
    ->middleware(['auth'])
    ->group(function() {
        Route::prefix('/actu')->group(function () {
            Route::get('/', [\App\Http\Controllers\Actu\ActuMonSiteController::class, 'index'])->name('monsite.actu.index');
            Route::get('/categories', [\App\Http\Controllers\Actu\ActuMonSiteController::class, 'categories']);
            Route::get('/api', [\App\Http\Controllers\Actu\ActuMonSiteController::class, 'indexApi']);

            Route::get('/create', [\App\Http\Controllers\Actu\ActuMonSiteController::class, 'create'])->name('monsite.actu.create');
            Route::post('/', [\App\Http\Controllers\Actu\ActuMonSiteController::class, 'store'])->name('monsite.actu.store');

            Route::get('/updatestate/{actu}', [\App\Http\Controllers\Actu\ActuMonSiteController::class, 'updateState']);
        });

        Route::prefix('/avis')->group(function () {
            Route::get('/', [\App\Http\Controllers\Avis\AvisMonSiteController::class, 'index'])->name('monsite.avis.index');
            Route::get('/api', [\App\Http\Controllers\Avis\AvisMonSiteController::class, 'indexApi']);
            Route::get('/api/{id}', [\App\Http\Controllers\Avis\AvisMonSiteController::class, 'show'])->name('monsite.avis.show');
            Route::put('/api/{id}', [\App\Http\Controllers\Avis\AvisMonSiteController::class, 'update'])->name('monsite.avis.update');
            Route::delete('/{id}', [\App\Http\Controllers\Avis\AvisMonSiteController::class, 'destroy']);
            Route::get('/edit/{id}', [\App\Http\Controllers\Avis\AvisMonSiteController::class, 'edit'])->name('monsite.avis.edit');
            Route::get('/updatestate/actif/{id}', [\App\Http\Controllers\Avis\AvisMonSiteController::class, 'actif']);
            Route::get('/updatestate/inactif/{id}', [\App\Http\Controllers\Avis\AvisMonSiteController::class, 'inactif']);
            Route::get('/updatestate/{id}', [\App\Http\Controllers\Avis\AvisMonSiteController::class, 'activite']);
            Route::post('/', [\App\Http\Controllers\Avis\AvisMonSiteController::class, 'store'])->name('monsite.avis.store');

            //Route::resource('toto','\App\Http\Controllers\Avis\AvisMonSiteController::class' );
        });
    });

Route::group(['middleware' => 'auth'], function () {
    Route::get('tasks', [\App\Http\Controllers\Kanban\TaskController::class, 'index'])->name('tasks.index');
    Route::post('tasks', [\App\Http\Controllers\Kanban\TaskController::class, 'store'])->name('tasks.store');
    Route::put('tasks/sync/{task}', [\App\Http\Controllers\Kanban\TaskController::class, 'sync'])->name('tasks.sync');
    Route::put('tasks/{task}', [\App\Http\Controllers\Kanban\TaskController::class, 'update'])->name('tasks.update');
});

Route::group(['middleware' => 'auth'], function () {
    Route::post('statuses', [\App\Http\Controllers\Kanban\StatusController::class, 'store'])->name('statuses.store');
    Route::put('statuses', [\App\Http\Controllers\Kanban\StatusController::class, 'update'])->name('statuses.update');
});

Route::get('/monsite/kanban/api', [\App\Http\Controllers\Kanban\StatusController::class, 'show'])->name('statuses.show');
Route::get('/monsite/kanban/api/task', [\App\Http\Controllers\Kanban\TaskController::class, 'show'])->name('tasks.show');
Route::get('/monsite/kanban/api/task/{id}', [\App\Http\Controllers\Kanban\TaskController::class, 'showTask'])->name('tasks.showtask');


Route::get("/monsite/test", [\App\Http\Controllers\Form\MailController::class, 'formtest']);
Route::post("/monsite/test/envoie", [\App\Http\Controllers\Form\MailController::class, 'envoie'])->name('form.envoie');

//Route::get('/monsite/form', [\App\Http\Controllers\Form\FormController::class, 'index'])->name('form.index');
//Route::post('/monsite/form', [\App\Http\Controllers\Form\FormController::class, 'envoieMail'])->name('form.store');

Route::get("/monsite/form", [\App\Http\Controllers\Form\MailController::class, 'formMessageGoogle']);
Route::get("/monsite/2016", [\App\Http\Controllers\Form\MailController::class, 'seize'])->name('seize');
Route::get("/monsite/2017", [\App\Http\Controllers\Form\MailController::class, 'dixsept'])->name('dixsept');
Route::get("/monsite/2018", [\App\Http\Controllers\Form\MailController::class, 'dixhuit'])->name('dixhuit');
Route::get("/monsite/2019", [\App\Http\Controllers\Form\MailController::class, 'dixneuf'])->name('dixneuf');
Route::get("/monsite/2020", [\App\Http\Controllers\Form\MailController::class, 'vingt'])->name('vingt');
Route::get("/monsite/2021", [\App\Http\Controllers\Form\MailController::class, 'vingtun'])->name('vingtun');
Route::get("/monsite/2022", [\App\Http\Controllers\Form\MailController::class, 'vingtdeux'])->name('vingtdeux');


//Route::post("/monsite/form", [\App\Http\Controllers\Form\MailController::class, 'sendMessageGoogle'])->name('send.message.google');
Route::get("/monsite/form/api", [\App\Http\Controllers\Form\FormController::class, 'fichierPHP'])->name('form.fichierJSON');
Route::post("/monsite/form/encrypt", [\App\Http\Controllers\Form\FormController::class, 'fichierTXT'])->name('form.fichierTXT');
Route::post("/monsite/form/ping", [\App\Http\Controllers\Form\FormController::class, 'ping'])->name('form.ping');
Route::post("/monsite/form/httpd", [\App\Http\Controllers\Form\FormController::class, 'fichierHttpd'])->name('form.fichierHttpd');
Route::post("/monsite/form/pinghttpd", [\App\Http\Controllers\Form\FormController::class, 'pinghttpd'])->name('form.pinghttpd');

Route::post("/monsite/cours/api", [\App\Http\Controllers\Form\CalendarController::class, 'store'])->name('calendar.store');
Route::get("/monsite/cours/api", [\App\Http\Controllers\Form\CalendarController::class, 'indexApi'])->name('calendar.indexApi');
Route::put("/monsite/cours/{cours}", [\App\Http\Controllers\Form\CalendarController::class, 'update'])->name('calendar.update');
Route::get("/monsite/cours/{cours}", [\App\Http\Controllers\Form\CalendarController::class, 'show'])->name('calendar.show');
Route::delete('/monsite/cours/{cours}', [\App\Http\Controllers\Form\CalendarController::class, 'destroy'])->name('calendar.destroy');
Route::post("/monsite/cours", [\App\Http\Controllers\Form\MailController::class, 'sendMessageGoogle'])->name('send.message.google');

//branche4

Route::get("/monsite/tree", [\App\Http\Controllers\TreeController::class, 'index'])->name('tree.index');


//Branche dragula :

Route::get('dragula', [\App\Http\Controllers\OrdreController::class, 'index'])->name('dragula.index');
Route::put('ordre', [\App\Http\Controllers\OrdreController::class, 'update'])->name('dragula.update');



Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

