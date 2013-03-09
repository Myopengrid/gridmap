$(document).ready(function() {

    $("#infodialog").dialog({
            closeOnEscape: true,
            modal: true,
            autoOpen: false,
            width: 400,
            draggable: false,
            title: "Region Details",
            buttons: {
                    "Close": function() {
                            $(this).dialog("close");
                    }
            }
    });

    $("#searchbycoords").dialog({
            closeOnEscape: true,
            modal: true,
            autoOpen: false,
            width: 400,
            draggable: false,
            title: "Zoom to coordinates",
            buttons: {
                    "Cancel": function() {
                            $(this).dialog("close");
                    },
                    "OK": function() {
                            $(this).dialog("close");
                            var x = $("#xcoord").val() | 0;
                            var y = $("#ycoord").val() | 0;

                            $("#map1").gridmap("position", {x: x, y: y});
                    }
            }
    });

    $("#searchbyname").dialog({
            closeOnEscape: true,
            modal: true,
            autoOpen: false,
            width: 400,
            draggable: false,
            title: "Search Region by Name"
    });

    $("#map1").gridmap({
            tooltips: true,
            posx: GRIDMAP_INITIAL_X_COORDENATE,
            posy: GRIDMAP_INITIAL_Y_COORDENATE,
            sizex: 20000,
            sizey: 20000,
            overlays: 0,
            showgrid: true,
            scopeid: "00000000-0000-0000-0000-000000000000",
            user: "00000000-0000-0000-0000-000000000000",
            rclick: function(event, ui) {
                var canbuy = $(ui).children("input").val();
                if (canbuy == "no")
                {
                    $(ui).contextMenu({});
                    $(ui).showMenu(event,
                            {menu: "infomenu"},
                            function(action, el, pos) {
                                var coords = $(el).attr("class");
                                $("#infodialog").load("regioninfo/coords/" + coords + "/scopeid/00000000-0000-0000-0000-000000000000/user/00000000-0000-0000-0000-000000000000", "", function() {
                                    $("#infodialog").dialog("open");
                                });
                            }
                    );
                }
            }
    });

    $("#searchcoords").click(function() {
        $("#xcoord").val("10000");
        $("#ycoord").val("10000");
        $("#searchbycoords").dialog("open");
    });

    function setsearch() {
        $("#searchbyname").dialog("option", "buttons", {
                "Cancel": function() {
                    $(this).dialog("close");
                },
                "OK": function() {
                    var selected = $(".list-selected");
                    if (selected.length < 1) {
                        return;
                    }

                    var x = selected.data("xcoord");
                    var y = selected.data("ycoord");

                    $("#map1").gridmap("position", {x: x, y: y});
                    $(this).dialog("close");
                },
                "Back" : function() {
                    $("#searchbyname").load("search_by_name",
                            "",
                            function(data, status, xs) {
                                setnameentry();
                            }
                    );
                }
        });

        $(".list-selectable").click(function(event, ui) {
            $(".list-selectable").removeClass("list-selected");
            $(this).addClass("list-selected");
            var button = $(".ui-dialog-buttonpane").find("button:contains(OK)");
            button.removeClass("ui-state-disabled");
            button.attr("disabled", false);
        });

        var button = $(".ui-dialog-buttonpane").find("button:contains(OK)");
        button.addClass("ui-state-disabled");
        button.attr("disabled", "true");
    }

    function setnameentry() {
        $("#searchbyname").dialog("option", "buttons", {
                "Cancel": function() {
                    $(this).dialog("close");
                },
                "Search": function() {
                    var name = escape($("#name").val());
                    var scope_id = escape($("#scope_id").val());
                    $("#searchbyname").load("search_by_name/scope_id/"+scope_id+"/name/"+name,
                            "",
                            function(data, status, xs) {
                                setsearch();
                            }
                    );
                }
        });
    }

    $("#searchname").click(function() {
        $("#searchbyname").load("search_by_name",
                "",
                function(data, status, xs) {
                    setnameentry();
                    $("#searchbyname").dialog("open");
                }
        );
    });
});