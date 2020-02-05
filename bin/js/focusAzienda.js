<<<<<<< HEAD
var maxDescriptionChars = 100;
var mansioni = [];

$(document).ready(function(){
  var mansioni = [];
  $.ajax({
    url: "php/admin-api/getAziendaData.php",
    type: "POST",
    data: {
      id: aziendaId
    },
    dataType: "json",
    success: function(data){
      mansioni = data.mansioni;
      if(mansioni.length > 0){
        $("#mansioniTable").append($("<thead>/thead>"));
        $("#mansioniTable > thead").append("<tr></tr>");
        $("#mansioniTable > thead > tr").append("<th>ID</th><th>TITOLO</th>");
        $("#mansioniTable").append($("<tbody>/tbody>"));
        for(var i = 0; i<data.mansioni.length; i++){
          var str = "<tr class=\"mansioneMain\" style=\"cursor: pointer;\">";
          str += "<td><b>" + data.mansioni[i].id + "</b></td>";
          str += "<td>" + data.mansioni[i].titolo + "<i class=\"material-icons\" style='float: right'>arrow_drop_down</i></td>";
          str += "</tr>";
          str += "<tr class=\"mansioneMain\" style=\"display:none;\">";
          str += "<td colspan='2'>" + data.mansioni[i].descrizione + "</td>";
          str += "</tr>";
          $("#mansioniTable > tbody").append(str);
        }
      } else {
        $("#mansioniTable").append($("<p></p>").append($("<i></i>").text("Non sappiamo ancora niente sulle mansioni assegnate da questa azienda...")));
      }

      $("#mansioniTable > tbody > tr.mansioneMain").click(function(){
        switch ($(this).find(".material-icons").text()){
          case "arrow_drop_up":
          $(this).find(".material-icons").text("arrow_drop_down")
          break;
          case "arrow_drop_down":
          $(this).find(".material-icons").text("arrow_drop_up");
          break;
          default: break;
        }
        $(this).next().toggle("slow");
      });
    },
    error: function(richiesta,stato,errori){
      console.log("Error: " + stato);
    }
  });
});


// Descrizione ateco
$(document).ready(function(){
  var codice = $("#codiceAteco").text();
  if(codice != "N/A"){
    $.ajax({
      url: "https://search.codiceateco.it/atecosearch",
      type: "GET",
      crossDomain: true,
      dataType: 'jsonp',
      data: {
        q: codice
      },
      success: function(data){
        var descr = data.hits.hits[0]._source.sottocategoria.titolo;
        $("#descrizioneAteco").text(descr);
      },
      error: function(e){
        console.log(e);
      }
    });
  } else {
    $("#descrizioneAteco").append($("<i></i>").text("Codice Ateco mancante!"));
  }
});

// Data-Editing System
$(document).ready(function(){
  $("div.toEdit, a.toEdit").each(function(){
    var text = $(this).text();
    var row = $("<div></div>").addClass("row valign-wrapper");
    if($(this).attr("id") == "website" && text != "N/A"){
      var url = "//" + text;
      var a_link = $("<a></a>").addClass("website-link").attr({"href": url, "target": "_blank"}).text(text);
      var txt_col = $("<div></div>").addClass("col s10 txt_col").css({"text-align": "left"}).append($("<p></p>").append(a_link));
    } else {
      var txt_col = $("<div></div>").addClass("col s10 txt_col").css({"text-align": "left"}).append($("<p></p>").text(text));
    }
    var ico_col = $("<div></div>").addClass("col s2 ico_col").append($("<i></i>").addClass("material-icons editIcon tiny unselectable").text("edit"));
    row.hover(function(){
      $(this).find("i.material-icons").css({opacity: 0, visibility: "visible"}).animate({opacity: 1}, 200);
    }, function(){
      $(this).find("i.material-icons").css({opacity: 1, visibility: "visible"}).animate({opacity: 0}, 30);
    });
    row.append(ico_col).append(txt_col);
    $(this).html(row);
  });

  $("i.material-icons.editIcon").click(function(){
    if($(this).text() == "edit"){
      $(this).text("check");
      var txt_col = $(this).parent().parent().find("div.txt_col");
      var text = txt_col.text();

      var input = $("<input></input>").attr("placeholder", "inserisci testo...");
      if(text != "N/A"){
        input.val(text)
      }
      txt_col.html(input);
    }
    else if($(this).text() == "check") {
      $(this).text("edit");
      var txt_col = $(this).parent().parent().find("div.txt_col");
      var text = txt_col.children().val();
      if(text == ""){
        text = "N/A";
      }

      if(txt_col.parent().parent().attr("id") == "website"){
        var url = "//" + text;
        var p = $("<p></p>").append($("<a></a>").addClass("website-link").attr({"href": url, "target": "_blank"}).text(text));
      } else {
        var p = $("<p></p>").text(text);
      }

      txt_col.html(p);
    }
  });
});
=======
var maxDescriptionChars = 100;
var mansioni = [];

$(document).ready(function(){
  var mansioni = [];
  $.ajax({
    url: "php/admin-api/getAziendaData.php",
    type: "POST",
    data: {
      id: aziendaId
    },
    dataType: "json",
    success: function(data){
      mansioni = data.mansioni;
      $("#mansioniTable").append($("<thead>/thead>"));
      $("#mansioniTable > thead").append("<tr></tr>");
      $("#mansioniTable > thead > tr").append("<th>ID</th><th>TITOLO</th>");
      $("#mansioniTable").append($("<tbody>/tbody>"));
      for(var i = 0; i<data.mansioni.length; i++){
        var str = "<tr class=\"mansioneMain\" style=\"cursor: pointer;\">";
        str += "<td><b>" + data.mansioni[i].id + "</b></td>";
        str += "<td>" + data.mansioni[i].titolo + "<i class=\"material-icons\" style='float: right'>arrow_drop_down</i></td>";
        str += "</tr>";
        str += "<tr class=\"mansioneMain\" style=\"display:none;\">";
        str += "<td colspan='2'>" + data.mansioni[i].descrizione + "</td>";
        str += "</tr>";
        $("#mansioniTable > tbody").append(str);
      }

      $("#mansioniTable > tbody > tr.mansioneMain").click(function(){
        switch ($(this).find(".material-icons").text()){
          case "arrow_drop_up":
          $(this).find(".material-icons").text("arrow_drop_down")
          break;
          case "arrow_drop_down":
          $(this).find(".material-icons").text("arrow_drop_up");
          break;
          default:
          break;
        }
        $(this).next().toggle("slow");
      });
    },
    error: function(richiesta,stato,errori){
      console.log("Error: " + stato);
    }
  });
});


// Descrizione ateco
$(document).ready(function(){
  var codice = $("#codiceAteco").text();
  if(codice != "N/A"){
    $.ajax({
      url: "https://search.codiceateco.it/atecosearch",
      type: "GET",
      crossDomain: true,
      dataType: 'jsonp',
      data: {
        q: codice
      },
      success: function(data){
        console.log(data.hits.hits[0]._source.sottocategoria.titolo);
        var descr = data.hits.hits[0]._source.sottocategoria.titolo;
        $("#descrizioneAteco").text(descr);
      },
      error: function(e){
        console.log(e);
      }
    });
  }
});
>>>>>>> 32cb4bd6d4bf44266cf5fab89c05a667b0d3602f
