<?php
$page = "create";
include("pageSetup.php");
?>

<div class="container">
    <div id="movieCards" class="row m-3"></div>
</div>

</body>
<script src="index.js"></script>
<script>

    var chosen = false; // Has selected a card
    var delay = 0; // Animation delay for cards

    // Select media, input into database, and go back to main page
    function chooseMedia(id, name, desc, img) {
        chosen = true;
        $.ajax({
            url: '/add.php',
            data: {'id': id, 'name': name, 'desc': desc, 'img': img},
            type: 'POST',
            success: function (r) {
                setTimeout(function () {
                    $("#movieCards").empty();
                    window.location.href = "/";
                }, 500);
            },
            error: function (exception) {
                alert('Exception:' + exception);
            }
        });
    }

    function getUrlVars() {
        var vars = [], hash;
        var hashes = window.location.href.slice(window.location.href.indexOf('?') + 1).split('&');
        for(var i = 0; i < hashes.length; i++)
        {
            hash = hashes[i].split('=');
            vars.push(hash[0]);
            vars[hash[0]] = hash[1];
        }
        return vars;
    }

    $(document).ready(function () {
        $("#movieCards").empty();
        chosen = false;
        delay = 0;
        $.ajax({
            url: '/movieGet.php',
            type: 'GET',
            data: {"query": getUrlVars()["q"]},
            success: function (results) {
                const r = JSON.parse(results);
                for (let i = 0; i < r.length; i++) {
                    let name = r[i].title;
                    let desc = r[i].overview;
                    let pic = r[i].poster_path;

                    if (name !== "" && pic !== "" && desc !== "" && name != null && pic != null && desc != null) {
                        $("#movieCards").append('<div tabindex="0" id="card' + r[i].id + '" class="col col-xl-3 col-lg-4 col-md-5 col-12 py-2 mainPageCard card-anim" style="animation-delay:' + delay +
                            'ms;"><div class="view overlay"><img src="https://image.tmdb.org/t/p/w500' + pic +
                            '" class="img-fluid " alt=""><div class="text-center mask rgba-red-strong d-flex flex-column"><h5 class="text-white m-3"><b> ' + name + '</b></h5><p class="white-text m-3 summary">' + desc +
                            '</p><button style="background-color: white;" id="cardButton' + r[i].id +
                            '" onclick="watched(' + r[i].id + ', `' + name + '`, `' + pic +
                            '`)" class="btn card-button mt-auto binge-red mb-3">Already watched</button><button style="background-color: white;" id="cardButton' + r[i].id +
                            '" onclick="chooseMedia(' + r[i].id + ', `' + name + '`, `' + desc + '`, `' + pic +
                            '`)" class="btn card-button mt-auto binge-red mb-3">Want to watch</button></div></div></div>');
                        delay += 100;
                    }
                }
                $("#find").val("");
            },
            error: function (exception) {
                alert('Exception:' + exception);
            }
        });
    });
</script>
</html>
