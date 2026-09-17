<?php

namespace App\Http\Controllers\Api\Patient;

use App\Http\Controllers\Api\PatientProfileController as BasePatientProfileController;

/**
 * Re-export PatientProfileController ke namespace Patient
 * agar routes/api.php import Patient\PatientProfileController berfungsi.
 */
class PatientProfileController extends BasePatientProfileController
{
    //
}
