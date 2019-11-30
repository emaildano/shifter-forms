(function($) {
  "use strict";

  let data = shifterForms.data;
  
  function successPage(el) {
    window.location.href = el;
  }

  function submitForm(target, action, confirmation) {
    var url = action,
      data = $(target).closest("form").serialize();
    
    $.ajax({
      url: url,
      type: 'POST',
      datatype: 'jsonp',
      crossDomain: true,
      data: data,
      success: function() {
        successPage(confirmation);
      }
    });
  }

  data.forEach(function(el) {
    const target = el.shifter_form_target;
    const action = el.shifter_form_action;
    const confirmation = el.shifter_form_confirmation;
    const form = $(target).closest("form");
    $(form).attr("action", action);
    $(form).attr("method", "post");

    $(target).on('submit', function(e) {
      e.preventDefault();
      submitForm(target, action, confirmation);
    });
  });
})(jQuery);
