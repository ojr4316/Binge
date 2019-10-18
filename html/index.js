var selectedChat = -1;

function addCard(name, media, platform, when, id) {
  $("#cards").append('<div><div class="custom-column"><img class="card-img-top" src="platforms/' + platform + '.png" alt="Card image cap"><div class="card-body"><h5 class="card-title">'
  + '<a href="user/' + name + '" class="card-title card-title-link">' + name + '</a>' + '</h5><h6 class="card-subtitle mb-2 text-muted">Wants to watch <span class="binge-blue"><b> ' + media +
  '</b> </span> on <span class="text-' + platform + '">'+ platform[0].toUpperCase() +  platform.slice(1) +'</span></h6><p class="card-text">'
  + when + '</p><button id="cardButton' + id + '" onclick="join(' + id + ', `' + name + '`)" class="btn btn-block card-button">Join</button></div></div></div>');
}

function addCardProfile(name, media, platform, when, id) {
  $("#cards").append('<div><div class="custom-column"><img class="card-img-top" src="platforms/' + platform + '.png" alt="Card image cap"><div class="card-body"><h6 class="card-title">'
  + '<a href="user/' + name + '" class="card-title card-title-link">' + name + '</a>' + '</h6><h6 class="card-subtitle mb-2 text-muted">Wants to watch <span class="binge-blue"><b> ' + media +
  '</b> </span> on <span class="text-' + platform + '">'+ platform[0].toUpperCase() +  platform.slice(1) +'</span></h6><p class="card-text">'
  + when + '</p><a href="remove.php?id=' + id + '" class="card-link">Delete</a></div></div></div>');
}

function addCardJoined(name, media, platform, when, id) {
  $("#cards").append('<div><div class="custom-column"><img class="card-img-top" src="platforms/' + platform + '.png" alt="Card image cap"><div class="card-body"><h5 class="card-title">'
  + '<a href="user/' + name + '" class="card-title card-title-link">' + name + '</a>' + '</h5><h6 class="card-subtitle mb-2 text-muted">Wants to watch <span class="binge-blue"><b> ' + media +
  '</b> </span> on <span class="text-' + platform + '">'+ platform[0].toUpperCase() +  platform.slice(1) +'</span></h6><p class="card-text">'
  + when + '</p><button class="btn btn-block card-button disabled">Joined</button></div></div></div>');
}

function addCardRequest(name, media, platform, when, id) {
  $("#cards").append('<div><div class="custom-column"><img class="card-img-top" src="platforms/' + platform + '.png" alt="Card image cap"><div class="card-body"><h5 class="card-title">'
  + '<a href="user/' + name + '" class="card-title card-title-link">' + name + '</a>' + '</h5><h6 class="card-subtitle mb-2 text-muted">Wants to join you to watch <span class="binge-blue"><b> ' + media +
  '</b> </span></h6><p class="card-text">'
  + when + '</p><a href="acceptRequest?user=' + name + '&media=' + media + '&id='
 + id + '"> Accept </a><a href="deleteRequest.php?id=' + id + '" class="float-right"> Deny </a></div></div></div>');
}

$("#chat").submit(function(e) {
  e.preventDefault();
  $.ajax({ url: '/addChat.php',
           data: {'chatId': selectedChat, 'text': $("#textToAdd").val()},
           type: 'POST',
           error:function(exception){alert('Exception:'+exception);}
  });

  $("#textToAdd").val("");
});

function addChatOption(chatId, user) {
  $("#chatSelect").append('<button class="binge-red-bg chat-button mx-1 my-1" onclick="setValue(this)"" value=' + chatId + '> ' + user + '</button>');
}

function update() {
  $.ajax({ url: '/readChat.php',
              type: 'GET',
              data: {'chatId': selectedChat},
              success:function(result){
                if ($("#chatArea").text() != result) {
                  $("#chatArea").text(result);
                  document.getElementById("chatArea").scrollTop = document.getElementById("chatArea").scrollHeight;
                }
                setTimeout(update(), 1000);
              },
              error:function(exception){alert('Exception:'+exception);}
  });
}

function setValue(e) {
  selectedChat = e.value;
  update();
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
                // TODO: Delete thingy!
              },
              error:function(exception){alert('Exception:'+exception);}
  });
}

// TEST STATEMENT addCard("Alyssa", "Tangled", "netflix", "tonight");
