//Universal Script

/*  ===================   SERRANO SCRIPT   ===================*/

// to use navbar.html repeatedly by placing <div id="nav-placeholder"></div> in top of the body tag
$(function(){
  $("#navbar-placeholder").load("navbar.html");
  $("#footer-placeholder").load("footer.html");
});

//Switch Statement for different HTML pages
let page = document.body.id;
switch(page){
  
  //Script for Landing Page
  case 'LandingPage':
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

  //Script for Books Page
  case 'BooksPage':
    function getPageList(totalPages, page, maxLength){
      function range(start, end){
        return Array.from(Array(end - start + 1), (_, i) => i + start);
      }

      var sideWidth = maxLength < 9 ? 1 : 2;
      var leftWidth = (maxLength - sideWidth * 2 - 3) >> 1;
      var rightWidth = (maxLength - sideWidth * 2 - 3) >> 1;

      if(totalPages <= maxLength){
        return range(1, totalPages);
      }

      if (page <= maxLength - sideWidth - 1 - rightWidth){
        return range(1, maxLength - sideWidth - 1).concat(0, range(totalPages - sideWidth + 1, totalPages));
      }

      if (page >= totalPages - sideWidth - 1 - rightWidth) {
        return range(1, sideWidth).concat(0, range(totalPages - sideWidth - 1 - rightWidth - leftWidth, totalPages));
      }

      return range(1, sideWidth).concat(0, range(page -  leftWidth, page + rightWidth), 0, range(totalPages - sideWidth + 1, totalPages));
    }

    $(function(){
      var numberOfItems = $(".books_wrapper .book").length;
      var limitPerPage = 16; //How many books visible per page
      var totalPages = Math.ceil(numberOfItems / limitPerPage);
      var paginationSize = 7; //How many page elements visible in the pagination
      var currentPage;

      function showPage(whichPage){
        if(whichPage < 1 || whichPage > totalPages) return false;

        currentPage = whichPage;

        $(".books_wrapper .book").hide().slice((currentPage - 1) * limitPerPage, currentPage * limitPerPage).show();

        $(".pagination li").slice(1, -1).remove();

        getPageList(totalPages, currentPage, paginationSize).forEach(item => {
          $("<li>").addClass("page-item").addClass(item ? "current-page" : "dots")
          .toggleClass("active", item === currentPage).append($("<a>").addClass("page-link")
          .attr({href: "javascript:void(0)"}).text(item || "...")).insertBefore(".next-page");
        });

        $(".previous-page").toggleClass("disable", currentPage === 1);
        $(".next-page").toggleClass("disable", currentPage === totalPages);
        return true;
      }

      $(".pagination").append(
        $("<li>").addClass("page-item").addClass("previous-page").append($("<a>").addClass("page-link").attr({href: "javascript:void(0)"}).text("Prev")),
        $("<li>").addClass("page-item").addClass("next-page").append($("<a>").addClass("page-link").attr({href: "javascript:void(0)"}).text("Next"))
      );

      $(".books_wrapper").show();
      showPage(1);

      $(document).on("click", ".pagination li.current-page:not(.active)", function(){
        return showPage(+$(this).text());
      });

      $(".next-page").on("click", function(){
        return showPage(currentPage + 1);
      });

      $(".previous-page").on("click", function(){
        return showPage(currentPage - 1);
      });
    });
}
  

/*  ===================   WAYCO SCRIPT   ===================*/

/*  ===================   VICQUERRA SCRIPT   ===================*/

/*  ===================   TOBIAS SCRIPT   ===================*/
