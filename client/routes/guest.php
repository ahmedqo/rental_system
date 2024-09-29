<?php

use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     return redirect()->route('views.login.index');
// });


Route::view('/', 'guest')->name('views.guest.index');

// use App\Models\Company;
// use App\Models\User;

// Route::get('/all', function () {
//     $all = file_get_contents(base_path('fr.json'), true);
//     $all = json_decode($all, true);
//     $rows_1 = [
//         'agencies' => 'Agency',
//         'clients' => 'Client',
//         'restrictions' => 'Restriction',
//         'vehicles' => 'Vehicle',
//         'charges' => 'Charge',
//         'reminders' => 'Reminder',
//         'reservations' => 'Reservation',
//     ];

//     $rows_2 = [
//         'payments' => 'payment',
//         'recoveries' => 'Recovery',
//     ];

//     foreach ($all as $company) {
//         $Company = Company::create($company);
//         $Company->Image()->create($company['image']);
//         foreach ($company['users'] as $user) {
//             $User = User::create($user);
//             $User->Setting()->create([
//                 'language' => 'fr',
//                 'currency' => 'MAD',
//                 'report_frequency' => 'week',
//                 'date_format' => 'YYYY-MM-DD',
//                 'theme_color' => 'ocean tide',
//             ]);
//         }

//         foreach ($rows_1 as $row => $model) {
//             foreach ($company[$row] as $item) {
//                 app('App\\Models\\' . $model)->create($item);
//             }
//         }
//     }

//     foreach ($all as $company) {
//         foreach ($rows_2 as $row => $model) {
//             foreach ($company[$row] as $item) {
//                 app('App\\Models\\' . $model)->create($item);
//             }
//         }
//     }

//     dd(Company::with('Image', 'Users', 'Agencies', 'Clients', 'Restrictions', 'Vehicles', 'Charges', 'Reminders', 'Reservations', 'Payments', 'Recoveries')->get());
// });
