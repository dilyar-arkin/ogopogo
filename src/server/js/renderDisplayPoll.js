
$(window).on("load",function(){
    
    var submitBut = document.getElementById("submitPoll")
    var username = $('#username').text();
    var pollID = $('#pollID').text();
    var dueDateVal = $('#dueDate').text();
    var dueDate = $('#dueDate');
    

    // POSTING CASTED VOTE   
    submitBut.addEventListener("click",function(){
    $(".pollBox").hide();
    var castedVote = $('input[name="vote"]:checked').val();
    //$('.pollResult').html("<p>"+pollID+"</p>")
    //$('.pollResult').html("<p>"+username+"</p>")
    
    // AJAX in action
    var http = new XMLHttpRequest();
    var url = 'poll.php';
    var params = 'username='+username+'&pollID='+pollID+'&castedVote='+ castedVote;
    http.open('POST', url, true);
    //Send the proper header information along with the request
    http.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
    
    http.onreadystatechange = function() {//Call a function when the state changes.
        if(http.readyState == 4 && http.status == 200) {
            //alert(http.responseText);
            document.getElementById("pollStat").innerHTML=this.responseText;
        }
    }
    http.send(params);
    
})

// if polls are closed, show the result from databse
var sessionUser = $('#sessionuser').text();
if(sessionUser == ''){
    $('.leaveComment').show();
}

// POSTING A COMMENT
var commentButt = document.getElementById('commentButt');
commentButt.addEventListener("click",function(){
    var comment = $('.comment').val();
    // AJAX in action
    var http = new XMLHttpRequest();
    var url2 = 'commentTodb.php';
    //console.log(pollID)
    //console.log(sessionUser)
    //console.log(comment)
    var params2 = 'pollID='+pollID+'&sessionUser='+sessionUser+'&comment='+ comment;
    //console.log(params2)
    http.open('POST', url2, true);
    //Send the proper header information along with the request
    http.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
    
    http.onreadystatechange = function() {//Call a function when the state changes.
    if(http.readyState == 4 && http.status == 200) {
    //alert(http.responseText);
    $('.leaveComment').hide();
    document.getElementById("commentTodb").innerHTML=this.responseText;
    }
    }
    http.send(params2);  
})
//------------------------------------------------//
// CHECKING FOR  POLLS REMAINING TIME
function PollCloseCal(id,dueDateVal){
        
    var counttime = new Date(dueDateVal).getTime()  
    setInterval(function() {
    var now = new Date().getTime();
    var timeleft = counttime - now;        
    var days = Math.floor(timeleft / (1000 * 60 * 60 * 24));
    var hours = Math.floor((timeleft % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
    var minutes = Math.floor((timeleft % (1000 * 60 * 60)) / (1000 * 60));
    var seconds = Math.floor((timeleft % (1000 * 60)) / 1000);
    $(id).text(days +":"+hours+":"+minutes+":"+seconds)  
    
    if(minutes<0){
        updatePollStatus();
    }

    }, 1000) 
}
PollCloseCal(dueDate,dueDateVal);

function updatePollStatus(){
    $('#dueDate').text("Closed");
    $('.pollBox').hide();
    $('pollStat').show();
    var http = new XMLHttpRequest();
    var url = 'poll.php?pollID='+pollID;

    http.open('GET', url, true);
    //Send the proper header information along with the request
    http.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
    
    http.onreadystatechange = function() {//Call a function when the state changes.
    if(http.readyState == 4 && http.status == 200) {
    //alert(http.responseText);
    document.getElementById("pollStat").innerHTML=this.responseText;
    }
    }
    http.send();
}

//-----------------------------------------------------//
//display comments AJAX

    var http = new XMLHttpRequest();
    var url = 'comment.php?pollID='+pollID;

    http.open('GET', url, true);
    //Send the proper header information along with the request
    http.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
    
    http.onreadystatechange = function() {//Call a function when the state changes.
    if(http.readyState == 4 && http.status == 200) {
    //alert(http.responseText);
    document.getElementById("commentTableBody").innerHTML=this.responseText;
    }
    }
    http.send();  
//


})