$( document ).ready(function() {
    $("body").on("click",".navbar-toggler", function(){
        $("body").addClass("active")               
    })
    $(".btn-close-navbar").on("click", function(){
        $(".navbar-toggler").addClass("collapsed")
        $("#navbarNav").removeClass("show")        
    })
    
});