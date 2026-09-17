<?php

namespace App\Http\Controllers\Api\Patient;

use App\Http\Controllers\Api\AppointmentController as BaseAppointmentController;

/**
 * Re-export AppointmentController ke namespace Patient
 * agar routes/api.php import Patient\AppointmentController berfungsi.
 */
class AppointmentController extends BaseAppointmentController
{
    //
}
