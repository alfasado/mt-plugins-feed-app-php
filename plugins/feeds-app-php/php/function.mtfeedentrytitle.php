<?php
function smarty_function_mtfeedentrytitle ( $args, $ctx ) {
    $xml_object = $ctx->stash( 'xml_object' );
    if (! $xml_object ) return '';
    $feedentry = $ctx->stash( 'feedentry' );
    $to_encoding = $ctx->stash( 'to_encoding' );
    $feedentrytitle = $feedentry->title;
    $from_encoding = mb_detect_encoding( $feedentrytitle,'UTF-8,EUC-JP,SJIS,JIS' );
    return mb_convert_encoding( $feedentrytitle, $to_encoding, $from_encoding );
}
?>