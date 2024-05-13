//Universal Script


// to use navbar.php repeatedly by placing <div id="nav-placeholder"></div> in top of the body tag
$(function(){
  $("#navbar-placeholder").load("navbar.php");
  $("#footer-placeholder").load("footer.html");
  $("#newspage-navbar-placeholder").load("newspage_navbar.html");
  $("#newspage-footer-placeholder").load("newspage_footer.html");
  $("#book-navbar-placeholder").load("book_navbar.html");
  $("#book-footer-placeholder").load("book_footer.html");
  $("#admin-navbar-placeholder").load("admin_navbar.php");
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
      var limitPerPage = 12; //How many books visible per page
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



    // Live Search Bar
    $(document).ready(function(){
    $("#live_search").keyup(function(){
    var input = $(this).val();

    if(input != ""){
      $.ajax({
        url:"livesearch.php",
        method:"POST",
        data:{input: input},
        success:function(data){
          $("#searchresult").html(data);
          $("#searchresult").css("display","block");
        }
      });
    }else {
      // Clear the search results and hide the display when the input is empty
      $("#searchresult").html("");
      $("#searchresult").css("display","none");
      }
    });
  });







    //For making book-wrapper and pagination hidden when the result of the live_search appears
    document.addEventListener("DOMContentLoaded", function () {
        var liveSearchInput = document.getElementById("live_search");
        var bookWrapperDiv = document.getElementById("book-wrapper");
        var hide_pagination = document.getElementById("hide_pagination");

        // Function to check live search input and hide/show book-wrapper
        function checkLiveSearchInput() {
            // Check if live_search input has any value
            if (liveSearchInput.value.trim() !== "") {
                // Hide the book-wrapper
                bookWrapperDiv.style.display = "none";
                hide_pagination.style.display = "none";
            } else {
                // Show the book-wrapper
                bookWrapperDiv.style.display = "block";
                hide_pagination.style.display = "block";
            }
        }

        // Initial check when the page loads
        checkLiveSearchInput();

        // Attach an event listener to live_search input
        liveSearchInput.addEventListener("input", checkLiveSearchInput);
    });

    
    
  
    
    










  //Script for EBooks Page
  case 'EBooksPage':
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





    // Live Search Bar
    $(document).ready(function(){
      $("#ebook_live_search").keyup(function(){
      var input = $(this).val();
  
      if(input != ""){
        $.ajax({
          url:"ebooks_livesearch.php",
          method:"POST",
          data:{input: input},
          success:function(data){
            $("#searchresult").html(data);
            $("#searchresult").css("display","block");
          }
        });
      }else {
        // Clear the search results and hide the display when the input is empty
        $("#searchresult").html("");
        $("#searchresult").css("display","none");
        }
      });
    });





  //For making book-wrapper and pagination hidden when the result of the live_search appears
  document.addEventListener("DOMContentLoaded", function () {
    var liveSearchInput = document.getElementById("ebook_live_search");
    var bookWrapperDiv = document.getElementById("book-wrapper");
    var hide_pagination = document.getElementById("hide_pagination");

    // Function to check live search input and hide/show book-wrapper
    function checkLiveSearchInput() {
      // Check if live_search input has any value
        if (liveSearchInput.value.trim() !== "") {
          // Hide the book-wrapper
          bookWrapperDiv.style.display = "none";
          hide_pagination.style.display = "none";
        } else {
          // Show the book-wrapper
          bookWrapperDiv.style.display = "block";
          hide_pagination.style.display = "block";
        }
    }

    // Initial check when the page loads
    checkLiveSearchInput();

    // Attach an event listener to live_search input
    liveSearchInput.addEventListener("input", checkLiveSearchInput);
  });





    
  //Script for Journal Page
  case 'JournalPage':
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

  // script for book_info.php
  case 'book_info':
    // popup for borrowing book
    document.querySelector("#borrow-btn").addEventListener("click", function(){
      document.querySelector(".popup").classList.add("active");
    });

    // closing popup for borrowing book
    document.querySelector(".popup .close-btn").addEventListener("click", function(){
      document.querySelector(".popup").classList.remove("active");
    });

  case 'profile_page':
    document.getElementById("fileImg").onchange = function(){
      document.getElementById("profile_picture").src = URL.createObjectURL(fileImg.files[0]); // Preview new image

      document.getElementById("cancel").style.display="block";
      document.getElementById("confirm").style.display="block";

      document.getElementById("upload").style.display="none";
    };

    var userImage = document.getElementById('profile_picture').src;
    document.getElementById("cancel").onclick = function() {
      document.getElementById("profile_picture").src = userImage; // Back to previous image

      document.getElementById("cancel").style.display="none";
      document.getElementById("confirm").style.display="none";

      document.getElementById("upload").style.display="block";
    };

  case 'book_management':
    // Live Search Bar
    $(document).ready(function(){
      $("#bookmanagement_livesearch").keyup(function(){
      var input = $(this).val();
  
      if(input != ""){
        $.ajax({
          url:"bookmanagement_livesearch.php",
          method:"POST",
          data:{input: input},
          success:function(data){
            $("#searchresult").html(data);
            $("#searchresult").css("display","block");
          }
        });
      }else {
        // Clear the search results and hide the display when the input is empty
        $("#searchresult").html("");
        $("#searchresult").css("display","none");
        }
      });
    });
  
  
  
  
  
  
      //For making table and pagination hidden when the result of the live_search appears
      document.addEventListener("DOMContentLoaded", function () {
          var liveSearchInput = document.getElementById("bookmanagement_livesearch");
          var dashboardDiv = document.getElementById("dashboard_container form");
  
          // Function to check live search input and hide/show table
          function checkLiveSearchInput() {
              // Check if live_search input has any value
              if (liveSearchInput.value.trim() !== "") {
                  // Hide the table
                  dashboardDiv.style.display = "none";
              } else {
                  // Show the table
                  dashboardDiv.style.display = "block";
              }
          }
  
          // Initial check when the page loads
          checkLiveSearchInput();
  
          // Attach an event listener to live_search input
          liveSearchInput.addEventListener("input", checkLiveSearchInput);
      });

  case 'login_page':
    let eye_icon = document.getElementById("eye_icon");
    let user_password = document.getElementById("user_password");

    eye_icon.onclick = function(){
      if(user_password.type == "password"){
        user_password.type = "text";
        eye_icon.src = "images/eye-open.png";
      } else {
        user_password.type = "password";
        eye_icon.src = "images/eye-close.png";
      }
    }

  case 'registerPage':
    let eyeicon1 = document.getElementById("eyeicon1");
    let eyeicon2 = document.getElementById("eyeicon2");
    let register_password1 = document.getElementById("register_password1");
    let register_password2 = document.getElementById("register_password2");

    eyeicon1.onclick = function(){
      if(register_password1.type == "password"){
        register_password1.type = "text";
        eyeicon1.src = "images/eye-open.png";
      } else {
        register_password1.type = "password";
        eyeicon1.src = "images/eye-close.png";
      }
    }

    eyeicon2.onclick = function(){
      if(register_password2.type == "password"){
        register_password2.type = "text";
        eyeicon2.src = "images/eye-open.png";
      } else {
        register_password2.type = "password";
        eyeicon2.src = "images/eye-close.png";
      }
    }

    function validate(){
      var pass = document.getElementById("register_password1");
      var upper = document.getElementById('upper');
      var lower = document.getElementById('lower');
      var num = document.getElementById('number');
      var len = document.getElementById('length');
      var sp_char = document.getElementById('special_char');

      //checks if the password value contain number
      if(pass.value.match(/[0-9]/)){
        num.style.color = 'green';
      }else{
        num.style.color = '#FF5050';
      }

      //checks if the password value contain uppercase
      if(pass.value.match(/[A-Z]/)){
        upper.style.color = 'green';
      }else{
        upper.style.color = '#FF5050';
      }

      //checks if the password value contain lowercase
      if(pass.value.match(/[a-z]/)){
        lower.style.color = 'green';
      }else{
        lower.style.color = '#FF5050';
      }

      //checks if the password value contain special character
      if(pass.value.match(/[!\@\#\$\%\^\&\*\(\)\_\-\+\=\?\>\<\.\,]/)){
        sp_char.style.color = 'green';
      }else{
        sp_char.style.color = '#FF5050';
      }

      //checks length of the password
      if(pass.value.length > 6){
        len.style.color = 'green';
      }else{
        len.style.color = '#FF5050';
      }
    }


}
