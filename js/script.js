//Universal Script

/*  ===================   SERRANO SCRIPT   ===================*/

// to use navbar.html repeatedly by placing <div id="nav-placeholder"></div> in top of the body tag
  $(function(){
    $("#navbar-placeholder").load("navbar.html");
    $("#footer-placeholder").load("footer.html");
  });

  // Carousel
  var slides = document.querySelectorAll('.slide');
  var btns = document.querySelectorAll('.btn');
  let currentSlide = 1;

  //Javascript for image slider manual navigation
  var manualNav = function(manual) {
    slides.forEach((slide) => {
      slide.classList.remove('active'); 

      btns.forEach((btn) => {
        btn.classList.remove('active');
      });
    });

    slides[manual].classList.add('active');
    btns[manual].classList.add('active');
  }

  btns.forEach((btn, i) => {
    btn.addEventListener("click", () => {
      manualNav(i);
      currentSlide = i;
    });
  });

  //Javascript for image slider autoplay navigation
  var repeat = function(activeClass){
    let active = document.getElementsByClassName('active');
    let i = 1;

    var repeater = () => {
      setTimeout(function(){
        [...active].forEach((activeSlide) => {
          activeSlide.classList.remove('active');
        });

        slides[i].classList.add('active');
        btns[i].classList.add('active');
        i++;

        if(slides.length == i){
          i = 0;
        }
        if(i >= slides.length){
          return;
        }
        repeater();
      }, 10000);
    }
    repeater();
  }
  repeat();

  //New and Updates Carousel
  const NewsUpdatecarousel = document.querySelector(".NewsAndUpdate_carousel");
  const arrowBtns = document.querySelectorAll(".NewsAndUpdate_wrapper .arrowButton");
  const firstCardWidth = NewsUpdatecarousel.querySelector(".cards").offsetWidth;

  //Add event Listener for the arrow buttons to scroll the carousel left and right
  arrowBtns.forEach(btn => {
    btn.addEventListener("click", () => {
      NewsUpdatecarousel.scrollLeft += btn.id === "leftbtn" ? -firstCardWidth : firstCardWidth;
    });
  });

  //Top Books Carousel
  const TopBookscarousel = document.querySelector(".topbooks_carousel");
  const arrowBtn = document.querySelectorAll(".topbooks_wrapper .arrowBtn");
  const firstFrontCoverWidth = TopBookscarousel.querySelector(".frontcover").offsetWidth;

  //Add event Listener for the arrow buttons to scroll the carousel left and right
  arrowBtn.forEach(btn => {
    btn.addEventListener("click", () => {
      TopBookscarousel.scrollLeft += btn.id === "leftbutton" ? -firstFrontCoverWidth : firstFrontCoverWidth;
    });
  });
  
/*  ===================   WAYCO SCRIPT   ===================*/

/*  ===================   VICQUERRA SCRIPT   ===================*/

/*  ===================   TOBIAS SCRIPT   ===================*/
