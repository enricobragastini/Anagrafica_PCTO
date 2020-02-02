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
      $.cookie("show_startup_banner", "false");
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

    inserting:  true,
    editing:    true,
    deleting:   false,
    sorting:    true,
    paging:     true,
    autoload:   true,
    selecting:  true,
    filtering:  true,

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

  var instances = M.Tooltip.init(document.querySelectorAll('.tooltipped'), {  margin: 10  });

  window.onresize = function(){
    setGridBySize();
  }

});
