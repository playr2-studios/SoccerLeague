/*
FILTER BY DEFENDERS
*/
 /*TATICS JS*/
containers = [document.querySelector('.field'), document.querySelector('.list-players')];
players = [];
players_on_field = {};
max_players_on_field = 11;
max_subs = 5;
on_field = [];
on_subs = [];
positions = ['gk','dc','dcl','dcr','dl','dr','dmc','dmcr'];
player_on_drag = {};

function loadplayers(){
  for (var i = 0; i < players_by_id.length; i++) {
    $.ajax({
      url : '../helpers/ajax/player.php',
      method: 'GET',
      data : {id_player : players_by_id[i]},
      success : function(response){
        players.push(response.data);
        makeplayerslist();
        draggable_playerlist();
        droppable_playerlist();
        draggable_field();
        droppable_field();
      }
    });
  }
}
function makeplayerslist(){
  var target = $('table tbody');
  var html = "";
  for(var x = 0; x < players.length; x++){
    var positions = "";
    $(players[x].positions).each(function(){
      positions += "<span class='position-"+this.position+"'>"+this.position+" " + this.side+"</span> ";
    });
    var name = players[x].name.split(' ');
    html += "<tr player-id='"+players[x].player_id+"' player-name='"+name[0]+"'>"+
                        "<td class='player-name'>"+players[x].name+"</td>"+
                        "<td class='positions'>"+
                            positions+
                        "</td>"+
                        "<td>"+players[x].skill_index+"</td>"+
                        "<td>"+players[x].recomendation+"</td>"+
                        "<td></td>"+
                      "</tr>";

  }
  $(target).html('');
  $(target).html(html);
  /* make ctrl+click in a player open a new page*/
  $(".player-name").on('click',function(e){
  	if(e.ctrlKey){
  		window.open("/players/"+$(this).closest('tr').attr("player-id"));
  	}
  });
  /*make the filter*/
  filter();
}
function draggable_playerlist(){
  $( "table tbody tr" ).draggable({
    start: function(){
      //if 10 players and we dont have gk, just visible gk.
      if((Object.values(players_on_field).length==10 || Object.values(players_on_field).length==11) && $('.field_player[position="gk"]').hasClass('visible')!=true){
        $('.field_player[position="gk"]').addClass('ondraging');
        if(this.tagName=='TR'){
          $(this).addClass('drag');
        }else{
          $(this).addClass('ondrag1');
        }
      //if it's not OR players_on_field < max_players_on_field, make all visible.
      }else if(Object.keys(players_on_field).length < max_players_on_field){
        //styles
        $('.field_player').addClass('ondraging');
        if(this.tagName=='TR'){
          $(this).addClass('drag');
        }else{
          $(this).addClass('ondrag1');
        }
      //else probaly all full
      }else{
        if(this.tagName!='TR'){
          $('.field_player').addClass('ondraging');
        }
      }
      //players on drag
      player_on_drag = {id_player:$(this).attr('player-id'), playername:$(this).attr('player-name')};
    },
    stop: function(){
      if(Object.keys(players_on_field).length < max_players_on_field+1){
        $('.field_player').removeClass('ondraging');
        if(this.tagName=='TR'){
          $(this).removeClass('drag');
        }else{
          $(this).removeClass('ondrag1');
        }
      }
    },
    cursorAt: { top: 25, left: 25 },
    helper: function( event ) {
      // return $( "<div class='drag'><div class='playershirt ondrag'></div><p>"+$(this).attr('player-name')+"</p></div>" );
      return $( "<div class='drag'><div class='playershirt ondrag'></div></div>" );
    }
  });
}
function draggable_field(){
  $( ".field_player" ).draggable({
   start: function(){
     //if 10 players and we dont have gk, just visible gk.
     if((Object.values(players_on_field).length==10 || Object.values(players_on_field).length==11) && $('.field_player[position="gk"]').hasClass('visible')!=true){
       $('.field_player[position="gk"]').addClass('ondraging');
       if(this.tagName=='TR'){
         $(this).addClass('drag');
       }else{
         $(this).addClass('ondrag1');
       }
     //if it's not OR players_on_field < max_players_on_field, make all visible.
     }else if(Object.keys(players_on_field).length < max_players_on_field){
       //styles
       $('.field_player').addClass('ondraging');
       if(this.tagName=='TR'){
         $(this).addClass('drag');
       }else{
         $(this).addClass('ondrag1');
       }
     //else probaly all full
     }else{
       if(this.tagName!='TR'){
         $('.field_player').addClass('ondraging');
       }
     }
     //players on drag
     player_on_drag = {id_player:$(this).attr('player-id'), playername:$(this).attr('player-name')};
   },
   stop: function(){
     if(Object.keys(players_on_field).length < max_players_on_field+1){
       $('.field_player').removeClass('ondraging');
       if(this.tagName=='TR'){
         $(this).removeClass('drag');
       }else{
         $(this).removeClass('ondrag1');
       }
     }
   },
   cursorAt: { top: 25, left: 25 },
   helper: function( event ) {
     // return $( "<div class='drag'><div class='playershirt ondrag'></div><p>"+$(this).attr('player-name')+"</p></div>" );
     return $( "<div class='drag'><div class='playershirt ondrag'></div></div>" );
   }
});
}
function droppable_playerlist(){
  $( "table tbody" ).droppable({
    drop: function( event, ui ) {
      if(ui.draggable.context.nodeName!='TR'){
        /* put it back on listtable */
        //delete player in the old position
        $(".field_player[position='"+key(players_on_field)+"']").attr('player-id','');
        $(".field_player[position='"+key(players_on_field)+"']").attr('player-name','');
        $(".field_player[position='"+key(players_on_field)+"']").removeClass('visible');
        $(".field_player[position='"+key(players_on_field)+"']").find('p.playername').html('');
        var positions = "";
        var target = $('table tbody');
        var cache;
        for(var i = 0; i < players.length; i++){
          if(players[i].player_id == player_on_drag.id_player){
            cache = i;
          }
        }
        $(players[cache].positions).each(function(){
          positions += "<span class='position-"+this.position+"'>"+this.position+" " + this.side+"</span> ";
        })
        var name = players[cache].name.split(' ');
        var html = "<tr player-id='"+players[cache].player_id+"' player-name='"+name[0]+"'>"+
                            "<td class='player-name'>"+players[cache].name+"</td>"+
                            "<td class='positions'>"+
                                positions+
                            "</td>"+
                            "<td>"+players[cache].skill_index+"</td>"+
                            "<td>"+players[cache].recomendation+"</td>"+
                            "<td></td>"+
                          "</tr>"
        $(target).append(html);
        // if position filter is set to another position that player doest have, the player must not be visible in the list
        var radio = $('input[type="radio"]:checked').val();
        var controller = 0;
        $("tr[player-id='"+players[cache].player_id+"'] td.positions span").each(function(){
          $(players[cache].positions).each(function(){
            if(radio == 'def' && this.position=='D'){
              controller++;
            }else if((radio=='mid') && ((this.position=='DM') || (this.position=='M') || (this.position=='OM'))){
              controller++;
            }else if((radio=='atk') && (this.position=='FC')){
              controller++;
            }else if((radio=='gk') && (this.position=='GK')){
              controller++;
            }
          })
        });
        if(controller==0){
          $("tr[player-id='"+players[cache].player_id+"']").css('display','none');
        }

        draggable_playerlist();
        delete players_on_field[key(players_on_field)];
      //save tactics and delete player on the player_on_drag.
      __SAVETACTICS();
      delete player_on_drag.id_player;
      delete player_on_drag.playername;
    }
    }
  });
}
function droppable_field(){
  $( ".field_player" ).droppable({
    drop: function( event, ui ) {
      /* delete from list table */
      var old = players_on_field[$(this).attr('position')];

      $("tr[player-id='"+player_on_drag.id_player+"']").remove();
      // if players already is on field in another position
      if($.inArray(player_on_drag.id_player,Object.values(players_on_field)) != -1){
        //delete player in the old position
        $(".field_player[position='"+key(players_on_field)+"']").attr('player-id','');
        $(".field_player[position='"+key(players_on_field)+"']").attr('player-name','');
        $(".field_player[position='"+key(players_on_field)+"']").removeClass('visible');
        $(".field_player[position='"+key(players_on_field)+"']").find('p.playername').html('');
        delete players_on_field[key(players_on_field)];
        //added player in new position
        players_on_field[$(this).attr('position')] = player_on_drag.id_player;
      }else{
        players_on_field[$(this).attr('position')] = player_on_drag.id_player;
      }
      if(old!=undefined){
        delete players_on_field[key(players_on_field)];
        //added player in new position
        players_on_field[$(this).attr('position')] = player_on_drag.id_player;

        /* put it back on listtable */
        var positions = "";
        var target = $('table tbody');
        var cache;
        for(var i = 0; i < players.length; i++){
          if(players[i].player_id == old){
            cache = i;
          }
        }
        $(players[cache].positions).each(function(){
          positions += "<span class='position-"+this.position+"'>"+this.position+" " + this.side+"</span> ";
        })
        var name = players[cache].name.split(' ');
        var html = "<tr player-id='"+players[cache].player_id+"' player-name='"+name[0]+"'>"+
                            "<td class='player-name'>"+players[cache].name+"</td>"+
                            "<td class='positions'>"+
                                positions+
                            "</td>"+
                            "<td>"+players[cache].skill_index+"</td>"+
                            "<td>"+players[cache].recomendation+"</td>"+
                            "<td></td>"+
                          "</tr>"
        $(target).append(html);
        // if position filter is set to another position that player doest have, the player must not be visible in the list
        var radio = $('input[type="radio"]:checked').val();
        var controller = 0;
        $("tr[player-id='"+players[cache].player_id+"'] td.positions span").each(function(){
          $(players[cache].positions).each(function(){
            if(radio == 'def' && this.position=='D'){
              controller++;
            }else if((radio=='mid') && ((this.position=='DM') || (this.position=='M') || (this.position=='OM'))){
              controller++;
            }else if((radio=='atk') && (this.position=='FC')){
              controller++;
            }else if((radio=='gk') && (this.position=='GK')){
              controller++;
            }
          })
        });
        if(controller==0){
          $("tr[player-id='"+players[cache].player_id+"']").css('display','none');
        }

        draggable_playerlist();
      }
      /* transfer player to field_player */
      $(this).addClass('visible');
      $(this).attr('player-id',player_on_drag.id_player);
      $(this).attr('player-name',player_on_drag.playername);
      $(this).find('p.playername').html(player_on_drag.playername);
      //save tactics and delete player on the player_on_drag.
      __SAVETACTICS();
      delete player_on_drag.id_player;
      delete player_on_drag.playername;
    }
  });
}
function droppable_reserves(){}

function makedroppable(){
  $( "table tbody tr, .field_player" ).droppable({
    drop: function( event, ui ) {
      if(this.tagName=='TR'){
        /* put it back on listtable */
        if($.inArray(player_on_drag.id_player,Object.values(players_on_field)) != -1){
          //delete player in the old position
          $(".field_player[position='"+key(players_on_field)+"']").attr('player-id','');
          $(".field_player[position='"+key(players_on_field)+"']").attr('player-name','');
          $(".field_player[position='"+key(players_on_field)+"']").removeClass('visible');
          $(".field_player[position='"+key(players_on_field)+"']").find('p.playername').html('');
          var positions = "";
          var target = $('table tbody');
          var cache;
          for(var i = 0; i < players.length; i++){
            if(players[i].player_id == player_on_drag.id_player){
              cache = i;
            }
          }
          $(players[cache].positions).each(function(){
            positions += "<span class='position-"+this.position+"'>"+this.position+" " + this.side+"</span> ";
          })
          var name = players[cache].name.split(' ');
          $(target).append("<tr player-id='"+players[cache].player_id+"' player-name='"+name[0]+"'>"+
                              "<td class='player-name'>"+players[cache].name+"</td>"+
                              "<td class='positions'>"+
                                  positions+
                              "</td>"+
                              "<td>"+players[cache].skill_index+"</td>"+
                              "<td></td>"+
                            "</tr>");
          // if position filter is set to another position that player doest have, the player must not be visible in the list
          var radio = $('input[type="radio"]:checked').val();
          var controller = 0;
          $("tr[player-id='"+players[cache].player_id+"'] td.positions span").each(function(){
            $(players[cache].positions).each(function(){
              if(radio == 'def' && this.position=='D'){
                controller++;
              }else if((radio=='mid') && ((this.position=='DM') || (this.position=='M') || (this.position=='OM'))){
                controller++;
              }else if((radio=='atk') && (this.position=='FC')){
                controller++;
              }else if((radio=='gk') && (this.position=='GK')){
                controller++;
              }
            })
          });
          if(controller==0){
            $("tr[player-id='"+players[cache].player_id+"']").css('display','none');
          }
        }

        makedraggable();
        delete players_on_field[key(players_on_field)];
      }else{
        /* delete from list table */
        $("tr[player-id='"+player_on_drag.id_player+"']").remove();
        // if players already is on field in another position
        if($.inArray(player_on_drag.id_player,Object.values(players_on_field)) != -1){
          //delete player in the old position
          $(".field_player[position='"+key(players_on_field)+"']").attr('player-id','');
          $(".field_player[position='"+key(players_on_field)+"']").attr('player-name','');
          $(".field_player[position='"+key(players_on_field)+"']").removeClass('visible');
          $(".field_player[position='"+key(players_on_field)+"']").find('p.playername').html('');
          delete players_on_field[key(players_on_field)];
          //added player in new position
          players_on_field[$(this).attr('position')] = player_on_drag.id_player;
        }else{
          players_on_field[$(this).attr('position')] = player_on_drag.id_player;
        }
      }
      /* transfer player to field_player */
      $(this).addClass('visible');
      $(this).attr('player-id',player_on_drag.id_player);
      $(this).attr('player-name',player_on_drag.playername);
      $(this).find('p.playername').html(player_on_drag.playername);
      //save tactics and delete player on the player_on_drag.
      __SAVETACTICS();
      delete player_on_drag.id_player;
      delete player_on_drag.playername;
    }
  });
}
function key(obj){
  var key = $.inArray(String(player_on_drag.id_player),Object.values(obj));
  if(key!=-1){
    return Object.keys(obj)[key];
  }
}

function __SAVETACTICS(){
  $('.lastsaved').html('');
  // $.ajax({});
  $('.lastsaved').html('Salvo');
  console.log('SAVING....');
}
function filter(){
  $('tr').each(function(){
    $(this).css('display','table-row');
  })
  $('.positions').each(function(){
    x = 0;
     $(this).children().each(function(){
       if($(this).hasClass('position-D'))
        x++;
     });
     if(x==0){
       $(this).closest('tr').toggle();
     }
   });
   $("#radio").attr('checked','checked');
}
$(document).ready(function(){
  loadplayers();
});
