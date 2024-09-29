<?php

use App\Functions\Core;
use Illuminate\Support\Facades\Route;

require __DIR__ . '/guest.php';
require __DIR__ . '/company.php';
require __DIR__ . '/setting.php';

require __DIR__ . '/core.php';
require __DIR__ . '/auth.php';
require __DIR__ . '/user.php';
require __DIR__ . '/profile.php';


require __DIR__ . '/restriction.php';
require __DIR__ . '/agency.php';
require __DIR__ . '/client.php';

require __DIR__ . '/reminder.php';
require __DIR__ . '/vehicle.php';

require __DIR__ . '/reservation.php';
require __DIR__ . '/recovery.php';
require __DIR__ . '/payment.php';
require __DIR__ . '/charge.php';
require __DIR__ . '/ticket.php';


function array_flatten($array)
{
    $result = [];
    foreach ($array as $item) {
        if (is_array($item)) {
            $result = array_merge($result, array_flatten($item));
        } else {
            $result[] = $item;
        }
    }
    return $result;
}

Route::get(
    '/test',
    function () {
        $combined = [
            Core::genderList(),
            Core::statsList(),
            Core::registrationList(),
            Core::transmissionsList(),
            Core::reservationsList(),
            Core::identitiesList(),
            Core::methodsList(),
            array_values(Core::languagesList()),
            array_values(Core::currenciesList()),
            array_keys(Core::themesList()),
            Core::periodsList(),
            Core::unitsList(),
            Core::damagesList(),
            Core::insurancesList(),
            Core::fuelsList(),
            Core::horsepowersList(),
            Core::statuesList(),
            Core::categoriesList(),
            Core::citiesList(),
            Core::nationsList(),
            array_keys(Core::consumablesList()),
            array_values(Core::consumablesList()),
            ["pending", "completed", "January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December", "Sunday", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday", "Access denied"]
        ];

        $data = [];
        collect(array_flatten($combined))->each(function ($e) use (&$data) {
            if ((float)$e) return;
            $data[$e] = $e;
        });
        dd(json_encode($data));
    }
);
