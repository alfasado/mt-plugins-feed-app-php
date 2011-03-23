<?php
function smarty_block_mtfeedentries ( $args, $content, &$ctx, &$repeat ) {
    $localvars = array( 'feedentries', 'feedentry', '__feedcounter', '__feedoutput' );
    if (! isset( $content ) ) {
        $ctx->localize( $localvars );
        $offset = $args[ 'offset' ];
        $offset = $offset + 0;
        if (! $offset ) $offset = 0;
        $ctx->stash( '__feedcounter', $offset );
        $ctx->stash( '__feedoutput', 0 );
    } else {
        $feedentries = $ctx->stash( 'feedentries' );
        if ( isset ( $feedentries ) ) {
            $counter = $ctx->stash( '__feedcounter' );
            $output = $ctx->stash( '__feedoutput' );
            if ( isset( $args[ 'lastn' ] ) ) {
                $lastn = $args[ 'lastn' ];
                $lastn = $lastn + 1;
                if ( $output == $lastn ) {
                    $repeat = FALSE;
                    return;
                }
            }
            if ( $counter <  count( $feedentries ) ) {
                $ctx->stash( 'feedentry', $feedentries[ $counter ] );
                $repeat = TRUE;
                $counter++;
            } else {
                $repeat = FALSE;
            }
            $ctx->stash( '__feedcounter', $counter );
            if ( $output && isset ( $content ) ) {
                $output++;
                $ctx->stash( '__feedoutput', $output );
                return $content;
            }
            $output++;
            $ctx->stash( '__feedoutput', $output );
        }
        if ( $repeat == FALSE ) {
            $ctx->localize( $localvars );
        }
    }
}
?>