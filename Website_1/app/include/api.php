<?php
function getBTCPrice()
{
    $url='https://bitpay.com/api/rates';
    $json=json_decode( file_get_contents( $url ));
    $rub=$btc=0;

    foreach( $json as $obj )
    {
        if( $obj->code=='USD' )$btc=$obj->rate;
        if( $obj->code=='RUB' )$rub=$obj->rate;
    }

    return "1 BTC=<i class=\"fas fa-dollar-sign\"></i>" . $btc . " <i class=\"fas fa-ruble-sign\"></i>" . $rub;
}
function convertToBTCFromSatoshi($value)
{
    return;
    return number_format(($value)*(pow(10, -8)), 8, '.', '');
    //return bcdiv( intval($value), 100000000, 8 );
}
function getRub()
{
    return;
    $url='https://bitpay.com/api/rates';
    $json=json_decode( file_get_contents( $url ));
    $rub=$btc=0;

    foreach( $json as $obj )
    {
        if( $obj->code=='RUB' )$rub=$obj->rate;
    }
    return $rub;
}
?>