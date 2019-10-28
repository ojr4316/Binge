<?php
$page = "create";
include("pageSetup.php");
?>

<div class="container">
  <div class="binge-white-box p-3 mt-3 text-center">
  <h3> Ticket Creation </h3>
  <h5> Search for what you want to watch </h5>
  <input style="font-size: 1.5em;" id="find" type="text" autofocus></input>
  <h6 class="mt-1"> Choose what you want to watch by clicking </h6>
  </div>
  <div id="movieCards" class="row m-3"></div>
</div>
</body>
<script>

var chosen = false; // Has selected a card
var delay = 0; // Animation delay for cards

// Select media, input into database, and go back to main page
function chooseMedia(id, name, desc, img) {
  chosen = true;
  $.ajax({ url: '/add.php',
           data: {'id': id, 'name': name, 'desc': desc, 'img': img},
           type: 'POST',
           success: function(r) { setTimeout(function() {
             $("#movieCards").empty();
             window.location.href = "/";
           }, 500);},
           error:function(exception){alert('Exception:'+exception);}
  });
}

// Load input string from MovieDB
$('#find').on('keypress', function (e) {
        if(e.which === 13){ // Enter Key
          if ($("#find").val().length > 0) {
            $("#movieCards").empty();
            chosen = false;
            delay = 0;
            $.ajax({ url: 'https://api.themoviedb.org/3/search/multi?api_key=1e94de5ed2dc8e3c7ef6674f1d7b6822&language=en-US&region=US&query=' + $("#find").val() + '&page=1&include_adult=false',
              type: 'GET',
              success:function(r){
                for (var i = 0; i < r.results.length; i++) {
                  if (r.results[i].media_type == "tv" || r.results[i].media_type == "movie") {
                  var name = "";
                  var desc = "";
                  var pic = "";
                  if (r.results[i].title != null){
                  name = r.results[i].title;
                  } else {
                  name = r.results[i].name;
                  }
                  pic = r.results[i].poster_path;
                  desc = r.results[i].overview;

                  if (name != "" && pic != "" && desc != "" && name != null && pic != null && desc != null) {
                    $("#movieCards").append('<div tabindex="0" data-pic="' + pic + '" data-desc="' + desc + '" data-name="' + name + '" data-id=' + r.results[i].id + ' class="col col-lg-3 col-12 py-2 mediaCard card-anim" style="animation-delay:' + delay + 'ms;"><div class="view overlay"><img src="https://image.tmdb.org/t/p/w500' + pic +
                    '" class="img-fluid " alt=""><div class="text-center mask rgba-red-strong d-flex flex-column"><h5 class="text-white m-3"> ' + name + '</h5><p class="white-text m-3 summary">' + desc +
                    '</p></div></div></div>');
                    delay += 100;
                }
                }
              }
              },
              error:function(exception){alert('Exception:'+exception);}
  });
}
}
// Make result cards clickable
$('#movieCards').on('click', '*', function(e) {
  if (!chosen) {
  e.preventDefault();
  e.stopPropagation();
  chooseMedia($(".mediaCard").data("id"), $(".mediaCard").data("name"), $(".mediaCard").data("desc"), $(".mediaCard").data("pic"));
}
});
});

$(document).ready(function() {
  // Load currently showing movies
  $.ajax({ url: 'https://api.themoviedb.org/3/movie/now_playing?api_key=1e94de5ed2dc8e3c7ef6674f1d7b6822&language=en-US&page=1',
    type: 'GET',
    success:function(r){
      for (var i = 0; i < r.results.length; i++) {
        var name = r.results[i].title;;
        var desc = desc = r.results[i].overview;;
        var pic = r.results[i].poster_path;
        $("#movieCards").append('<div tabindex="0" data-pic="' + pic + '" data-desc="' + desc + '" data-name="' + name + '" data-id=' + r.results[i].id + ' class="col col-lg-3 col-12 py-2 mediaCard card-anim" style="animation-delay:' + delay + 'ms;"><div class="view overlay"><img src="https://image.tmdb.org/t/p/w500' + pic + '" class="img-fluid " alt=""><div class="text-center mask rgba-red-strong d-flex flex-column"><h5 class="text-white m-3"> ' + name + '</h5><p class="white-text m-3 summary">' + desc + '</p></div></div></div>')
        delay += 100;
      }
    },
    error:function(exception){alert('Exception:'+exception);}
});
// Make Cards Clickable
$('#movieCards').on('click', '*', function(e) {
  if (!chosen) {
  e.preventDefault();
  e.stopPropagation();
  chooseMedia($(this).closest('.mediaCard').eq(0).data("id"), $(this).closest('.mediaCard').eq(0).data("name"), $(this).closest('.mediaCard').eq(0).data("desc"), $(this).closest('.mediaCard').eq(0).data("pic"));
  $(this).closest('.mediaCard').eq(0).addClass("scale-out-center");
}
});
});

</script>

</html>
