<?php
declare(strict_types=1);

namespace App\Libraries\Types;

use App\Libraries\Types\CongregationContactInformation;
use App\Libraries\Types\CongregationType;

class Congregation {

    public string $Congregation_id; // A unique identifier for each congregation (Primary Key).
    public string $name; // The official name of the congregation.
    public string $country; // The country in which the congregation is located.
    public string $state_or_province; // Depending on the country, this could be a state, province, or equivalent region.
    public string $city_or_town; // The city or town where the congregation is based.
    public string $address; // A more specific location within the city or town, could include street address, postal code, etc.
    public string $language; // The primary language(s) used by the congregation.
    public CongregationContactInformation $contact; // Could include a primary contact number, email address, or other relevant contact details.
    public CongregationType $type; // This could refer to the type of congregation based on size, denomination, or other characteristics.
    public string $registration_date; // The date when the congregation was established or registered in your system.

    public function __construct() {}
}