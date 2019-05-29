(function($) {
  "use strict";

  let data = shifterForms.data;

  function successModal() {
    alert('Great success!');
  }

  function resetForm(el) {
    $(el)[0].reset();  
  }

  function submitForm(target, action, data) {
    var url = action,
      data = $(target)
        .closest("form")
        .serialize();
    
    $.ajax({
      url: url,
      type: 'POST',
      datatype: 'jsonp',
      crossDomain: true,
      data: data,
      success: function() {
        successModal();
      }
    });
  }

  data.forEach(function(el) {
    const target = el.shifter_form_target;
    const action = el.shifter_form_action;
    const form = $(target).closest("form");
    $(form).attr("action", action);
    $(form).attr("method", "post");

    $(target).on('submit', function(e) {
      e.preventDefault();
      submitForm(target, action);
    });

    // $(target).click(function() {
    //   $(this).submit(function() {
    //     submitForm(target, action);
    //   });
    // })
  });
})(jQuery);
