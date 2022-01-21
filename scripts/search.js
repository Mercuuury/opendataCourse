let searchBtn = document.getElementById("search-btn");

$(document).ready(function () {
    if(document.getElementById('main-info'))
        document.getElementById('main-info').scrollIntoView();

    $("#search").keyup(function () {
        let name = $("#search").val();
        if (name === "") {
            $("#autocomplete-list").html("");
            document.getElementById("search-btn").classList.remove("btn-shadow");
        } else {
            $.ajax({
                type: "POST", 
                url: "liveSearch.php",
                data: {
                    search: name,
                },
                success: function (response) {
                    $("#autocomplete-list").html(response).show();
                },
            });
        }
    });
});

function fill(Value) {
    $("#search").val(Value); 
    $("#autocomplete-list").hide();
    searchBtn.classList.add("btn-shadow");
    searchBtn.dataset.id = event.target.dataset.id;
}

searchBtn.onclick = function () {
    window.open(`index.php?id=${searchBtn.dataset.id}`, "_self");
}

