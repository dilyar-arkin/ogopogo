$(window).on("load",function(){


counter = 0;
var countDownDate = new Date("June 25, 2023 16:37:52").getTime();

var myfunc = setInterval(function() {

    var now = new Date().getTime();
    var timeleft = countDownDate - now;        
    var days = Math.floor(timeleft / (1000 * 60 * 60 * 24));
    var hours = Math.floor((timeleft % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
    var minutes = Math.floor((timeleft % (1000 * 60 * 60)) / (1000 * 60));
    var seconds = Math.floor((timeleft % (1000 * 60)) / 1000);
    document.getElementById("time").innerHTML = days +":"+hours+":"+minutes+":"+seconds   
    if (timeleft < 0) {
        clearInterval(myfunc);
        document.getElementById("days").innerHTML = ""
        document.getElementById("hours").innerHTML = "" 
        document.getElementById("mins").innerHTML = ""
        document.getElementById("secs").innerHTML = ""
        document.getElementById("end").innerHTML = "Poll Closed";
    }   

}, 1000)

var popPost = document.getElementById("popPost")
var home = document.getElementById("home")
var myPost = document.getElementById("myPost")

popPost.addEventListener("click",function(e){

    $("#upperContent").hide()
    var d = "<div class='col-sm-12' id='popularContent'> <h3> Popular Polls [-- Closed --] </h3></div>"
    //load only once from the server for each session
    if(counter == 0){    
        $("#contentArea").prepend(d);
        $("#popularContent").append("<p>read from database and display popular posts as table </p>")
        counter++;
    }
    else{
        $("#popularContent").show();
    }
    $("#popPost").addClass("active")
    $("#home").removeClass("active")
    $("#lowerContent").show()
    
})

home.addEventListener("click",function(){
    $("#popularContent").hide();
    $("#upperContent").show();
    $("#lowerContent").show()
    $("#home").addClass("active")
    $("#popPost").removeClass("active")
})

myPost.addEventListener("click",function(){
    var verify = true; // this is true when user is logged in
    if(verify){
        $("#upperContent").hide();
        $("#popularContent").hide()
        $("#lowerContent").hide()
        $("#myPost").addClass("active")
        $("#home").removeClass("active")
        $("#popPost").removeClass("active")
    }
})


})