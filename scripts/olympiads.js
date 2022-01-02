let idParam = (new URL(document.location)).searchParams.get("id");
let olympiads = new Array();
window.onload = function() {
    getOlympiads();

}

function getOlympiads() {
    if (idParam) {
        $.ajax({
            type: "POST", 
            url: "olympiads.php",
            data: {
                id: idParam,
                search: name,
            },
            success: function (response) {
                if (response == 'no id') {
                    console.log("no id");
                } else {
                    (JSON.parse(response)).forEach(element => {
                        olympiads.push(element);
                    });
                    fillOlympiads(olympiads);
                }
            //   $("#autocomplete-list").html(response).show();
            },
        });
    }
    
}

function fillOlympiads(arr) {
    olympiads = arr;
    let olympiadsList = '';

    for (let i = 0; i < olympiads.length; i++) {
        if (i % 2 == 0) {
            olympiadsList += '<div class="row">';
        }

        olympiadsList += '\
        <div class="col-sm-6">\
            <div class="card">\
                <div class="card-body">\
                    <h5 class="card-title text-center">'+olympiads[i]['OlympiadType']+'</h5>\
                    <ul class="list-group list-group-flush">';

        if (olympiads[i]['Status'] == 'призёр') {
            olympiadsList += '<li class="list-group-item"><img src="source/podium.png" alt="Победитель"> Призер</li>';
        } else {
            olympiadsList += '<li class="list-group-item"><img src="source/trophy.png" alt="Победитель"> Победитель</li>';
        }

        olympiadsList += '\
                        <li class="list-group-item"><img src="source/bookmark.png" alt="Предмет"> '+olympiads[i]['Subject']+'</li>\
                        <li class="list-group-item"><img src="source/graduated.png" alt="Класс"> '+olympiads[i]['Class']+' класс</li>\
                        <li class="list-group-item"><img src="source/calendar.png" alt="Год"> '+olympiads[i]['Year']+'</li>\
                    </ul>\
                </div>\
            </div>\
        </div>\
        ';
    
        if (i % 2 != 0) {
            olympiadsList += '</div>';
        }
    }
    $('.info-results').append(olympiadsList);
}
