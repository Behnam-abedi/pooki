<?php
if ( ! defined( 'ABSPATH' ) ) { exit; }
if ( ! $notices ) { return; }
?>
<ul class="pooki-notice pooki-notice-error bg-red-50 border-r-4 border-red-500 p-4 mb-6 rounded-l-md shadow-sm list-none m-0" role="alert">
    <?php foreach ( $notices as $notice ) : ?>
        <li class="flex items-center mb-2 last:mb-0" <?php echo wc_get_notice_data_attr( $notice ); ?>>
            <div class="flex-shrink-0 ml-3">
                <svg class="h-5 w-5 text-red-500" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/></svg>
            </div>
            <div class="font-medium text-red-800 text-sm md:text-base">
                <?php echo wc_kses_notice( $notice['notice'] ); ?>
            </div>
        </li>
    <?php endforeach; ?>
</ul>
