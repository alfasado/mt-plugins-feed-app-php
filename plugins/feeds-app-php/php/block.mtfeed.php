<?php
function smarty_block_mtfeed ( $args, $content, &$ctx, &$repeat ) {
    $localvars = array( 'xml_object', 'feedentries', 'feedtitle', 'feedlink', 'xml_format', 'to_encoding' );
    if (! isset( $content ) ) {
        $ctx->localize( $localvars );
        $to_encoding = $ctx->mt->config( 'PublishCharset' );
        $to_encoding or $to_encoding = 'UTF-8';
        $ctx->stash( 'to_encoding', $to_encoding );
        $url = $args[ 'uri' ];
        $no_cache = $ctx->mt->config( 'FeedNoCache' );
        $xml_object = NULL;
        if ( $no_cache ) {
            $xml_object = simplexml_load_file( $url );
        } else {
            $cache_dir = $_SERVER[ 'DOCUMENT_ROOT' ] . dirname( $_SERVER[ 'PHP_SELF' ] ) .
                         DIRECTORY_SEPARATOR . 'cache';
            $cache_basename = md5( $url );
            $cache_file = $cache_dir . DIRECTORY_SEPARATOR . $cache_basename;
            $expiration = $ctx->mt->config( 'FeedCacheExpiration' );
            if (! $expiration ) $expiration = 86400;
            $use_cache = 0;
            if ( file_exists( $cache_file ) ) {
                $filemtime = filemtime( $cache_file );
                if (! ( time() - $expiration ) > $filemtime ) {
                    $use_cache = 1;
                }
            }
            if (! $use_cache ) {
                $xml = file_get_contents( $url );
                if ( $xml ) {
                    file_put_contents( $cache_file, $xml );
                }
            }
            if ( file_exists( $cache_file ) ) {
                $xml_object = simplexml_load_file( $cache_file );
            }
        }
        $ctx->stash( 'xml_object', $xml_object );
        $ns = $xml_object->getDocNamespaces();
        if ( is_array( $ns ) && count( $ns ) ) {
            $ns = $ns[ '' ];
            $ns = strtolower( $ns );
            if ( $pos = strpos( $ns, '/atom/' ) ) {
                $ctx->stash( 'xml_format', 'ATOM' );
            } elseif ( $pos = strpos( $ns, '/rss/' ) ) {
                $ctx->stash( 'xml_format', 'RSS' );
            }
        } else {
            $version = $xml_object->attributes()->version;
            if ( $version == '2.0' ) {
                $ctx->stash( 'xml_format', 'RSS' );
            }
        }
    }
    $xml_object = $ctx->stash( 'xml_object' );
    if ( isset( $xml_object ) ) {
        $xml_format = $ctx->stash( 'xml_format' );
        $title   = $xml_object->title;
        if ( $xml_format == 'ATOM' ) {
            $entries = $xml_object->entry;
        } elseif ( $xml_format == 'RSS' ) {
            $entries = $xml_object->channel->item;
        }
        $ctx->stash( 'feedtitle', $title );
        $ctx->stash( 'feedentries', $entries );
        return $content;
    } else {
        $repeat = FALSE;
    }
    if ( $repeat == FALSE ) {
        $ctx->localize( $localvars );
    }
}
?>