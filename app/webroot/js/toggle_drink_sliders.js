$( document ).ready(function() {
    // hide all weekday drink sliders
    $("[id*='standard-drinks-slider_']").parents("div.field").hide();

    $("div > input[name*='past_4wk_drinks']")
    .click(function()
         {
      $this = $(this);
      let name = this.name;
      let day = name.substring(name.length -3);
      let $dayDrinkSlider = $(`div[id='standard-drinks-slider_${day}']`).parents(".field");
      if ($this.val() == 0 || $this.val() == 5) {
        $dayDrinkSlider.hide();
        $dayDrinkSlider.find('input').val(0); // must set value to 0 to be able to continue
      } else {
        $dayDrinkSlider.show();
      }
    })
});
