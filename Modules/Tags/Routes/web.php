<?php
use Illuminate\Support\Facades\Route;


/*
|================================================================================
|                             Back-END ROUTES
|================================================================================
*/
Route::prefix('dashboard')->middleware(['dashboard.auth', 'permission:dashboard_access'])->group(function () {

    /*foreach (File::allFiles(module_path('Tags', 'Routes/Dashboard')) as $file) {
        require_once($file->getPathname());
    }*/

    foreach (["tags.php"] as $value) {
        require_once(module_path('Tags', 'Routes/Dashboard/' . $value));
    }

});

/*
|================================================================================
|                             FRONT-END ROUTES
|================================================================================
*/
Route::prefix('/')->middleware('site.activation')->group(function () {

    /*foreach (File::allFiles(module_path('Tags', 'Routes/FrontEnd')) as $file) {
        require_once($file->getPathname());
    }*/

    foreach (["gifts.php"] as $value) {
        require_once(module_path('Tags', 'Routes/FrontEnd/' . $value));
    }

});
