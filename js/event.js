document.addEventListener("DOMContentLoaded", function () {
    jQuery(".carroussel-content").slick({
      infinite: true,
      speed: 300,
      //adaptiveHeight: true,
      slidesToShow: 1,
      centerMode: true,
      variableWidth: true,
  
      // centerMode: true,
      // variableWidth: true,
    });
  });