function detectMobile() {
  if((window.innerWidth <= 700 && window.innerHeight <= 600)
  || navigator.userAgent.match(/Android/i)
  || navigator.userAgent.match(/webOS/i)
  || navigator.userAgent.match(/iPhone/i)
  || navigator.userAgent.match(/iPad/i)
  || navigator.userAgent.match(/iPod/i)
  || navigator.userAgent.match(/BlackBerry/i)
  || navigator.userAgent.match(/Windows Phone/i)){
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
    }
  }
  else {                  //Su dispositivo standard
    $("#jsGrid").jsGrid("fieldOption", "comune", "visible", true);
    $("#jsGrid").jsGrid("fieldOption", "indirizzo", "visible", true);
    $("#jsGrid").jsGrid("fieldOption", "open", "width", "3%");
  }
}

// Showing startup banner mechanism with cookies
$(document).ready(function(){
  if($.cookie("show_startup_banner") != null){
    $("#adminAlert").hide();
  } else {
    $("#adminAlert").show();
  }
});

// Alert closing mechanism
$(document).ready(function(){
  $("#closeAlertIcon").click(function(){
    $(this).parent().addClass("animated zoomOut");
    document.getElementById("adminAlert").addEventListener("animationend", function(){
      $(this).hide();
      $("#pageContent").animate({bottom: -200}, "slow");
      $.cookie("show_startup_banner", "false", {expires: 30});
    });
  });
});

// counter aziende
$(document).ready(function(){
  $('.counter').each(function() {
    var $this = $(this),
    countTo = $this.attr('data-count');
    $({ countNum: $this.text()}).animate({
      countNum: countTo
    },
    {
      duration: 1500,
      easing:'linear',
      step: function() {
        $this.text(Math.floor(this.countNum));
      },
      complete: function() {
        $this.text(this.countNum);
      }
    });
  });
});


// JsGrid loaing
$(document).ready(function(){
  $("#jsGrid").jsGrid({
    width: "100%",

    inserting:  false,
    editing:    false,
    deleting:   false,
    sorting:    true,
    paging:     true,
    pageSize:   20,
    autoload:   true,
    selecting:  true,
    filtering:  true,
    loadIndicationDelay: 50,
    loadMessage: "Aspetta che recupero i dati...",

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
            window.rows = response;
            d.resolve(response);
          },
          error: function(e) {
            console.log("error while loading data: " + e.responseText);
          }
        });
        return d.promise();
      }
    },

    rowClick: function(item){

    },

    rowDoubleClick: function(e){
      // $("#jsGrid").jsGrid("editItem", e.event.currentTarget);
    },

    fields: [
      { name: "ragione_sociale", title: "Ragione Sociale", type: "text", align: "center", autosearch: true},
      { name: "comune", title: "Comune", type: "text", align: "center", autosearch: true},
      { name: "indirizzo", title: "Indirizzo", type: "text", align: "center", autosearch: true},
      // { name: "settore", title: "settore", type: "text", align: "center", autosearch: true},
      { name: "open", title: "Apri", width: "3%", align: "center", itemTemplate: function(value, item){
        var url = "focusAzienda.php?id=" + item.id;
        return $("<a class=\"btn-floating btn-large waves-effect waves-light grey darken-4 btn-small\" target=\"_blank\" href=\""+url+"\"><i class=\"material-icons\">open_in_new</i></a>");}
      }
    ]
  });

  $("#jsGrid").jsGrid({
    onDataLoaded: function(args) {
      $("#selectAddress").trigger("change");
    }
  });

  window.onresize = function(){
    setGridBySize();
  }

});

// Ricerca per Indirizzo
$(document).ready(function(){
  // var rows = new Array();
  $("#selectAddress").change(function(){
    var search = $(this).val();
    if(search.length == 0){
      $("#jsGrid").jsGrid("option", "data", window.rows);
    }

    var nice_ones = new Array();
    for(var i = 0; i<window.rows.length; i++){
      var ok = true;
      for(var j = 0; j<search.length; j++){
        if(!window.rows[i].indirizzi_st.includes(parseInt(search[j]))){
          ok = false;
        }
      }
      if(ok){
        nice_ones.push(window.rows[i]);
      }
    }
    $("#jsGrid").jsGrid("option", "data", nice_ones);
  });
});
