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
                    olympiads = olympiads;
                    fillOlympiads(olympiads);
                }
            },
        });
    }
    
}

function fillOlympiads(arr) {
    let olympiadsList = '';
    $('.info-results-olympiads').html("");

    for (let i = 0; i < arr.length; i++) {
        if (i % 2 == 0) {
            olympiadsList += '<div class="row">';
        }

        olympiadsList += '\
        <div class="col-sm-6">\
            <div class="card">\
                <div class="card-body">\
                    <h5 class="card-title text-center">'+arr[i]['OlympiadType']+'</h5>\
                    <ul class="list-group list-group-flush">';

        if (arr[i]['Status'] == 'призёр') {
            olympiadsList += '<li class="list-group-item"><img src="source/podium.png" alt="Победитель"> Призер</li>';
        } else {
            olympiadsList += '<li class="list-group-item"><img src="source/trophy.png" alt="Победитель"> Победитель</li>';
        }

        olympiadsList += '\
                        <li class="list-group-item"><img src="source/bookmark.png" alt="Предмет"> '+arr[i]['Subject']+'</li>\
                        <li class="list-group-item"><img src="source/graduated.png" alt="Класс"> '+arr[i]['Class']+' класс</li>\
                        <li class="list-group-item"><img src="source/calendar.png" alt="Год"> '+arr[i]['Year']+'</li>\
                    </ul>\
                </div>\
            </div>\
        </div>\
        ';
    
        if (i % 2 != 0) {
            olympiadsList += '</div>';
        }
    }
    $('.info-results-olympiads').append(olympiadsList);
}

function sortOlympiads(type, status, subject, grade, year) {
    let sortedArr = new Array();

    if (type) {
        olympiads.forEach(olympiad => {
            if (olympiad['OlympiadType'] == type)
                sortedArr.push(olympiad);
        });
    }
    if (status) {
        if (type) {
            sortedArr = sortedArr.filter(item => item['Status'] == status);
        } else {
            olympiads.forEach(olympiad => {
                if (olympiad['Status'] == status)
                    sortedArr.push(olympiad);
            });
        }
    }
    if (subject) {
        if (type || status) {
            sortedArr = sortedArr.filter(item => item['Subject'] == subject);
        } else {
            olympiads.forEach(olympiad => {
                if (olympiad['Subject'] == subject)
                    sortedArr.push(olympiad);
            });
        }
    }
    if (grade) {
        if (type || status || subject) {
            sortedArr = sortedArr.filter(item => item['Class'] == grade);
        } else {
            olympiads.forEach(olympiad => {
                if (olympiad['Class'] == grade)
                    sortedArr.push(olympiad);
            });
        }
    }
    if (year) {
        if (type || status || subject || grade) {
            sortedArr = sortedArr.filter(item => item['Year'] == year);
        } else {
            olympiads.forEach(olympiad => {
                if (olympiad['Year'] == year)
                    sortedArr.push(olympiad);
            });
        }
    }

    fillOlympiads(sortedArr);
}

function getSelectedValues() {
    sortValues = [
        document.getElementById('menu-type').value,
        document.getElementById('menu-status').value,
        document.getElementById('menu-subject').value,
        document.getElementById('menu-class').value,
        document.getElementById('menu-year').value
    ];
    return sortValues;
}

document.querySelectorAll('.menu').forEach(menu => menu.addEventListener('change', function(){ 
    sortValues = getSelectedValues();
    sortOlympiads(sortValues[0], sortValues[1], sortValues[2], sortValues[3], sortValues[4]);
}));