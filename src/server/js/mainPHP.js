$(window).on("load",function(){

    counter = 0; // this is for highlighting feature, do not delete
    counter2=0;
    counter3=0;

    function PollCloseCal(id,val){
        
        var counttime = new Date(val).getTime()  
        setInterval(function() {
        var now = new Date().getTime();
        var timeleft = counttime - now;        
        var days = Math.floor(timeleft / (1000 * 60 * 60 * 24));
        var hours = Math.floor((timeleft % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
        var minutes = Math.floor((timeleft % (1000 * 60 * 60)) / (1000 * 60));
        var seconds = Math.floor((timeleft % (1000 * 60)) / 1000);
        $(id).text(days +":"+hours+":"+minutes+":"+seconds)  

        }, 1000) 
    }
    
    function showOpenPolls(position,op) {
        
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {
          if (this.readyState == 4 && this.status == 200) {
            document.getElementById(position).innerHTML = this.responseText;
          }
        };
        xmlhttp.open("GET","getOpenPolls.php?option="+op,true);
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
    var changePass = document.getElementById("changePassword")

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
        $('#resetFieldset').hide();
        
        
    })

    home.addEventListener("click",function(){
        $("#popularContent").hide();
        $("#popularContentTab").hide()
        $("#upperContent").show();
        $("#lowerContent").show()
        $("#home").addClass("active")
        $("#popPost").removeClass("active")
        $("#myPolls").hide()
        $('#resetFieldset').hide();
    })

    myPost.addEventListener("click",function(){
        // var verify = false; // in index.html this is always false
        //alert("Please login to see your posts")   
        //setTimeout("location.href = 'login.html';", 1500);
        //window.location.href="login.html"
        if(counter2 == 0){
            var m = "<div class='col-sm-12' id='myPolls'> <h3> My Polls </h3></div>"
            $("#contentArea").append(m);
            showOpenPolls("myPolls",'myPolls')
            counter2++;
        }
            $("#myPolls").show()
            $("contentArea").show()
            $("#upperContent").hide();
            $("#popularContent").hide()
            $("#popularContentTab").hide()
            $("#lowerContent").hide()
            $('#resetFieldset').hide();
            $("#myPost").addClass("active")
            $("#popPost").removeClass("active")
            $("#home").removeClass("active")

    })
    changePass.addEventListener("click",function(){
        $("#upperContent").hide()
        $("#lowerContent").hide()

        if(counter3 == 0){
        var parent = $("#contentArea");
        var NewChild = "<form id='sendForm' action='resetPassword.php' method='POST'><fieldset id='resetFieldset'><legend>Password Reset Form</legend></fieldset></form>";
        parent.append(NewChild)
        var oldLabel = "<label>Old Password: </label>"
        var oldpass = "<input type='password' name='oldpassword' id='oldpassword' class='required' required><br>"
        var newLabel = "<label>new Password: </label>"
        var newpass = "<input type='password' name='newpassword' id='newpassword' class='required' required><br>"
        var newLabelC = "<label>re-enter new Password:</label>"
        var newpassC = "<input type='password' name='newpasswordC' id='newpassword2'class='required' required><br>"
        var sbutton = "<input type='submit' id='sendPass' value='submit'>"
        var cbutton = "<input type='reset' 'id='reset' value='reset'>"
        
        $('#resetFieldset').append(oldLabel);
        $('#resetFieldset').append(oldpass);
        $('#resetFieldset').append(newLabel);
        $('#resetFieldset').append(newpass);
        $('#resetFieldset').append(newLabelC);
        $('#resetFieldset').append(newpassC);
        $('#resetFieldset').append(sbutton);
        $('#resetFieldset').append(cbutton);
        counter3++;
        }
        else{
        $('#resetFieldset').show();
        //$("contentArea").show()
        $("#popularContent").hide()
        $("#popularContentTab").hide()
        $("#myPost").removeClass("active")
        $("#popPost").removeClass("active")
        $("#home").removeClass("active")
        }   
    
    //$('#changePassword').text()
    })
    //document.getElementById("sendForm").addEventListener("click",function(event){

        //event.preventDefault();
        //console.log("prevented");
        
        /*
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {
          if (this.readyState == 4 && this.status == 200) {
            document.getElementById(position).innerHTML = this.responseText;
          }
        };
        xmlhttp.open("GET","getOpenPolls.php?option="+op,true);
        xmlhttp.send();
        */

    //})




})