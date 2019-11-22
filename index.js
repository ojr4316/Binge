var selectedChat = -1;

var isActive = false;
var numLines = 0;
var delay = 0;

// Box Office: Join
function addCard(name, media, id, img, sum) {
  $("#cards").append('<div tabindex="0" id="card' + id + '" class="col col-xl-2 col-lg-3 col-md-4 mb-5 col-12 py-2 mainPageCard card-anim"><div class="view overlay"><img src="https://image.tmdb.org/t/p/w500' + img +
  '" class="img-fluid " alt=""><div class="text-center mask rgba-red-strong d-flex flex-column"><h5 class="text-white m-3"><em><a tabindex="-1" class="text-white" href="user/' + name + '"> ' +
  name + '</a></em> wants to watch <b> ' + media + '</b></h5><p class="white-text m-3 summary">' + sum +
  '</p><button style="background-color: white;" id="cardButton' + id + '" onclick="join(' + id + ', `' + name + '`)" class="btn card-button mt-auto binge-red mb-3">Join</button></div></div></div>');
}

function addPopularCard(name, media, id, img, sum) {
  $("#popular").append('<div tabindex="0" id="card' + id + '" class="col col-xl-2 col-lg-3 col-md-4 col-12 py-2 mainPageCard card-anim"><div class="view overlay"><img src="https://image.tmdb.org/t/p/w500' + img +
  '" class="img-fluid " alt=""><div class="text-center mask rgba-red-strong d-flex flex-column"><h5 class="text-white m-3"><em><a tabindex="-1" class="text-white" href="user/' + name + '"> ' +
  name + '</a></em> wants to watch <b> ' + media + '</b></h5><p class="white-text m-3 summary">' + sum +
  '</p><button style="background-color: white;" id="cardButton' + id + '" onclick="join(' + id + ', `' + name + '`)" class="btn card-button mt-auto binge-red mb-3">Join</button></div></div></div>');
}

// TODO
// FIGURE OUT THIS!
function addMulticard(media, img, sum, amountOfPeople) {
  $("#popular").append('<div tabindex="0" id="card' + media + '" class="col col-xl-2 col-lg-3 col-12 col-md-4 mainPageCard card-anim"><div class="view overlay"><img src="https://image.tmdb.org/t/p/w500' + img +
  '" class="img-fluid " alt=""><div class="text-center mask rgba-red-strong d-flex flex-column"><h5 class="text-white m-3"> ' +
  amountOfPeople + ' people want to watch <b> ' + media + '</b></h5><p class="white-text m-3 summary">' + sum +
  '</p><button style="background-color: white;" id="cardButton' + media + '" onclick="viewOthers(`' + media + '`)" class="btn card-button mt-auto binge-red mb-3">View others</button></div></div></div>');
}

function addImageCards(name, src) {
  $("#popular").append('<div tabindex="0" class="col col-xl-2 col-lg-3 col-12 col-md-4 mainPageCard card-anim"><img src="uploads/' + src + '"></img></div>');
}

// Profile: Delete
function addCardProfileYours(name, media, id, img, sum) {
  $("#cards").append('<div tabindex="0" id="card' + id + '" class="col col-xl-4 col-lg-5 col-md-6 col-12 py-2 mainPageCard card-anim"><div class="view overlay"><img src="https://image.tmdb.org/t/p/w500' + img +
  '" class="img-fluid " alt=""><div class="text-center mask rgba-red-strong d-flex flex-column"><h5 class="text-white m-3"><em><a tabindex="-1" class="text-white" href="user/' + name + '"> ' +
  name + '</a></em> wants to watch <b> ' + media + '</b></h5><button style="background-color: white;" id="cardButton' + id + '" onclick="deleteTicket(' + id +
  ')" class="btn card-button mt-auto binge-red mb-3">Delete</button></div></div></div>');
}

// Profile: Not your profile
function addCardProfile(name, media, id, img, sum) {
  $("#cards").append('<div tabindex="0" id="card' + id + '" class="col col-xl-4 col-lg-5 col-md-6 col-12 py-2 mainPageCard card-anim"><div class="view overlay"><img src="https://image.tmdb.org/t/p/w500' + img +
  '" class="img-fluid " alt=""><div class="text-center mask rgba-red-strong d-flex flex-column"><h5 class="text-white m-3"><em><a tabindex="-1" class="text-white" href="user/' + name + '"> ' +
  name + '</a></em> wants to watch <b> ' + media + '</b></h5><p class="white-text m-3 summary">' + sum +
  '</p><button style="background-color: white;" id="cardButton' + id + '" onclick="join(' + id + ', `' + name + '`)" class="btn card-button mt-auto binge-red mb-3">Join</button></div></div></div>');
}

// Profile: Watched (Yours)
function addWatchedYours(id, title, img) {
  $("#watched").append('<div id="watched'+id+'" tabindex="0" class="col col-xl-4 col-lg-5 col-md-6 col-12 py-2 mainPageCard card-anim"><div class="view overlay"><img src="https://image.tmdb.org/t/p/w500' + img +
  '" class="img-fluid " alt=""><div class="text-center mask rgba-red-strong d-flex flex-column"><h5 class="text-white m-3"><b> ' + title + '</b></h5><button style="background-color: white;" onclick="deleteWatched(' + id +
  ')" class="btn card-button mt-auto binge-red mb-3">Delete</button></div></div></div>');
}

// Profile: Watched
function addWatched(id, title, img) {
  $("#watched").append('<div tabindex="0" class="col col-xl-4 col-lg-5 col-md-6 col-12 py-2 mainPageCard card-anim"><div class="view overlay"><img src="https://image.tmdb.org/t/p/w500' + img +
  '" class="img-fluid " alt=""><div class="text-center mask rgba-red-strong d-flex flex-column"><h5 class="text-white m-3"><b> ' + title + '</b></h5><button style="background-color: white;" onclick="watched(' + id + ', `' + name + '`, `' + img +
  '`)" class="btn card-button mt-auto binge-red mb-3">Already watched</button></div></div></div>');
}

// Box Office: Ticket you created
function addYourCard(name, media, id, img, sum) {
  $("#cards").append('<div tabindex="0" id="card' + id + '" class="col col-xl-2 col-lg-3 col-md-4 mb-5 col-12 py-2 mainPageCard card-anim"><div class="view overlay"><img src="https://image.tmdb.org/t/p/w500' + img +
  '" class="img-fluid " alt=""><div class="text-center mask rgba-red-strong d-flex flex-column"><h5 class="text-white m-3"><em><a tabindex="-1" class="text-white" href="user/' + name + '"> ' +
  name + '</a></em> wants to watch <b> ' + media + '</b></h5><p class="white-text m-3 summary">' + sum +
  '</p><button style="background-color: white;" id="cardButton' + id + '" onclick="deleteTicket(' + id +
  ')" class="btn card-button mt-auto binge-red mb-3">Delete</button></div></div></div>');
}

// Box Office: Ticket you joined
function addCardJoined(name, media, id, img, sum) {
  $("#cards").append('<div tabindex="0" id="card' + id + '" class="col col-xl-2 col-lg-3 col-md-4 mb-5 col-12 py-2 mainPageCard card-anim"><div class="view overlay"><img src="https://image.tmdb.org/t/p/w500' + img +
  '" class="img-fluid " alt=""><div class="text-center mask rgba-red-strong d-flex flex-column"><h5 class="text-white m-3"><em><a tabindex="-1" class="text-white" href="user/' + name + '"> ' +
  name + '</a></em> wants to watch <b> ' + media + '</b></h5><p class="white-text m-3 summary">' + sum +
  '</p><button style="background-color: white;" id="cardButton' + id + '" class="btn card-button mt-auto binge-red mb-3 disabled">Joined</button></div></div></div>');
}

// Ticket
function addCardRequest(name, media, id, img, sum) {
  $("#cards").append('<div tabindex="0" id="card' + id + '" class="col col-xl-2 col-lg-3 col-md-4 mb-5 col-12 py-2 mainPageCard card-anim"><div class="view overlay"><img src="https://image.tmdb.org/t/p/w500' + img +
  '" class="img-fluid " alt=""><div class="text-center mask rgba-red-strong d-flex flex-column"><h5 class="text-white m-3"> ' +
  name + ' wants to watch <b> ' + media + '</b></h5><p class="white-text m-3 summary">' + sum +
  '</p><div class="mt-auto mb-3"><button style="background-color: white;" id="cardButton' + id +
  '" onclick="acceptRequest(`' + name + '`, `' + media + '`, ' + id +
  ')" class="btn card-button binge-red">Accept</button><button style="background-color: white;" id="cardButton' + id +
  '" onclick="deleteRequest(' + id + ')" class="btn card-button binge-red">Deny</button></div></div></div></div>');

}

// Add to watched list (shown on profile)
function watched(id, name, img) {
  chosen = true;
  $.ajax({ url: '/addWatched.php',
           data: {'id': id, 'name': name, 'img': img},
           type: 'POST',
           success: function(r) { chosen = false; },
           error:function(exception){alert('Exception:'+exception);}
  });
}

// Send Chat Message
$("#chat").submit(function(e) {
  e.preventDefault();
  if ($("#textToAdd").val().trim() !== "") {
  $.ajax({ url: '/addChat.php',
           data: {'chatId': selectedChat, 'text': $("#textToAdd").val()},
           type: 'POST',
           error:function(exception){alert('Exception:'+exception);}
  });
  }
  $("#textToAdd").val("");
});

// Add button to open chat with other user
function addChatOption(chatId, user) {
  if (chatId == selectedChat) {
    $("#chatSelect").append('<button id="chatOption' + chatId + '" class="binge-red-bg disabled chat-button mx-1 my-1" onclick="setValue(this)"" value=' +
    chatId + '> ' + user + '</button>');
  } else {
    $("#chatSelect").append('<button id="chatOption' + chatId + '" class="binge-red-bg chat-button mx-1 my-1" onclick="setValue(this)"" value=' +
    chatId + '> ' + user + '</button>');
  }
}

function removeExtra() {
    if ($("#popular").children().length === 0) {
        $("#popularLabel").remove();
    }

    if ($("#cards").children().length === 0){
        $("#nearYouLabel").remove();
    }
}

function removeExtraProfile() {
    if ($("#cards").children().length === 0) {
        $("#watchLabel").remove();
    }

    if ($("#watched").children().length === 0){
        $("#watchedLabel").remove();
    }
}

// Update Chat
function update() {
  setInterval(function () {
    if (isActive) { return; }
    isActive = true;
    try {
      $.ajax({ url: '/readChat.php',
                  type: 'GET',
                  data: {'chatId': selectedChat},
                  success:function(result){
                    $("#chatArea").html(result);

                    if (numLines != result.split("</b>"|"</p>").length) {
                      document.getElementById("chatArea").scrollTop = document.getElementById("chatArea").scrollHeight;
                      numLines = result.split("</b>"|"</p>").length;
                    }

                    isActive = false;
                  }
                });
    } catch (ex) { isActive = false;}
  }, 200);
}

// Used for setting chat partner
function setValue(e) {
  $("#chatOption" + selectedChat).removeClass("disabled");
  selectedChat = e.value;
  $("#chatOption" + selectedChat).addClass("disabled");
}

// Used for setting chat partner integer
function setValueI(i) {
  $("#chatOption" + selectedChat).removeClass("disabled");
  selectedChat = i;
  $("#chatOption" + selectedChat).addClass("disabled");
}

// Create a join request
function join(id, name) {
  $.ajax({ url: '/join.php',
              type: 'GET',
              data: {'id': id, 'showTo': name},
              success:function(result){
                $("#cardButton" + id).addClass("disabled");
                $("#cardButton" + id).text("Joined");
              },
              error:function(exception){alert('Exception:'+exception);}
  });
}

// Accept a join request
function acceptRequest(user, media, id) {
  $.ajax({ url: '/acceptRequest.php',
              type: 'GET',
              data: {'user': user, 'media': media, "id": id},
              success:function(result){
                $("#card" + id).remove();
              },
              error:function(exception){alert('Exception:'+exception);}
  });
  $(".badge").text($(".badge").text() - 1);
}

// Deny request (NOT DELETE REQUEST FOR CANCELING)
function deleteRequest(id) {
   $.ajax({ url: '/deleteRequest.php',
              type: 'GET',
              data: {"id": id},
              success:function(result){
                $("#card" + id).remove();
              },
              error:function(exception){alert('Exception:'+exception);}
  });
  $(".badge").text($(".badge").text() - 1);
}

// Delete a ticket
function deleteTicket(id) {
  $.ajax({ url: '/remove.php',
              type: 'GET',
              data: {"id": id},
              success:function(result){
                $("#card" + id).remove();
                resizeTickets();
              },
              error:function(exception){alert('Exception:'+exception);}
  });
}

// Delete watched
function deleteWatched(id) {
  $.ajax({ url: '/removeWatched.php',
              type: 'GET',
              data: {"id": id},
              success:function(result){
                $("#watched" + id).remove();
                resizeTickets();
              },
              error:function(exception){alert('Exception:'+exception);}
  });
}

/* Util function that needs to be editted that is always supposed
to keep tickets readable */
function resizeTickets() {
  if ($("#cards").children().length < 2) {
    $("#cards").children().removeClass("col-xl-2 col-lg-3 col-md-4");
    $("#cards").children().addClass("col-lg-8");
  }

  if ($("#watched").children().length < 2) {
    $("#watched").children().removeClass("col-xl-2 col-lg-3 col-md-4");
    $("#watched").children().addClass("col-lg-8");
  }
}
