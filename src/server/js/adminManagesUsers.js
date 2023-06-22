
$(window).on("load",function(){

var deletebtn = document.getElementById("DeleteUser");
var deletebtn2 = document.getElementById("DeletePolls") 

deletebtn.addEventListener("click",function(e){
    e.preventDefault();
    var username = document.getElementById("username").value;
    var email = document.getElementById("email").value;

        var http = new XMLHttpRequest();
        var url = 'adminManagesUsers.php';
        var params = 'username='+username+'&email='+email;
        http.open('POST', url, true);
        //Send the proper header information along with the request
        http.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');

        http.onreadystatechange = function() {//Call a function when the state changes.
            if(http.readyState == 4 && http.status == 200) {
                //alert(http.responseText);
                document.getElementById("deleteStatus").innerHTML=this.responseText;
            }
        }
        http.send(params);
})

})