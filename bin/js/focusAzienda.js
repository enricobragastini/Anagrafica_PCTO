var maxDescriptionChars = 100;
var mansioni = [];

// Mansioni
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
  var codice = $("#cod_ateco").text();
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
    if(text == "" || text == null){
      text == "N/A";
    }
    var row = $("<div></div>").addClass("row valign-wrapper");
    if($(this).attr("id") == "sito" && text != "N/A"){
      var url = "//" + text;
      var a_link = $("<a></a>").addClass("website-link").attr({"href": url, "target": "_blank"}).text(text);
      var txt_col = $("<div></div>").addClass("col s10 txt_col").css({"text-align": "left"}).append($("<p></p>").append(a_link));
    }
    else {
      var txt_col = $("<div></div>").addClass("col s10 txt_col").css({"text-align": "left"}).append($("<p></p>").text(text));
    }
    var ico_col = $("<div></div>").addClass("col s2 ico_col").append($("<i></i>").addClass("material-icons editIcon tiny unselectable").text("edit"));
    row.hover(function(){
      $(this).find("div.ico_col i.material-icons").css({opacity: 0.2, visibility: "visible"}).animate({opacity: 1}, 200);
    }, function(){
      $(this).find("div.ico_col i.material-icons").css({opacity: 1, visibility: "visible"}).animate({opacity: 0.2}, 30);
    });
    row.append(ico_col).append(txt_col);
    $(this).html(row);
  });

  $("i.material-icons.editIcon").click(function(){  //Click sull'icona di modifica
    if($(this).text() == "edit"){                   // se l'icona è "per modificare"
      $(this).text("check");
      var txt_col = $(this).parent().parent().find("div.txt_col");
      var text = txt_col.find("p").contents().not(txt_col.find("p").children()).text();

      var input = $("<input></input>").attr("placeholder", "inserisci testo...");
      if(text != "N/A"){
        input.val(text)
      }
      txt_col.html(input);

    }
    else if($(this).text() == "check") {     // se l'icona è "per salvare" la modifica
      var txt_col = $(this).parent().parent().find("div.txt_col");
      var text = txt_col.children().val();
      var id = $(this).parent().parent().parent().attr("id");
      var value = text;
      if(text == ""){
        text = "N/A";
        value = "";
      }

      if(txt_col.parent().parent().attr("id") == "sito"){
        var url = "//" + text;
        var p = $("<p></p>").append($("<a></a>").addClass("website-link").attr({"href": url, "target": "_blank"}).text(text));
      } else {
        var p = $("<p></p>").text(text);
      }

      // Faccio la chiamata per salvare i dati sul db
      $.ajax({
        url: "php/admin-api/setAziendaData.php",
        type: "POST",
        dataType: 'json',
        data: {
          idAzienda: aziendaId,
          attribute: id,
          value: value
        },
        success: function(response){
          if(response.status){
            p.append($("<br>"))
            var notification = $("<i></i>").addClass("green-text").text("Salvato correttamente!").css({"position": "absolute", "font-size": "12px", "margin": "0px", "opacity": "0"});
            p.append(notification);
            notification.animate({opacity: 1}, 250);
            setTimeout(function(){
              notification.animate({opacity: 0}, 250);
              setTimeout(function(){
                notification.remove();
              }, 150);
            }, 1200);
          }
        }
      });

      $(this).text("edit");
      txt_col.html(p);
    }
  });
});
