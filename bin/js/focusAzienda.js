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
