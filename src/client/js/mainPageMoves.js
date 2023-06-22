$(window).on("load",function(){

    counter = 0; // this is for highlighting feature, do not delete
    counter2=0;

    function showOpenPolls(position,op) {
        
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {
          if (this.readyState == 4 && this.status == 200) {
            document.getElementById(position).innerHTML = this.responseText;
          }
        };
        xmlhttp.open("GET","../server/getOpenPolls.php?option="+op,true);
        xmlhttp.send();
        
    }

    showOpenPolls("openPollsDiv","open");
    //var t = "June 26, 2023 00:00:00";
    //PollCloseCal("#time1",t);
    //above code only works for the single row element, in order update all row elements' time stamp use other sol.
    //problem is php echo'd elements can not be found by jquery nor document.getElementby.. methods


    var popPost = document.getElementById("popPost")
    var home = document.getElementById("home")
    var myPost = document.getElementById("myPost")

    popPost.addEventListener("click",function(e){
        $("#popularContentTab").show()
        $("#upperContent").hide()
        var d = "<div class='col-sm-12' id='popularContent'> <h3> Popular Polls [-- Closed --] </h3></div>"
        var dd = "<div id='popularContentTab'></div>"
        //load only once from the server for each session
        if(counter == 0){    
            $("#contentArea").prepend(dd);
            $("#contentArea").prepend(d);
            showOpenPolls('popularContentTab',"popular")
            //$("#popularContent").append("<p>read from database and display popular posts as table </p>")
            counter++;
        }
        else{
            $("#popularContent").show();
            
        }
        $("#myPolls").hide()
        $("#popPost").addClass("active")
        $("#home").removeClass("active")
        $("#myPost").removeClass("active")
        $("#lowerContent").show()
        
        
    })

    home.addEventListener("click",function(){
        $("#popularContent").hide();
        $("#popularContentTab").hide()
        $("#upperContent").show();
        $("#lowerContent").show()
        $("#home").addClass("active")
        $("#popPost").removeClass("active")
        $("#myPolls").hide()
    })

    myPost.addEventListener("click",function(){
        // var verify = false; // in index.html this is always false
        //alert("Please login to see your posts")   
        //setTimeout("location.href = 'login.html';", 1500);
        //window.location.href="login.html"
        if (confirm("You must login to search for posts. Press OK to login")) {
            window.location.href="index.html"
        }
        
    })

})