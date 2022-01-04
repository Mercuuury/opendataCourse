let idParam = (new URL(document.location)).searchParams.get("id");
let olympiads = new Array();
window.onload = function() {
    getOlympiads();

}

function getOlympiads() {
    if (idParam && idParam != 'undefined') {
        $.ajax({
            type: "POST", 
            url: "olympiads.php",
            data: {
                id: idParam
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
                    visualizePieChart(olympiads);
                    visualizeAreaChart(olympiads);
                }
            },
        });
    }
}

function fillOlympiads(arr) {
    let olympiadsList = '';
    $('.info-results-olympiads').html("");

    if (arr.length == 0) {
        olympiadsList += '<p>В базе данных не нашлось результатов для данного учреждения.</p>';
    } else {
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
    }

    if (arr.length > 4) {
        olympiadsList += '\
        <div class="d-flex justify-content-center mb-3">\
            <a class="showMore">\
                <img id="down-arrow" width="50px" src="source/arrow.png" alt="arrow">\
            </a>\
        </div>\
        ';
        $('.info-results-olympiads').append(olympiadsList);
        hideAfter4();
        document.querySelector('.showMore').onclick = function() {
            showAll();
        };
    } else {
        $('.info-results-olympiads').append(olympiadsList);
    }
}

function sortOlympiads(type, status, subject, grade, year) {
    let sortedArr = new Array();

    if (!type && !status && !subject && !grade && !year) {
        sortedArr = olympiads;
    }

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

function hideAfter4() {
    let i = 0;
    (document.querySelectorAll('.card')).forEach(card => {
        if (i > 3) {
            card.classList.add('d-none');
        }
        i++;
    });
}

function showAll() {
    (document.querySelectorAll('.card.d-none')).forEach(card => {
        card.classList.remove('d-none');
    });
    document.querySelector('.showMore').parentNode.removeChild(document.querySelector('.showMore'));
}

function visualizePieChart(arr) {
    if (arr.length == 0) {
        return;
    }
    let winners = 0;
    let prizeWinners = 0;
    arr.forEach(olympiad => {
        if (olympiad['Status'] == 'призёр')
            prizeWinners++;
        else
            winners++;
    });

    google.charts.load('current', {'packages':['corechart']});
    google.charts.setOnLoadCallback(drawChart);
    function drawChart() {
        var data = google.visualization.arrayToDataTable([
            ['Призовое место', 'Количество занятых мест'],
            ['Победитель', winners],
            ['Призер', prizeWinners]
        ]);

        var options = {
            title: 'Количество занятых призовых мест',
            legend: {position: 'top'},
            pieHole: 0.4,
            height: 400,
            pieSliceTextStyle: {color: 'black'},
            pieSliceBorderColor: 'transparent',
            backgroundColor: '#D9EFE2',
            fontName: 'Noto Sans Light',
            colors: ['#FECE00', '#DAD8DB'],
        };

      var chart = new google.visualization.PieChart(document.getElementById('piechart_div'));
      chart.draw(data, options);
    }
}

function visualizeAreaChart(arr) {
    if (arr.length == 0) {
        return;
    }
    function unique(arr) {
        let result = [];
        for (let str of arr) 
            if (!result.includes(str['Year'])) 
                result.push(str['Year']);
        return result;
    }

    dataArr = [['Год', 'Победитель', 'Призер']];
    unique(arr).forEach(year => {
        let winners = 0;
        let prizeWinners = 0;
        arr.forEach(olympiad => {
            if (olympiad['Year'] == year && olympiad['Status'] == 'призёр')
                prizeWinners++;
            else if (olympiad['Year'] == year && olympiad['Status'] == 'победитель')
                winners++;
        });
        dataArr.push([year, winners, prizeWinners]);
    });

    google.charts.load('current', {'packages':['corechart']});
    google.charts.setOnLoadCallback(drawChart);

    function drawChart() {
        var data = google.visualization.arrayToDataTable(dataArr);

        var options = {
            title: 'Занятые призовые места по годам участия',
            hAxis: {title: 'Год',  titleTextStyle: {color: '#333'}},
            vAxis: {title: 'Количество призовых мест',  titleTextStyle: {color: '#333'}, minValue: 0},
            legend: {position: 'top'},
            height: 400,
            backgroundColor: '#D9EFE2',
            fontName: 'Noto Sans Light',
            colors: ['#FECE00', '#DAD8DB'],
        };

      var chart = new google.visualization.AreaChart(document.getElementById('areachart_div'));
      chart.draw(data, options);
    }
}

$(window).resize(function(){
    visualizePieChart(olympiads);
    visualizeAreaChart(olympiads);
});