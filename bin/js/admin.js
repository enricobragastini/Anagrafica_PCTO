function detectMobile() {
  if( navigator.userAgent.match(/Android/i)
  || navigator.userAgent.match(/webOS/i)
  || navigator.userAgent.match(/iPhone/i)
  || navigator.userAgent.match(/iPad/i)
  || navigator.userAgent.match(/iPod/i)
  || navigator.userAgent.match(/BlackBerry/i)
  || navigator.userAgent.match(/Windows Phone/i)
  || (window.innerWidth <= 800 && window.innerHeight <= 600)
){
  return true;
} else {
  return false;
}
}

function setGridBySize(){
  if(detectMobile()){     //Su un dispositivo mobile
    if($(document.activeElement).attr('type') !== 'text'){
      $("#jsGrid").jsGrid("fieldOption", "comune", "visible", false);
      $("#jsGrid").jsGrid("fieldOption", "indirizzo", "visible", false);
      $("#jsGrid").jsGrid("fieldOption", "open", "width", "10%");
      $("#jsGrid").jsGrid("fieldOption", "control", "width", "10%");
    }
  }
  else {                  //Su dispositivo standard
    $("#jsGrid").jsGrid("fieldOption", "comune", "visible", true);
    $("#jsGrid").jsGrid("fieldOption", "indirizzo", "visible", true);
    $("#jsGrid").jsGrid("fieldOption", "open", "width", "3%");
    $("#jsGrid").jsGrid("fieldOption", "control", "width", "3%");
  }
}

$(document).ready(function(){
  $("#jsGrid").jsGrid({
    width: "100%",

    inserting: true,
    editing: false,
    deleting: false,
    sorting: true,
    paging: true,
    autoload: true,
    selecting: true,
    filtering: true,

    controller: {
      loadData: function(filter) {
        if(filter["open"] !== undefined){
          delete filter["open"];
        }
        var d = $.Deferred();
        $.ajax({
          type: 'POST',
          url: 'php/admin-api/getAziende.php',
          dataType: "json",
          data: {
            filters: filter,
          },
          success: function(response) {
            setGridBySize();
            d.resolve(response);
          },
          error: function(e) {
            console.log("error while loading data: " + e.responseText);
          }
        });
        return d.promise();
      }
    },

    rowClick: function(item){},

    rowDoubleClick: function(e){
      $("#jsGrid").jsGrid("editItem", e.event.currentTarget);
    },

    fields: [
      { name: "ragione_sociale", title: "Ragione Sociale", type: "text", align: "center", autosearch: true},
      { name: "comune", title: "Comune", type: "text", align: "center", autosearch: true},
      { name: "indirizzo", title: "Indirizzo", type: "text", align: "center", autosearch: true},
      { name: "open", title: "Apri", width: "3%", align: "center", itemTemplate: function(value, item){
        var url = "focusAzienda.php?id=" + item.id;
        return $("<a class=\"btn-floating btn-large waves-effect waves-light grey darken-4 btn-small\" target=\"_blank\" href=\""+url+"\"><i class=\"material-icons\">open_in_new</i></a>");}
      },
      { name: "control", type: "control", align: "center", width: "10%"}
    ]
  });

  window.onresize = function(){
    setGridBySize();
  }

});
