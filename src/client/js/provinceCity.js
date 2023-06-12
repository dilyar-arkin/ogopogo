$(window).on('load',function(){
    
    function autocomplete(inp , arr) {
        
        /*the autocomplete function takes two arguments,
        the text field element and an array of possible autocompleted values:*/
        var currentFocus;
        /*execute a function when someone writes in the text field:*/
        inp.addEventListener("input", function(e) {
            var a, b, i, val = this.value;
            /*close any already open lists of autocompleted values*/
            closeAllLists();
            if (!val) { return false;}
            currentFocus = -1;
            /*create a DIV element that will contain the items (values):*/
            a = document.createElement("DIV");
            a.setAttribute("id", this.id + "autocomplete-list");
            a.setAttribute("class", "autocomplete-items");
            /*append the DIV element as a child of the autocomplete container:*/
            this.parentNode.appendChild(a);
            /*for each item in the array...*/
            for (i = 0; i < arr.length; i++) {
              /*check if the item starts with the same letters as the text field value:*/
              if (arr[i].substr(0, val.length).toUpperCase() == val.toUpperCase()) {
                /*create a DIV element for each matching element:*/
                b = document.createElement("DIV");
                /*make the matching letters bold:*/
                b.innerHTML = "<strong>" + arr[i].substr(0, val.length) + "</strong>";
                b.innerHTML += arr[i].substr(val.length);
                /*insert a input field that will hold the current array item's value:*/
                b.innerHTML += "<input type='hidden' value='" + arr[i] + "'>";
                /*execute a function when someone clicks on the item value (DIV element):*/
                    b.addEventListener("click", function(e) {
                    /*insert the value for the autocomplete text field:*/
                    inp.value = this.getElementsByTagName("input")[0].value;
                    /*close the list of autocompleted values,
                    (or any other open lists of autocompleted values:*/
                    closeAllLists();
                });
                a.appendChild(b);
              }
            }
        });
        /*execute a function presses a key on the keyboard:*/
        inp.addEventListener("keydown", function(e) {
            var x = document.getElementById(this.id + "autocomplete-list");
            if (x) x = x.getElementsByTagName("div");
            if (e.keyCode == 40) {
              /*If the arrow DOWN key is pressed,
              increase the currentFocus variable:*/
              currentFocus++;
              /*and and make the current item more visible:*/
              addActive(x);
            } else if (e.keyCode == 38) { //up
              /*If the arrow UP key is pressed,
              decrease the currentFocus variable:*/
              currentFocus--;
              /*and and make the current item more visible:*/
              addActive(x);
            } else if (e.keyCode == 13) {
              /*If the ENTER key is pressed, prevent the form from being submitted,*/
              e.preventDefault();
              if (currentFocus > -1) {
                /*and simulate a click on the "active" item:*/
                if (x) x[currentFocus].click();
              }
            }
        });
        function addActive(x) {
          /*a function to classify an item as "active":*/
          if (!x) return false;
          /*start by removing the "active" class on all items:*/
          removeActive(x);
          if (currentFocus >= x.length) currentFocus = 0;
          if (currentFocus < 0) currentFocus = (x.length - 1);
          /*add class "autocomplete-active":*/
          x[currentFocus].classList.add("autocomplete-active");
        }
        function removeActive(x) {
          /*a function to remove the "active" class from all autocomplete items:*/
          for (var i = 0; i < x.length; i++) {
            x[i].classList.remove("autocomplete-active");
          }
        }
        function closeAllLists(elmnt) {
          /*close all autocomplete lists in the document,
          except the one passed as an argument:*/
          var x = document.getElementsByClassName("autocomplete-items");
          for (var i = 0; i < x.length; i++) {
            if (elmnt != x[i] && elmnt != inp) {
            x[i].parentNode.removeChild(x[i]);
          }
        }
      }
      /*execute a function when someone clicks in the document:*/
      document.addEventListener("click", function (e) {
          closeAllLists(e.target);
      });
      }
    
    var BC = [
    "Abbotsford",
    "Agassiz",
    "Aldergrove",
    "Aldergrove East",
    "Anmore",
    "Arbutus Ridge",
    "Armstrong",
    "Ashcroft",
    "Barrière",
    "Bowen Island",
    "Burnaby",
    "Burns Lake",
    "Cache Creek",
    "Campbell River",
    "Castlegar",
    "Cedar",
    "Central Coast Regional District",
    "Chase",
    "Chemainus",
    "Chetwynd",
    "Chilliwack",
    "Colwood",
    "Coombs",
    "Coquitlam",
    "Courtenay",
    "Cowichan Bay",
    "Cranbrook",
    "Creston",
    "Cumberland",
    "Dawson Creek",
    "Delta",
    "Denman Island",
    "Denman Island Trust Area",
    "Duck Lake",
    "Duncan",
    "East Wellington",
    "Elkford",
    "Ellison",
    "Enderby",
    "Fairwinds",
    "Fernie",
    "Fort Nelson",
    "Fort St. John",
    "Fraser Valley Regional District",
    "French Creek",
    "Fruitvale",
    "Gibsons",
    "Golden",
    "Grand Forks",
    "Hanceville",
    "Hope",
    "Hornby Island",
    "Houston",
    "Invermere",
    "Kamloops",
    "Kelowna",
    "Kimberley",
    "Kitimat",
    "Ladner",
    "Ladysmith",
    "Lake Cowichan",
    "Langford",
    "Langley",
    "Lillooet",
    "Lions Bay",
    "Logan Lake",
    "Lumby",
    "Mackenzie",
    "Maple Ridge",
    "Merritt",
    "Metchosin",
    "Metro Vancouver Regional District",
    "Mission",
    "Nakusp",
    "Nanaimo",
    "Nelson",
    "New Westminster",
    "North Cowichan",
    "North Oyster/Yellow Point",
    "North Saanich",
    "North Vancouver",
    "Oak Bay",
    "Okanagan",
    "Okanagan Falls",
    "Oliver",
    "Osoyoos",
    "Parksville",
    "Peace River Regional District",
    "Peachland",
    "Pemberton",
    "Penticton",
    "Pitt Meadows",
    "Port Alberni",
    "Port Coquitlam",
    "Port McNeill",
    "Port Moody",
    "Powell River",
    "Prince George",
    "Prince Rupert",
    "Princeton",
    "Puntledge",
    "Quesnel",
    "Regional District of Alberni-Clayoquot",
    "Regional District of Central Okanagan",
    "Revelstoke",
    "Richmond",
    "Rossland",
    "Royston",
    "Salmo",
    "Salmon Arm",
    "Salt Spring Island",
    "Saltair",
    "Sechelt",
    "Sicamous",
    "Six Mile",
    "Smithers",
    "Sooke",
    "South Pender Harbour",
    "Sparwood",
    "Summerland",
    "Surrey",
    "Terrace",
    "Tofino",
    "Trail",
    "Tsawwassen",
    "Tumbler Ridge",
    "Ucluelet",
    "Vancouver",
    "Vanderhoof",
    "Vernon",
    "Victoria",
    "Walnut Grove",
    "Welcome Beach",
    "West End",
    "West Kelowna",
    "West Vancouver",
    "Whistler",
    "White Rock",
    "Williams Lake"]

  var AB = [
    "Airdrie",
    "Athabasca",
    "Banff",
    "Barrhead",
    "Bassano",
    "Beaumont",
    "Beaverlodge",
    "Black Diamond",
    "Blackfalds",
    "Bon Accord",
    "Bonnyville",
    "Bow Island",
    "Brooks",
    "Calgary",
    "Calmar",
    "Camrose",
    "Canmore",
    "Cardston",
    "Carstairs",
    "Chestermere",
    "Claresholm",
    "Coaldale",
    "Coalhurst",
    "Cochrane",
    "Cold Lake",
    "Crossfield",
    "Devon",
    "Didsbury",
    "Drayton Valley",
    "Edmonton",
    "Edson",
    "Elk Point",
    "Fairview",
    "Falher",
    "Fort Macleod",
    "Fort McMurray",
    "Fort Saskatchewan",
    "Fox Creek",
    "Gibbons",
    "Grand Centre",
    "Grande Cache",
    "Grande Prairie",
    "Grimshaw",
    "Hanna",
    "Heritage Pointe",
    "High Level",
    "High Prairie",
    "High River",
    "Hinton",
    "Irricana",
    "Jasper Park Lodge",
    "Killam",
    "Lac La Biche",
    "Lacombe",
    "Lamont",
    "Larkspur",
    "Laurel",
    "Leduc",
    "Lethbridge",
    "Lloydminster",
    "Magrath",
    "Manning",
    "Mannville",
    "Maple Ridge",
    "Mayerthorpe",
    "Medicine Hat",
    "Mill Woods Town Centre",
    "Millet",
    "Morinville",
    "Nanton",
    "Okotoks",
    "Olds",
    "Peace River",
    "Penhold",
    "Picture Butte",
    "Pincher Creek",
    "Ponoka",
    "Provost",
    "Raymond",
    "Red Deer",
    "Rideau Park",
    "Rimbey",
    "Rocky Mountain House",
    "Sexsmith",
    "Sherwood Park",
    "Silver Berry",
    "Slave Lake",
    "Smoky Lake",
    "Spirit River",
    "Springbrook",
    "Spruce Grove",
    "St. Albert",
    "Stettler",
    "Stony Plain",
    "Strathmore",
    "Sundre",
    "Swan Hills",
    "Sylvan Lake",
    "Taber",
    "Tamarack",
    "Three Hills",
    "Tofield",
    "Two Hills",
    "Valleyview",
    "Vegreville",
    "Vermilion",
    "Viking",
    "Vulcan",
    "Wainwright",
    "Wembley",
    "Westlake",
    "Westlock",
    "Wetaskiwin",
    "Whitecourt",
    "Wild Rose"]

    var provinceSelector = document.querySelector(".provinceSelector")
    console.log(provinceSelector.value)
    provinceSelector.addEventListener("change",(event) => {

        var province = event.target.value;
        console.log(province)
    })

    autocomplete(document.getElementById("city"),BC);
    // only BC array is sent for autocomplete, to fix this, province must be verified with other arrays in if statement;
})