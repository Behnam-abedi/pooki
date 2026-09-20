if (typeof jQuery !== 'undefined') {
  jQuery(document).ready(function ($) {
    $('form.cart').on('submit', function (e) {
      const $form = $(this);

      // Skip for external products
      if ($form.hasClass('external_cart')) {
        return;
      }

      e.preventDefault();
      const $button = $form.find('button[type="submit"]');
      let formData = $form.serializeArray();

      let hasAddToCart = false;
      $.each(formData, function(i, field) {
          if (field.name === 'add-to-cart') {
              hasAddToCart = true;
          }
      });

      // Append add-to-cart to the payload if not already there
      if (!hasAddToCart) {
          let productId = $button.val() || $form.find('input[name="add-to-cart"]').val();
          if (productId) {
              formData.push({ name: 'add-to-cart', value: productId });
          }
      }

      // Add a basic loading state class
      $button.addClass('opacity-50 pointer-events-none');

      $.ajax({
        url: window.location.href,
        type: 'POST',
        data: $.param(formData),
        success: function (response) {
          // Check if response contains a WooCommerce error snippet
          if (response.indexOf('woocommerce-error') > -1 || response.indexOf('wc-block-components-notice-banner is-error') > -1) {
            // Fallback to regular submission to show the error
            $form.off('submit').submit();
            return;
          }

          // Trigger native event to refresh fragments & open the Alpine drawer
          $(document.body).trigger('added_to_cart');
        },
        error: function () {
          $form.off('submit').submit();
        },
        complete: function () {
          $button.removeClass('opacity-50 pointer-events-none');
        }
      });
    });
  });
}
