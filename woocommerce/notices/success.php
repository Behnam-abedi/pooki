<?php
if ( ! defined( 'ABSPATH' ) ) { exit; }
if ( ! $notices ) { return; }
?>
<?php foreach ( $notices as $notice ) : ?>
    <div class="pooki-notice pooki-notice-success bg-green-50 border-r-4 border-green-500 p-4 mb-6 rounded-l-md shadow-sm" <?php echo wc_get_notice_data_attr( $notice ); ?> role="alert">
        <div class="flex items-center">
            <div class="flex-shrink-0 ml-3">
                <svg class="h-5 w-5 text-green-500" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
            </div>
            <div class="font-medium text-green-800 text-sm md:text-base">
                <?php echo wc_kses_notice( $notice['notice'] ); ?>
            </div>
        </div>
    </div>
<?php endforeach; ?>
