  function doSlide(slider) {
      var id, o = slider.querySelectorAll("input.mkslide"),
          last = o.length - 1,
          current = slider.querySelector("input.mkslide:checked");
      for (var i = 0; i < o.length; i++)
          if (o[i] === current) {
              id = i;
              break;
          }
      o[id >= last ? 0 : id + 1].click();
  }

  function onSlide(e) {
      var o = e.target.parentNode;
      clearTimeout(o.autoslider);
      o.autoslider = setTimeout(function() {
          doSlide(o);
      }, 7e3);
  }

  jQuery(document).ready(function() {
      jQuery(document).on("click", "input.mkslide", onSlide);
      jQuery(".mkslider").each(function() {
          doSlide(this)
      });
  });