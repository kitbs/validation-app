<?php

/**
 * Bban Validator
 *
 * Syntax: bban
 */

Validator::extend('bban', function($attribute, $value, $parameters, $validator) {
    try {
        return \IsoCodes\Bban::validate($value);
    }
    catch (\Exception $e) { return false; }
});

/**
 * Cif Validator
 *
 * Syntax: cif
 */

Validator::extend('cif', function($attribute, $value, $parameters, $validator) {
    try {
        return \IsoCodes\Cif::validate($value);
    }
    catch (\Exception $e) { return false; }
});

/**
 * Credit Card Validator
 *
 * Syntax: credit_card
 */

Validator::extend('credit_card', function($attribute, $value, $parameters, $validator) {
    try {
        return \IsoCodes\CreditCard::validate($value);
    }
    catch (\Exception $e) { return false; }
});

/**
 * Ean 13 Validator
 *
 * Syntax: ean13
 */

Validator::extend('ean13', function($attribute, $value, $parameters, $validator) {
    try {
        return \IsoCodes\Ean13::validate($value);
    }
    catch (\Exception $e) { return false; }
});

/**
 * Ean 8 Validator
 *
 * Syntax: ean8
 */

Validator::extend('ean8', function($attribute, $value, $parameters, $validator) {
    try {
        return \IsoCodes\Ean8::validate($value);
    }
    catch (\Exception $e) { return false; }
});

/**
 * Gtin 12 Validator
 *
 * Syntax: gtin12
 */

Validator::extend('gtin12', function($attribute, $value, $parameters, $validator) {
    try {
        return \IsoCodes\Gtin12::validate($value);
    }
    catch (\Exception $e) { return false; }
});

/**
 * Gtin 13 Validator
 *
 * Syntax: gtin13
 */

Validator::extend('gtin13', function($attribute, $value, $parameters, $validator) {
    try {
        return \IsoCodes\Gtin13::validate($value);
    }
    catch (\Exception $e) { return false; }
});

/**
 * Gtin 14 Validator
 *
 * Syntax: gtin14
 */

Validator::extend('gtin14', function($attribute, $value, $parameters, $validator) {
    try {
        return \IsoCodes\Gtin14::validate($value);
    }
    catch (\Exception $e) { return false; }
});

/**
 * Gtin 8 Validator
 *
 * Syntax: gtin8
 */

Validator::extend('gtin8', function($attribute, $value, $parameters, $validator) {
    try {
        return \IsoCodes\Gtin8::validate($value);
    }
    catch (\Exception $e) { return false; }
});

/**
 * Iban Validator
 *
 * Syntax: iban
 */

Validator::extend('iban', function($attribute, $value, $parameters, $validator) {
    try {
        return \IsoCodes\Iban::validate($value);
    }
    catch (\Exception $e) { return false; }
});

/**
 * Insee Validator
 *
 * Syntax: insee
 */

Validator::extend('insee', function($attribute, $value, $parameters, $validator) {
    try {
        return \IsoCodes\Insee::validate($value);
    }
    catch (\Exception $e) { return false; }
});

/**
 * Isbn Validator
 *
 * Syntax: isbn:type
 */

Validator::extend('isbn', function($attribute, $value, $parameters, $validator) {
    try {
        return \IsoCodes\Isbn::validate($value, @$parameters[0]);
    }
    catch (\Exception $e) { return false; }
});

/**
 * Isin Validator
 *
 * Syntax: isin
 */

Validator::extend('isin', function($attribute, $value, $parameters, $validator) {
    try {
        return \IsoCodes\Isin::validate($value);
    }
    catch (\Exception $e) { return false; }
});

/**
 * Mac Validator
 *
 * Syntax: mac
 */

Validator::extend('mac', function($attribute, $value, $parameters, $validator) {
    try {
        return \IsoCodes\Mac::validate($value);
    }
    catch (\Exception $e) { return false; }
});

/**
 * Nif Validator
 *
 * Syntax: nif
 */

Validator::extend('nif', function($attribute, $value, $parameters, $validator) {
    try {
        return \IsoCodes\Nif::validate($value);
    }
    catch (\Exception $e) { return false; }
});

/**
 * Phone Number Validator
 *
 * Syntax: phone:country=null
 */

Validator::extend('phone', function($attribute, $value, $parameters, $validator) {
    try {
        return \IsoCodes\PhoneNumber::validate($value, @$parameters[0] ?: null);
    }
    catch (\Exception $e) { return false; }
});

/**
 * Sedol Validator
 *
 * Syntax: sedol
 */

Validator::extend('sedol', function($attribute, $value, $parameters, $validator) {
    try {
        return \IsoCodes\Sedol::validate($value);
    }
    catch (\Exception $e) { return false; }
});

/**
 * Siren Validator
 *
 * Syntax: siren:length=null
 */

Validator::extend('siren', function($attribute, $value, $parameters, $validator) {
    try {
        return \IsoCodes\Siren::validate($value, @$parameters[0] ?: null);
    }
    catch (\Exception $e) { return false; }
});

/**
 * Siret Validator
 *
 * Syntax: siret:length=null
 */

Validator::extend('siret', function($attribute, $value, $parameters, $validator) {
    try {
        return \IsoCodes\Siret::validate($value, @$parameters[0] ?: null);
    }
    catch (\Exception $e) { return false; }
});

/**
 * Sscc Validator
 *
 * Syntax: sscc
 */

Validator::extend('sscc', function($attribute, $value, $parameters, $validator) {
    try {
        return \IsoCodes\Sscc::validate($value);
    }
    catch (\Exception $e) { return false; }
});

/**
 * Ssn Validator
 *
 * Syntax: ssn
 */

Validator::extend('ssn', function($attribute, $value, $parameters, $validator) {
    try {
        return \IsoCodes\Ssn::validate($value);
    }
    catch (\Exception $e) { return false; }
});

/**
 * Swift Bic Validator
 *
 * Syntax: swift_bic
 */

Validator::extend('swift_bic', function($attribute, $value, $parameters, $validator) {
    try {
        return \IsoCodes\SwiftBic::validate($value);
    }
    catch (\Exception $e) { return false; }
});

/**
 * National Insurance Number Validator
 *
 * Syntax: uk_nin
 */

Validator::extend('uk_nin', function($attribute, $value, $parameters, $validator) {
    try {
        return \IsoCodes\Uknin::validate($value);
    }
    catch (\Exception $e) { return false; }
});

/**
 * Upca Validator
 *
 * Syntax: upca
 */

Validator::extend('upca', function($attribute, $value, $parameters, $validator) {
    try {
        return \IsoCodes\Upca::validate($value);
    }
    catch (\Exception $e) { return false; }
});

/**
 * Vat Validator
 *
 * Syntax: vat
 */

Validator::extend('vat', function($attribute, $value, $parameters, $validator) {
    try {
        return \IsoCodes\Vat::validate($value);
    }
    catch (\Exception $e) { return false; }
});

/**
 * postal code Validator
 *
 * Syntax: postcode:country=null
 */

Validator::extend('postcode', function($attribute, $value, $parameters, $validator) {
    try {
        return \IsoCodes\ZipCode::validate($value, @$parameters[0] ?: null);
    }
    catch (\Exception $e) { return false; }
});