<?php
function smarty_function_mtfeedentrylink ( $args, $ctx ) {
    $xml_object = $ctx->stash( 'xml_object' );
    if (! $xml_object ) return '';
    $feedentry = $ctx->stash( 'feedentry' );
    $xml_format = $ctx->stash( 'xml_format' );
    $to_encoding = $ctx->stash( 'to_encoding' );
    $feedentrylink = '';
    if ( $feedentry ) {
        if ( $xml_format == 'ATOM' ) {
            foreach ( $feedentry->link as $link ) {
                switch ( $link->attributes()->rel ) {
                    case 'alternate':
                        $feedentrylink = $link->attributes()->href;
                        break;
                }
            }
        } elseif ( $xml_format == 'RSS' ) {
            $feedentrylink = $feedentry->link;
        }
    }
    $from_encoding = mb_detect_encoding( $feedentrylink,'UTF-8,EUC-JP,SJIS,JIS' );
    return mb_convert_encoding( $feedentrylink, $to_encoding, $from_encoding );
}
?>