<?php


/*
|================================================================================
|                             Back-END ROUTES
|================================================================================
*/
Route::prefix('dashboard')->middleware(['dashboard.auth', 'permission:dashboard_access'])->group(function () {

    /*foreach (File::allFiles(module_path('Authorization', 'Routes/Dashboard')) as $file) {
        require_once($file->getPathname());
    }*/

    foreach (["permissions.php", "roles.php"] as $value) {
        require_once(module_path('Authorization', 'Routes/Dashboard/' . $value));
    }

});
