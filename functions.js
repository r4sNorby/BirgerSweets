var input;
var colours;

$(document).ready(getSweets());

//////$("#showAll").on("click", function () {
//    var input = "all";
//    $.ajax({
//        url: "search.php",
//        type: "post",
//        data: {
//            input: input
//        },
//        success: function (response) {
//            $("#sweetList").html(response);
//        }
//    });
//});

$(".colours").on("click", function () {
    colours = [];
    if ($(".colours:checked").length > 0) {
        $(".colours:checked").map(function () {
            colours.push($(this).val());
        });
    }
    getSweets();
});

$("#showAll").on("click", function () {
    if ($("#container").css("display") === "none") {
        $("#showAll").text("Skjul Bolcher");
    } else if ($("#container").css("display") === "flex") {
        colours = [];
        if ($(".colours:checked").length > 0) {
            $(".colours:checked").map(function () {
                $(this).prop("checked", false);
            });
        }
        $("#showAll").text("Vis Bolcher");
        if ($("#searchBar").val() !== "") {
            input = "";
            $("#searchBar").val("");
        }
        getSweets();
    }
    $("#container").toggleClass("flexbox");
});

$("#searchBar").on("keyup", function () {
    input = $(this).val();
    getSweets();
});

function getSweets() {
    $.ajax({
        url: "search.php",
        type: "post",
        data: {
            input: input,
            colours: JSON.stringify(colours)
        },
        success: function (response) {
            $("#sweetList").html(response);
        }
    });
}