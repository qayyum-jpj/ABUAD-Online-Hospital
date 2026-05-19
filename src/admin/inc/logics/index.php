<?php

# metric logics
$administratorCnt = intval(cntRows('administrators',"id",null));
$activeAdministratorCnt = intval(cntRows('administrators',"id","status='active'"));
$inactiveAdministratorCnt = intval(cntRows('administrators',"id","status<>'active'"));

$userCnt = intval(cntRows('users',"id","role='doctor'"));
$activeUserDocCnt = intval(cntRows('users',"id","role='doctor'"));
$activeUserPatCnt = intval(cntRows('users',"id","role<>'doctor'"));

$genderCnt = intval(cntRows('genders',"id",null));
$activeGenderCnt = intval(cntRows('genders',"id","status='active'"));
$inactiveGenderCnt = intval(cntRows('genders',"id","status<>'active'"));

// $countryCnt = intval(cntRows('countries',"id",null));
// $activeCountryCnt = intval(cntRows('countries',"id","status='active'"));
// $inactiveCountryCnt = intval(cntRows('countries',"id","status<>'active'"));
