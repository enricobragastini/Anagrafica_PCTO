$(document).ready( function () {
  $("#jsGrid").jsGrid({
    width: "100%",

    inserting: true,
    editing: true,
    sorting: true,
    paging: false,
    autoload: true,
    selecting: true,
    filtering: true,

    controller: {
      loadData: function(filter) {
        var d = $.Deferred();
        $.ajax({
          type: 'POST',
          url: 'php/admin-api/getAziende.php',
          dataType: "json",
          data: {
            filters: filter,
          },
          success: function(response) {
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
      { title: "Apri", width: "2%", align: "center", itemTemplate: function(value, item){
      var url = "focusAzienda.php?id=" + item.id;
        return $("<a class=\"btn-floating btn-large waves-effect waves-light grey darken-4 btn-small\" target=\"_blank\" href=\""+url+"\"><i class=\"material-icons\">open_in_new</i></a>");
      }},
      { type: "control", align: "center", width: "3%"}
    ]
  });
} );
