var selectedChat = -1;

var isActive = false;
var numLines = 0;
var delay = 0;

// Box Office: Join
function addCard(name, media, when, id, img, sum) {
  //$("#cards").append('<div class="col py-2"><div class="mainPageCard card h-100"><div class="card-body"><h5 class="card-title"><a href=user/' + name + '>' + name + '</a></h5><p class="card-text">Wants to watch <b>' + media + '</b></p><p class="card-text">' + when + '</p><button id="cardButton' + id + '" onclick="join(' + id + ', `' + name + '`)" class="btn btn-block card-button">Join</button></div></div></div>');
  delay += 50;
  $("#cards").append('<div tabindex="0" id="card' + id + '" class="col col-lg-2 mb-5 pb-5 col-12 py-2 mainPageCard card-anim" style="animation-delay:' + delay +
  'ms;"><div class="view overlay"><img src="https://image.tmdb.org/t/p/w500' + img +
  '" class="img-fluid " alt=""><div class="text-center mask rgba-red-strong d-flex flex-column"><h5 class="text-white m-3"><em><a tabindex="-1" class="text-white" href="user/' + name + '"> ' +
  name + '</a></em> wants to watch <b> ' + media + '</b></h5><p class="white-text m-3 summary">' + sum +
  '</p><button style="background-color: white;" id="cardButton' + id + '" onclick="join(' + id + ', `' + name + '`)" class="btn card-button mt-auto binge-red mb-3">Join</button></div></div></div>');
}

// Profile: Delete
function addCardProfile(name, media, when, id, img, sum) {
  //$("#cards").append('<div id="card' + id + '" class="col py-2"><div class="card h-100"><div class="card-body"><h5 class="card-title">' + name + '</h5><p class="card-text">Wants to watch <b>' + media + '</b></p><p class="card-text">' + when + '</p><button id="cardButton' + id + '" onclick="deleteTicket(' + id + ')" class="btn btn-block card-button">Delete</button></div></div></div>');
  $("#cards").append('<div tabindex="0" id="card' + id + '" class="col col-lg-2 col-12 py-2 mainPageCard card-anim"><div class="view overlay"><img src="https://image.tmdb.org/t/p/w500' + img +
  '" class="img-fluid " alt=""><div class="text-center mask rgba-red-strong d-flex flex-column"><h5 class="text-white m-3"> ' +
  name + ' wants to watch <b> ' + media + '</b></h5><p class="white-text m-3 summary">' + sum +
  '</p><button style="background-color: white;" id="cardButton' + id + '" onclick="deleteTicket(' + id +
  ')" class="btn card-button mt-auto binge-red mb-3">Delete</button></div></div></div>');
}

// Box Office: Ticket you created
function addYourCard(name, media, when, id, img, sum) {
  delay += 50;
  //$("#cards").append('<div id="card' + id + '" class="col py-2"><div class="mainPageCard card h-100"><div class="card-body"><h5 class="card-title"><a href=user/' + name + '>' + name + '</a></h5><p class="card-text">Wants to watch <b>' + media + '</b></p><p class="card-text">' + when + '</p><button id="cardButton' + id + '" onclick="deleteTicket(' + id + ')" class="btn btn-block card-button">Delete</button></div></div></div>');
  $("#cards").append('<div tabindex="0" id="card' + id + '" class="col col-lg-2 mb-5 pb-5 col-12 py-2 mainPageCard card-anim" style="animation-delay:' + delay +
  'ms;"><div class="view overlay"><img src="https://image.tmdb.org/t/p/w500' + img +
  '" class="img-fluid " alt=""><div class="text-center mask rgba-red-strong d-flex flex-column"><h5 class="text-white m-3"><em><a tabindex="-1" class="text-white" href="user/' + name + '"> ' +
  name + '</a></em> wants to watch <b> ' + media + '</b></h5><p class="white-text m-3 summary">' + sum +
  '</p><button style="background-color: white;" id="cardButton' + id + '" onclick="deleteTicket(' + id +
  ')" class="btn card-button mt-auto binge-red mb-3">Delete</button></div></div></div>');

}

// Box Office: Ticket you joined
function addCardJoined(name, media, when, id, img, sum) {
  delay += 50;
  $("#cards").append('<div tabindex="0" id="card' + id + '" class="col col-lg-2 mb-5 pb-5 col-12 py-2 mainPageCard card-anim" style="animation-delay:' + delay +
  'ms;"><div class="view overlay"><img src="https://image.tmdb.org/t/p/w500' + img +
  '" class="img-fluid " alt=""><div class="text-center mask rgba-red-strong d-flex flex-column"><h5 class="text-white m-3"><em><a tabindex="-1" class="text-white" href="user/' + name + '"> ' +
  name + '</a></em> wants to watch <b> ' + media + '</b></h5><p class="white-text m-3 summary">' + sum +
  '</p><button style="background-color: white;" id="cardButton' + id + '" class="btn card-button mt-auto binge-red mb-3 disabled">Joined</button></div></div></div>');
}

// Ticket
function addCardRequest(name, media, when, id, img, sum) {
  $("#cards").append('<div tabindex="0" id="card' + id + '" class="col col-lg-2 mb-5 pb-5 col-12 py-2 mainPageCard card-anim"><div class="view overlay"><img src="https://image.tmdb.org/t/p/w500' + img +
  '" class="img-fluid " alt=""><div class="text-center mask rgba-red-strong d-flex flex-column"><h5 class="text-white m-3"> ' +
  name + ' wants to watch <b> ' + media + '</b></h5><p class="white-text m-3 summary">' + sum +
  '</p><div class="mt-auto mb-3"><button style="background-color: white;" id="cardButton' + id +
  '" onclick="acceptRequest(`' + name + '`, `' + media + '`, ' + id +
  ')" class="btn card-button binge-red">Accept</button><button style="background-color: white;" id="cardButton' + id +
  '" onclick="deleteRequest(' + id + ')" class="btn card-button binge-red">Deny</button></div></div></div></div>');

}

$("#chat").submit(function(e) {
  e.preventDefault();
  if ($("#textToAdd").val().trim() != "") {
  $.ajax({ url: '/addChat.php',
           data: {'chatId': selectedChat, 'text': $("#textToAdd").val()},
           type: 'POST',
           error:function(exception){alert('Exception:'+exception);}
  });
  }
  $("#textToAdd").val("");
});

function addChatOption(chatId, user) {
  $("#chatSelect").append('<button class="binge-red-bg chat-button mx-1 my-1" onclick="setValue(this)"" value=' + chatId + '> ' + user + '</button>');
}

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

function setValue(e) {
  selectedChat = e.value;
}

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

function resizeTickets() {
  if ($("#cards").children().length < 2) {
    $("#cards").children().removeClass("col-lg-2");
    $("#cards").children().addClass("col-lg-8");
  }
}
