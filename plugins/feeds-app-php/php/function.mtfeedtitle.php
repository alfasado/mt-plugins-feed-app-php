<?php
function smarty_function_mtfeedtitle ( $args, $ctx ) {
    $xml_object = $ctx->stash( 'xml_object' );
    if (! $xml_object ) return '';
    $xml_format = $ctx->stash( 'xml_format' );
    $to_encoding = $ctx->stash( 'to_encoding' );
    $feedtitle = '';
    if ( $xml_format == 'ATOM' ) {
        $feedtitle = $ctx->stash( 'feedtitle' );
    } elseif ( $xml_format == 'RSS' ) {
        $feedtitle = $xml_object->channel->title;
    }
    $from_encoding = mb_detect_encoding( $feedtitle,'UTF-8,EUC-JP,SJIS,JIS' );
    return mb_convert_encoding( $feedtitle, $to_encoding, $from_encoding );
}
?>