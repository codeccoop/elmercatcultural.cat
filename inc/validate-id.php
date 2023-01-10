<?php
$DNI_REGEX = '/^(\d{8})([A-Z])$/';
$CIF_REGEX = '/^([ABCDEFGHJKLMNPQRSUVW])(\d{7})([0-9A-J])$/';
$NIE_REGEX = '/^[XYZ]\d{7,8}[A-Z]$/';

function elmercatcultural_validate_id($str)
{
    $str = preg_replace('/\s/', '', strtoupper($str));

    $valid = false;
    $type = elmercatcultural_id_type($str);

    switch ($type) {
        case 'dni':
            $valid = elmercatcultural_valid_dni($str);
            break;
        case 'nie':
            $valid = elmercatcultural_valid_nie($str);
            break;
    }

    return array(
        'type' => $type,
        'valid' => $valid
    );
};

function elmercatcultural_id_type($str)
{
    global $DNI_REGEX;
    global $NIE_REGEX;
    if (preg_match($DNI_REGEX, $str)) return 'dni';
    if (preg_match($NIE_REGEX, $str)) return 'nie';
}


function elmercatcultural_valid_dni($dni)
{
    $dni_letters = "TRWAGMYFPDXBNJZSQVHLCKE";
    $number = (int) substr($dni, 0, 8);
    $index = $number % 23;
    $letter = substr($dni_letters, $index, 1);

    return $letter == substr($dni, 8, 9);
}

function elmercatcultural_valid_nie($nie)
{
    $nie_prefix = substr($nie, 0, 1);

    switch ($nie_prefix) {
        case  'X':
            $nie_prefix = 0;
            break;
        case 'Y':
            $nie_prefix = 1;
            break;
        case 'Z':
            $nie_prefix = 2;
            break;
    }

    return elmercatcultural_valid_dni($nie_prefix . substr($nie, 1, 9));
}
