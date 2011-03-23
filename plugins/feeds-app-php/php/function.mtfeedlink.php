<?php
function smarty_function_mtfeedlink ( $args, $ctx ) {
    $xml_object = $ctx->stash( 'xml_object' );
    if (! $xml_object ) return '';
    $xml_format = $ctx->stash( 'xml_format' );
    $to_encoding = $ctx->stash( 'to_encoding' );
    $feedlink = '';
    if ( $xml_format == 'ATOM' ) {
        foreach ( $xml_object->link as $link ) {
            switch ( $link->attributes()->rel ) {
                case 'alternate':
                $feedlink = $link->attributes()->href;
                break;
            }
        }
    } elseif ( $xml_format == 'RSS' ) {
        $feedlink = $xml_object->channel->link;
    }
    $from_encoding = mb_detect_encoding( $feedlink,'UTF-8,EUC-JP,SJIS,JIS' );
    return mb_convert_encoding( $feedlink, $to_encoding, $from_encoding );
}
?>