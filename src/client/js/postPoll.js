
$(window).on("load",function(){


    var counter = 3;

    function myClick(){

            var o3 = "<label for='input_id_0' class='col-sm-2 col-form-label'>Option "+counter+"</label>"
            var o3Text = "<div class='col-sm-10'><input type='text' class='form-control' name='option" +counter+"' id='input_id_0' placeholder='additional options : '></div> <br><br>"
            $("#moreOptions").append(o3,o3Text)
            counter ++;
            console.log(counter)
            checkMax();
    
    }

    var O = document.querySelector("#addOptions")
    O.addEventListener("click", myClick)

    function checkMax(){
            
        if(counter == 7){
            O.removeEventListener("click", myClick)
            alert("maximum options are set to 6")
        }
    }

})
