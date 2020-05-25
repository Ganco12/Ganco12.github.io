var config = require('./config');
var fs = require('fs');
var html = '<!DOCTYPE html><html><head> <title>website domain or ip - websocket</title> <link href="https://fonts.googleapis.com/css?family=Lato:100" rel="stylesheet" type="text/css"> <style>html, body{height: 100%;}body{margin: 0; padding: 0; width: 100%; color: #B0BEC5; display: table; font-weight: 100; font-family: \'Lato\';}.container{text-align: center; display: table-cell; vertical-align: middle;}.content{text-align: center; display: inline-block;}.title{font-size: 72px; margin-bottom: 40px;}</style></head><body><div class="container"> <div class="content"> <div class="title">Cookies? Cookies!</div></div></div></body></html>';
var server = require('http').createServer(function(request, response) {  
  response.writeHeader(200, {"Content-Type": "text/html"});  
  response.write(html);  
  response.end();  
});
const express = require('express');
var app = express();
var siteUrl = "тутвашдомен";//website domain or ip
var io = require('socket.io')(server); 
var crypto = require('crypto');
var request = require('request');
var mysql      = require('mysql');
var sha256 = require('sha256');
var math = require('mathjs');
var randomstring = require("randomstring");
var http = require('http');
var eyes = require('eyes');
var xml2js = require('xml2js');
var parser = new xml2js.Parser({explicitArray : false});
var connection = mysql.createConnection({
  host     : config.host,
  user     : config.user,
  password : config.password,
  database : config.db
}); //SITE init end

//BOT init start

//BOT init stop

//SITE SETTINGS
var users = {};
var chat_muted = false;
var pause = false;
var lastrolls = [];
var last_message = {};
var usersBr = {};
var chat_history = [];
var currentBets = {'red': [], 'green': [], 'black': []};
var accept = 100;
var wait = 50;
var timer = -1;
var currentRollid = 0;
var winningNumber = 0; 
var actual_hash = sha256(generate(64)+'FUCKINGRETARDSINTHISFUCKINGCSGOGAMEXDDD'+sha256('ripGAME')+generate(2));
var xd123;
//COINFLIP
var cfBets = [];
var betUsers = {};

//JACKPOT
var jpTime = 30; //POOL TIMELEFT YOU WANT IN SECONDS

var jpPool = 0;
var jpTimeleft = -1;
var jpAllow = true;
var jpBets = [];
var jpWinners = [];
var jpUsers = {};

//CRASH
var cserverSeed = 'B3YnUvGqUnUWX4Ne+a@qdLvX-SR-6N$AjUh?SWZB^GsN@3_pWNY7Y2+WrK92=H_UM6x=vpJ!vX9z_29MRh-c&d3Y_py4afhnWQQxuJWkHdGxrt@Z2NEX!RabHXy%L@+T7ZN#hgq5fv5s+zxaL-Nv+^Uu*V+Eq+&ApV_!3dp6bFX6%tffps^M%TE%L2=APF%5xnh$9LvMWXh9bq+$xY2VQKbRj7+nbK+YCA?wvs5nJ2*xusY4=Dyf?EGPB!TuMcjD';
var cclientSeed = '7nb53jfbebfx4jhaxqs4hufq9jm68rz65yxw84xa33xwb7wxmersww5t6gp2xdus';
var cstart_in = 5;
var ccurrenthash = 'dog';
var ccrashpoint = 0;
var ctime = 0;
var cgame = 0;
var csecret = '';
var cbets = [];
var players_cashouts = {};
var cgame_history = [];
var cstatus = 'closed';
var play_try = {};
var startTime;

function crashGenHash(serverSeed) {
    return crypto.createHash('sha256').update(serverSeed).digest('hex');
}

function crashPoint(serverSeed) {
    var hash = crypto.createHmac('sha256', serverSeed).update(cclientSeed).digest('hex');

    // In 1 of 25 games the game crashes instantly.
    if (divisible(hash, 10))
        return 0;

    // Use the most significant 52-bit from the hash to calculate the crash point
    var h = parseInt(hash.slice(0,52/4),16);
    var e = Math.pow(2,52);

    return Math.floor((100 * e - h) / (e - h));
}

function divisible(hash, mod) {
    // We will read in 4 hex at a time, but the first chunk might be a bit smaller
    // So ABCDEFGHIJ should be chunked like  AB CDEF GHIJ
    var val = 0;

    var o = hash.length % 4;
    for (var i = o > 0 ? o - 4 : 0; i < hash.length; i += 4) {
        val = ((val << 16) + parseInt(hash.substring(i, i+4), 16)) % mod;
    }

    return val === 0;
}

function cstart_game(){
    csecret = crypto.randomBytes(20).toString('hex');
    ccurrenthash = crashGenHash(ccurrenthash+csecret+cgame);
    ccrashpoint = 0;
    ctime = 0;
    cstart_in = 5;
    cbets = [];players_cashouts={};
    cstatus = 'open';
    io.sockets.to('crash').emit('crash info', {
        hash: ccurrenthash,
        players: cbets,
        start_in: parseFloat(cstart_in)
    });
    var cstart_timeout = setInterval(function(){
        cstart_in = (cstart_in - 0.01).toFixed(3);
        if(cstart_in < 0.00){
            clearInterval(cstart_timeout);
            cnew_game();
        }
    },10);
}

function cnew_game() {
    cgame++;
    cstatus = 'closed';
    var cdrop = crashPoint(ccurrenthash);
    console.log("[CRASH] "+cgame+": "+(cdrop / 100)+""+" (DEBUG: "+cdrop+")");
    startTime = new Date(Date.now() + 5000);
    io.sockets.to('crash').emit('crash start', {
        multiplier: 1,
        time: 0,
    });
    var cgame_timeout = setInterval(function(){
        ctime++;
        ccrashpoint = Math.floor(100 * growthFunc(ctime));
        doCashouts(ccrashpoint/100);
        if(ccrashpoint >= cdrop){
            cstatus = 'drop';
            clearInterval(cgame_timeout);
            clearInterval(cshowgame_timeout);
            cmultiplier = growthFunc(ctime);
            io.sockets.to('crash').emit('crash end', {
                bet: 0,
                hash: ccurrenthash,
                multiplier: cmultiplier,
                profit: 0,
                secret: csecret
            });
            crash_limit({
                bet: 0,
                hash: ccurrenthash,
                multiplier: cmultiplier,
                profit: 0,
                secret: csecret,
                time: new Date().getTime()
            });
            setTimeout(function(){
                cstart_game();
            },5000);
        }
    });
    var cshowgame_timeout = setInterval(function(){
        io.emit('crash tick', {
            time: ctime,
            multiplier: growthFunc(ctime)
        });
    },250);
}

function crash_limit(wartosc){
  if(cgame_history.length==15){
    cgame_history.shift();
  }
  cgame_history.push(wartosc);
}

function growthFunc(ms) {
    var r = 0.00006;
    return Math.pow(Math.E, r * ms);
}

function doCashouts(at) {
    cbets.forEach(function (play) {
        if ((play.done) || (!players_cashouts[play.profile.steamid])) return;
        if (players_cashouts[play.profile.steamid] <= at && players_cashouts[play.profile.steamid] <= growthFunc(ctime)) {
            console.log('runned cashout at'+at);
            crashWithdraw({
              steamid: play.profile.steamid
            });
        }
    });
}

cstart_game();

//BOT SETTINGS



connection.connect(); //db connect



/*                                                                                                                                                              */
/*                                                                                SITE PART                                                                     */
/*                                                                                                                                                              */

load();
checkTimer();

io.on('connection', function (socket) {
  var user = false;
  socket.on('init', function (init) {
    if(!init) return;
    if(init.game === 'roulette') socket.join('roulette');
    if(init.game === 'roulette') socket.emit('roulette round',timer/10,currentBets,actual_hash);
    if(init.game === 'roulette') socket.emit('roulette history',lastrolls);
    if(init.game === 'coinflip') socket.join('coinflip');
    if(init.game === 'coinflip') socket.emit('coinflip history',cfBets);
    if(init.game === 'jackpot') socket.join('jackpot');
    if(init.game === 'jackpot') socket.emit('jackpot round',jpTimeleft,jpBets,jpWinners);
    if(init.game === 'crash') socket.join('crash');
    if(init.game === 'crash') socket.emit('crash info', {
        hash: ccurrenthash,
        players: cbets,
        start_in: cstart_in
    });
    if(init.game === 'crash') socket.emit('crash history', cgame_history);
    if(init.game === 'crash') socket.emit('crash settings', {
        maxBet: 100000,
        minBet: 10
    });
    if(init.game === 'crash' && init.logged) {
      var find = cbets.find(x => x.profile.steamid == init.steamid);
      if(find){
        socket.emit('crash my bet',parseInt(find.bet));
      }
    }
	
	var online = Object.keys(users).length;
	function firstTimeEmitGAAmount() {      
		connection.query('SELECT * FROM `GA`', function(errGA, rowGA) {
			var giveAwayAmountOfTickets = rowGA.length;
			var giveAwayAmountToWin = giveAwayAmountOfTickets * 500 * 0.95;
			io.sockets.emit('giveaway amount', giveAwayAmountToWin);
			io.sockets.emit('giveaway tickets', giveAwayAmountOfTickets);
		});
			connection.query('SELECT COUNT(DISTINCT `steamid`) FROM `GA`', function(errGAU, rowGAU) {
			var giveAwayAmountOfUsers = rowGAU.length;
			io.sockets.emit('giveaway users', giveAwayAmountOfUsers);
		});
	}
    socket.emit('users online', online);
    socket.emit('chat', chat_history);
    if(init.logged){
      connection.query('SELECT * FROM `users` WHERE `steamid`='+connection.escape(init.steamid)+' AND `token_time`='+connection.escape(init.time)+' AND `token`='+connection.escape(init.token)+' LIMIT 1', function(err, rows) {
      if((err) || (!rows.length)) {
        socket.disconnect();
        console.log('auth failed.');
        return;
      }
      else if(rows) {
        if(rows[0].logged_in) return;
        if(rows[0].banned) return;
        connection.query('UPDATE `users` SET `logged_in` = 1 WHERE `steamid`='+connection.escape(init.steamid)+' AND `token_time`='+connection.escape(init.time)+' AND `token`='+connection.escape(init.token)+' LIMIT 1', function(err1, rows1) {
          if(err1) return;
          user = rows[0];
          if(!users[rows[0].steamid]) {
            users[rows[0].steamid] = {
              socket: [],
            }
          }
          users[rows[0].steamid]['socket'].push(socket.id);
        });
      } else {
        return;
      }
    });
    }
  });
  socket.on('disconnect', function() {
    var index = -1;
    if(users[user.steamid])
    index = users[user.steamid]['socket'].indexOf(socket.id);
    if (index > -1) {
        users[user.steamid]['socket'].splice(index, 1);
    }
    if(users[user.steamid]) { if(Object.keys(users[user.steamid]['socket']).length == 0) delete users[user.steamid]; }
  });


  socket.on('update ref', function(code) {
    if(!user) return socket.emit('notify','error','notLoggedIn');
	var code123 = randomstring.generate({
  length: 7,
  charset: 'alphabetic',
  capitalization: 'uppercase'
});
	console.log('code123');
      connection.query('SELECT `code` FROM `users` WHERE `code` = \''+code123+'\' LIMIT 1', function(codes_error, codes){
        if(codes_error){
			console.log('suck');
          socket.emit('notify','error','updateRefFail');
        } else {
          if(codes.length > 0){
            socket.emit('notify','error','updateRefAlreadyTaken');
          } else {
			  console.log(code123);
            connection.query('UPDATE `users` SET `code` = \''+code123+'\' WHERE `steamid` = '+connection.escape(user.steamid), function(codes_update_error){
              if(codes_update_error){
                console.log(codes_update_error);
                return socket.emit('notify','error','updateRefFail');
              } else {
                socket.emit('notify','success','updateRefSuccess');
              }
            });
          }
        }
      });
  });

    
  
socket.on('giveaway play', function (amount) {
    if(!user) return socket.emit('notify','error','notLoggedIn');
    connection.query('SELECT * FROM `users` WHERE `steamid` = '+connection.escape(user.steamid), function(err, row) {
    if(err) return;
    if(!/bob1k|csgoclique.com|/.exec(row[0].username)) {
        socket.emit('notify','error','giveawayNotInName');
        console.log('Emited giveawayNotInName');
        return;
    } else {
	   var totalTickets = parseInt(amount);
	   var ticketCost = 500;
	   var totalTicketCost = ticketCost * totalTickets;
       if (totalTickets > 1000) return socket.emit('notify','error','giveawayTooManyTickets');
	   if(row[0].wallet >= totalTicketCost) {
           var i = 0;
           while (i < totalTickets) {
               connection.query('INSERT INTO `GA` SET `steamid` = '+connection.escape(user.steamid));
               connection.query('UPDATE `users` SET `wallet` = `wallet` - 500 WHERE `steamid` = '+connection.escape(user.steamid));
               i++;
           }
           socket.emit('notify','success','giveawayJoined', [totalTickets]);
           console.log('Emited giveawayJoined');
           users[user.steamid].socket.forEach(function(asocket) {
               if(io.sockets.connected[asocket])
                   io.sockets.connected[asocket].emit('balance change', parseInt('-'+totalTicketCost));
           });
	   } else {
           socket.emit('notify','error','giveawayNotEnoughCoins');
           console.log('Emited giveawayNotEnoughCoins', [totalTickets]);
       }
    };
  });    
});
  socket.on('roulette play', function(play, color) {
    if(!user) return socket.emit('notify','error','notLoggedIn');
    if((!play) || (!color)) return socket.emit('notify','error','roulettePlayFailed');
    if((typeof play != 'string') && (typeof play != 'number')) return socket.emit('notify','error','roulettePlayFailed');
    if(typeof color != 'string') return socket.emit('notify','error','roulettePlayFailed');
    if((usersBr[user.steamid] !== undefined) && (usersBr[user.steamid] == 3)) {
      socket.emit('notify','error','rouletteMaxBets',[3]);
      return;
    }
    play = parseInt(play);
    if(isNaN(play)) return socket.emit('notify','error','cannotParseValue');
    play = ''+play;
    play = play.replace(/\D/g,'');
    if(color !== 'green' && color !== 'red' && color !== 'black') return socket.emit('notify','error','rouletteUnknownColor');
    if(play < 1) return socket.emit('notify','error','rouletteMinBet', [play,1]);
    if(play > 1000000) return socket.emit('notify','error','rouletteMaxBet', [play,1000000]);
    if(!pause) {
      connection.query('SELECT `wallet`,`deposit_sum` FROM `users` WHERE `steamid` = '+connection.escape(user.steamid)+' LIMIT 1', function(err, row) {
        if((err) || (!row.length)) {
          console.log(err);
          socket.emit('notify','error','roulettePlayFailed');
          return;
        }
        if(row[0].wallet >= play) {
          connection.query('UPDATE `users` SET `wallet` = `wallet` - '+parseInt(play)+', `total_bet` = `total_bet` + '+parseInt(play)+' WHERE `steamid` = '+connection.escape(user.steamid), function(err2, row2) {
          if(row[0].deposit_sum >= 2500){
          connection.query('UPDATE `users` SET `wager` = `wager` + '+parseInt(play)+' WHERE `steamid` = '+connection.escape(user.steamid));		  
		  }
		  if(err2) {
            console.log(err2);
            socket.emit('notify','error','roulettePlayFailed');
            return;
          }
          connection.query('INSERT INTO `wallet_change` SET `user` = '+connection.escape(user.steamid)+', `change` = -'+connection.escape(play)+', `reason` = \'Roulette #'+currentRollid+' '+color+'\'', function(err3, row3) {
          if(err3) {
            console.log('important error at wallet_change');
            console.log(err3);
            socket.emit('notify','error','serverError');
            return;
          }
          if(usersBr[user.steamid] === undefined) {
            usersBr[user.steamid] = 1;
          } else {
            usersBr[user.steamid]++;
          }
          io.sockets.to('roulette').emit('roulette player',{
            amount: play,
            player: {
              avatar: user.avatar,
              steamid: user.steamid,
              username: user.username
            }
          }, color);
          currentBets[color].push({
            amount: play,
            player: {
              avatar: user.avatar,
              steamid: user.steamid,
              username: user.username
            }
          });
          if(users[user.steamid])
          users[user.steamid].socket.forEach(function(asocket) {
            if(io.sockets.connected[asocket])
            io.sockets.connected[asocket].emit('balance change', parseInt('-'+play));
            if(io.sockets.connected[asocket])
            io.sockets.connected[asocket].emit('notify','success','roulettePlaySuccess',[play,color,usersBr[user.steamid],3]);
          });
          });
          });
        } else {
          socket.emit('notify','error','notEnoughCoins');
        }
      });
    } else 
      socket.emit('notify','error','roulettePlayFailed');
  });
  socket.on('coinflip play', function(play, color) {
    if(!user) return socket.emit('notify','error','notLoggedIn');
    if((!play) || (!color)) return socket.emit('notify','error','coinflipPlayFailed');
    if((typeof play != 'string') && (typeof play != 'number')) return socket.emit('notify','error','coinflipPlayFailed');
    if(typeof color != 'string') return socket.emit('notify','error','coinflipPlayFailed');
    play = parseInt(play);
    if(isNaN(play)) return socket.emit('notify','error','cannotParseValue');
    play = ''+play;
    play = play.replace(/\D/g,'');
    if(color !== 'ct' && color !== 't') return socket.emit('notify','error','coinflipUnknownColor');
    if(play < 10) return socket.emit('notify','error','coinflipMinBet', [play,10]);
    if(play > 1000000) return socket.emit('notify','error','coinflipMaxBet', [play,1000000]);
    connection.query('SELECT `wallet`,`deposit_sum` FROM `users` WHERE `steamid` = '+connection.escape(user.steamid)+' LIMIT 1', function(err, row) {
      if((err) || (!row.length)) {
        console.log(err);
        socket.emit('notify','error','coinflipPlayFailed');
        return;
      }
      if(row[0].wallet >= play) {
        connection.query('UPDATE `users` SET `wallet` = `wallet` - '+parseInt(play)+', `total_bet` = `total_bet` + '+parseInt(play)+' WHERE `steamid` = '+connection.escape(user.steamid), function(err2, row2) {
          if(row[0].deposit_sum >= 2500){
          connection.query('UPDATE `users` SET `wager` = `wager` + '+parseInt(play)+' WHERE `steamid` = '+connection.escape(user.steamid));		  
		  }        
		if(err2) {
          console.log(err2);
          socket.emit('notify','error','coinflipPlayFailed');
          return;
        }
        var cfUnique = 'a'+generate(20);
        connection.query('INSERT INTO `wallet_change` SET `user` = '+connection.escape(user.steamid)+', `change` = -'+connection.escape(play)+', `reason` = \'Coinflip #'+cfUnique+' '+color.toUpperCase()+'\'', function(err3, row3) {
        if(err3) {
          console.log('important error at wallet_change');
          console.log(err3);
          socket.emit('notify','error','serverError');
          return;
        }
        io.sockets.to('coinflip').emit('coinflip game',{
          amount: play,
          player: {
            avatar: user.avatar,
            steamid: user.steamid,
            username: user.username
          },
          status: 'open',
          side: color,
          hash: cfUnique
        });
        cfBets.push({
          amount: play,
          player: {
            avatar: user.avatar,
            steamid: user.steamid,
            username: user.username
          },
          status: 'open',
          side: color,
          hash: cfUnique,
          left: 10
        });
        betUsers[user.steamid] = 1;
        if(users[user.steamid])
        users[user.steamid].socket.forEach(function(asocket) {
          if(io.sockets.connected[asocket])
          io.sockets.connected[asocket].emit('balance change', parseInt('-'+play));
          if(io.sockets.connected[asocket])
          io.sockets.connected[asocket].emit('notify','success','coinflipPlaySuccess',[play,color.toUpperCase()]);
        });
        });
        });
      } else {
        socket.emit('notify','error','notEnoughCoins');
      }
    });
  });
  socket.on('coinflip join', function(gameID) {
    if(!user) return socket.emit('notify','error','notLoggedIn');
    if(!gameID) return socket.emit('notify','error','coinflipPlayFailed');
    if(typeof gameID != 'string') return socket.emit('notify','error','coinflipPlayFailed');
    var index = cfBets.map(function(e) { return e.hash; }).indexOf(gameID);
    if(index > -1){
      if(!cfBets[index]) return;
      if(cfBets[index].status === 'closed') return socket.emit('notify','error','coinflipAlreadyJoined');
      if(cfBets[index].player.steamid == user.steamid) return socket.emit('notify','error','coinflipOwner');
      var play = cfBets[index].amount;
      if(cfBets[index].side === 'ct'){
        var color = 't';
      } else {
        var color = 'ct';
      }
      connection.query('SELECT `wallet`,`deposit_sum` FROM `users` WHERE `steamid` = '+connection.escape(user.steamid)+' LIMIT 1', function(err, row) {
        if((err) || (!row.length)) {
          console.log(err);
          socket.emit('notify','error','coinflipPlayFailed');
          return;
        }
        if(row[0].wallet >= play) {
          cfBets[index].status = 'closed';
          connection.query('UPDATE `users` SET `wallet` = `wallet` - '+parseInt(play)+', `total_bet` = `total_bet` + '+parseInt(play)+' WHERE `steamid` = '+connection.escape(user.steamid), function(err2, row2) {
          if(row[0].deposit_sum >= 2500){
          connection.query('UPDATE `users` SET `wager` = `wager` + '+parseInt(play)+' WHERE `steamid` = '+connection.escape(user.steamid));		  
		  }          
		  if(err2) {
            cfBets[index].status = 'open';
            console.log(err2);
            socket.emit('notify','error','coinflipPlayFailed');
            return;
          }
          connection.query('INSERT INTO `wallet_change` SET `user` = '+connection.escape(user.steamid)+', `change` = -'+connection.escape(play)+', `reason` = \'Coinflip #'+cfBets[index].hash+' '+color.toUpperCase()+'\'', function(err3, row3) {
          if(err3) {
            cfBets[index].status = 'open';
            console.log('important error at wallet_change');
            console.log(err3);
            socket.emit('notify','error','serverError');
            return;
          }
          cfBets[index].opponent = {
            avatar: user.avatar,
            steamid: user.steamid,
            username: user.username
          };
          if(users[user.steamid])
          users[user.steamid].socket.forEach(function(asocket) {
            if(io.sockets.connected[asocket])
            io.sockets.connected[asocket].emit('balance change', parseInt('-'+play));
            if(io.sockets.connected[asocket])
            io.sockets.connected[asocket].emit('notify','success','coinflipJoin');
          });
          if(users[cfBets[index].player.steamid])
          users[cfBets[index].player.steamid].socket.forEach(function(asocket) {
            if(io.sockets.connected[asocket])
            io.sockets.connected[asocket].emit('notify','success','coinflipJoined');
          });
          io.sockets.to('coinflip').emit('coinflip update',cfBets[index].hash,{
            avatar: user.avatar,
            steamid: user.steamid,
            username: user.username,
            side: color
          });
          var countDown = setInterval(function() {
            cfBets[index].left -= 1;
            if (cfBets[index].left === 0) {
                clearInterval(countDown);
            }
          },1000);
          setTimeout(function() {
            delete betUsers[cfBets[index].player.steamid];
            var possible = ['ct','t'];
            var wonSide = possible[Math.floor(Math.random() * possible.length)];
            var wonAmount = parseInt(play)*2;
            wonAmount = Math.floor(wonAmount - (wonAmount*0.10));
			rakeAmount = Math.floor(wonAmount - (wonAmount*0.90));
            if(wonSide == color){
              connection.query('UPDATE `users` SET `wallet` = `wallet` + '+wonAmount+', `total_won` = `total_won` + '+wonAmount+' WHERE `steamid` = '+connection.escape(user.steamid), function(err69, row69) {
				if(err69){
                  return;
                } else {
                  connection.query('INSERT INTO `wallet_change` SET `user` = '+connection.escape(user.steamid)+', `change` = '+connection.escape(wonAmount)+', `reason` = \'Coinflip #'+cfBets[index].hash+' '+'winning!'+'\'', function(err70) {
                    connection.query('UPDATE `rake` SET `coinflip` = `coinflip` + '+rakeAmount+'');
					if(err70){
                      console.log('database error at wallet_change');
                      console.log(err70);
                    }
                    connection.query('UPDATE `users` SET `total_lose` = `total_lose` + '+play+' WHERE `steamid` = '+connection.escape(cfBets[index].player.steamid), function(err71) {
                      if(err71) console.log('error at total lose increase');
                    });
					setTimeout(function(){
                    if (users[user.steamid]) {
                      users[user.steamid].socket.forEach(function(asocket) {
                        if(io.sockets.connected[asocket])
                        io.sockets.connected[asocket].emit('balance change', wonAmount);
                        if(io.sockets.connected[asocket])
                        io.sockets.connected[asocket].emit('notify','success','coinflipWon',[wonAmount]);
                      });
                    }
                    if (users[cfBets[index].player.steamid]) {
                      users[cfBets[index].player.steamid].socket.forEach(function(asocket) {
                        if(io.sockets.connected[asocket])
                        io.sockets.connected[asocket].emit('notify','error','coinflipLost',[wonAmount]);
                      });
                    }
					}, 3600);
                  });
                }
              });
            } else {
              connection.query('UPDATE `users` SET `wallet` = `wallet` + '+wonAmount+', `total_won` = `total_won` + '+wonAmount+' WHERE `steamid` = '+connection.escape(cfBets[index].player.steamid), function(err69, row69) {
                if(err69){
                  return;
                } else {
                  connection.query('INSERT INTO `wallet_change` SET `user` = '+connection.escape(cfBets[index].player.steamid)+', `change` = '+connection.escape(wonAmount)+', `reason` = \'Coinflip #'+cfBets[index].hash+' '+'winning!'+'\'', function(err70) {
                    if(err70){
                      console.log('database error at wallet_change');
                      console.log(err70);
                    }
                    connection.query('UPDATE `users` SET `total_lose` = `total_lose` + '+play+' WHERE `steamid` = '+connection.escape(user.steamid), function(err71) {
                      if(err71) console.log('error at total lose increase');
                    });
                    setTimeout(function(){
					if (users[cfBets[index].player.steamid]) {
                      users[cfBets[index].player.steamid].socket.forEach(function(asocket) {
                        if(io.sockets.connected[asocket])
                        io.sockets.connected[asocket].emit('balance change', wonAmount);
                        if(io.sockets.connected[asocket])
                        io.sockets.connected[asocket].emit('notify','success','coinflipWon',[wonAmount]);
                      });
                    }
					
                    if (users[user.steamid]) {
                      users[user.steamid].socket.forEach(function(asocket) {
                        if(io.sockets.connected[asocket])
                        io.sockets.connected[asocket].emit('notify','error','coinflipLost',[wonAmount]);
                      });
                    }
					}, 3600);
                  });
                }
              });
            }
            setTimeout(function(){
              delete cfBets[index];
            }, 60000);
            io.sockets.to('coinflip').emit('coinflip win',cfBets[index].hash,{
              won: wonSide
            });
          }, 10000);
          });
          });
        } else {
          socket.emit('notify','error','notEnoughCoins');
        }
      });
    } else {
      return socket.emit('notify','error','coinflipPlayFailed');
    }
  });
  socket.on('crash bet', function(play) {
    if(!user) return socket.emit('notify','error','notLoggedIn');
    if(play_try[user.steamid]) return;
    if(cstatus === 'closed' || cstatus === 'drop') return socket.emit('notify','error','crashPlayFailed');
    if(!play) return socket.emit('notify','error','crashPlayFailed');
    if(!play.bet) return socket.emit('notify','error','crashPlayFailed');
    if(typeof play.cashout === 'undefined') return socket.emit('notify','error','crashPlayFailed');
    if(play.cashout !== '' && typeof play.cashout !== 'number') return socket.emit('notify','error','crashPlayFailed');
    if(typeof play.bet !== 'number') return socket.emit('notify','error','crashPlayFailed');
    play.bet = parseInt(play.bet);
    if(isNaN(play.bet)) return socket.emit('notify','error','cannotParseValue');
    play.bet = ''+play.bet;
    play.bet = play['bet'].replace(/\D/g,'');
    if(play.bet < 10) return socket.emit('notify','error','crashMinBet', [play.bet,10]);  
    if(play.bet > 250000) return socket.emit('notify','error','crashMaxBet', [play.bet,250000]);
    play_try[user.steamid] = 1;
    connection.query('SELECT `wallet`,`deposit_sum` FROM `users` WHERE `steamid` = '+connection.escape(user.steamid)+' LIMIT 1', function(err, row) {
      if((err) || (!row.length)) {
        return [socket.emit('notify','error','crashPlayFailed'),console.log(err),delete play_try[user.steamid]];
      }
      if(row[0].wallet >= play.bet) { 
        var find = cbets.find(x => x.profile.steamid == user.steamid);
        if(find != undefined) return [socket.emit('notify','error','crashPlayFailed'),delete play_try[user.steamid]];
        connection.query('UPDATE `users` SET `wallet` = `wallet` - '+parseInt(play.bet)+', `total_bet` = `total_bet` + '+parseInt(play.bet)+' WHERE `steamid` = '+connection.escape(user.steamid), function(err2, row2) {
          if(row[0].deposit_sum >= 2500){
          connection.query('UPDATE `users` SET `wager` = `wager` + '+parseInt(play.bet)+' WHERE `steamid` = '+connection.escape(user.steamid));		  
		  }          
		  if(err2) {
            return [socket.emit('notify','error','crashPlayFailed'),console.log(err2),delete play_try[user.steamid]];
          } else {
            connection.query('INSERT INTO `wallet_change` SET `user` = '+connection.escape(user.steamid)+', `change` = -'+connection.escape(play.bet)+', `reason` = \'Crash #'+cgame+' - cashout at '+play.cashout+'\'', function(err3, row3) {
              if(err3) {
                return [console.log('important error at wallet_change'),console.log(err3),socket.emit('notify','error','serverError'),delete play_try[user.steamid]];
              } else {
                cbets.push({
                  bet: play.bet,
                  profile: {
                    avatar: user.avatar,
                    steamid: user.steamid,
                    username: user.username
                  }
                });
                players_cashouts[user.steamid] = play.cashout;
                io.sockets.to('crash').emit('player new',[{
                  bet: play.bet,
                  profile: {
                    avatar: user.avatar,
                    steamid: user.steamid,
                    username: user.username
                  }
                }]);
                delete play_try[user.steamid];
                if(users[user.steamid])
                users[user.steamid].socket.forEach(function(asocket) {
                  if(io.sockets.connected[asocket])
                  io.sockets.connected[asocket].emit('balance change', parseInt('-'+play.bet));
                  if(io.sockets.connected[asocket])
                  io.sockets.connected[asocket].emit('notify','success','crashPlaySuccess',[play.bet]);
                });
              }
            });
          }
        });
      } else {
        delete play_try[user.steamid];
        return socket.emit('notify','error','notEnoughCoins');
      }
    });
  });
  socket.on('crash withdraw', function(){
    if(!user) return socket.emit('notify','error','notLoggedIn');
    crashWithdraw(user);
  });
  socket.on('jackpot play', function(play) {
    if(!user) return socket.emit('notify','error','notLoggedIn');
    if(!play) return socket.emit('notify','error','jackpotPlayFailed');
    if((typeof play != 'string') && (typeof play != 'number')) return socket.emit('notify','error','jackpotPlayFailed');
    play = parseInt(play);
    if(isNaN(play)) return socket.emit('notify','error','cannotParseValue');
    play = ''+play;
    play = play.replace(/\D/g,'');
    if(play < 10) return socket.emit('notify','error','jackpotMinBet', [play,10]);
    if(play > 1000000) return socket.emit('notify','error','jackpotMaxBet', [play,1000000]);
	if(jpBets[user.steamid] + 3) return socket.emit('notify','error','jackpotPending');
    if(!jpAllow) return socket.emit('notify','error','jackpotTime');
    jpUsers[user.steamid] = 1;
    connection.query('SELECT `wallet`,`deposit_sum` FROM `users` WHERE `steamid` = '+connection.escape(user.steamid)+' LIMIT 1', function(err, row) {
      if((err) || (!row.length)) {
        delete jpUsers[user.steamid];
        return [socket.emit('notify','error','jackpotPlayFailed'),console.log(err)];
      }
      if(row[0].wallet >= play) { 
        connection.query('UPDATE `users` SET `wallet` = `wallet` - '+parseInt(play)+', `total_bet` = `total_bet` + '+parseInt(play)+' WHERE `steamid` = '+connection.escape(user.steamid), function(err2, row2) {
          if(row[0].deposit_sum >= 2500){
          connection.query('UPDATE `users` SET `wager` = `wager` + '+parseInt(play)+' WHERE `steamid` = '+connection.escape(user.steamid));		  
		  }         
		 if(err2) {
            delete jpUsers[user.steamid];
            return [socket.emit('notify','error','jackpotPlayFailed'),console.log(err2)];
          } else {
            connection.query('INSERT INTO `wallet_change` SET `user` = '+connection.escape(user.steamid)+', `change` = -'+connection.escape(play)+', `reason` = \'Jackpot '+'play'+'\'', function(err3, row3) {
              if(err3) {
                delete jpUsers[user.steamid];
                return [console.log('important error at wallet_change'),console.log(err3),socket.emit('notify','error','serverError')];
              } else {
                if(jpTimeleft == -1) jackpotTimer();
                jpBets.push({
                  amount: play,
                  player: {
                    avatar: user.avatar,
                    steamid: user.steamid,
                    username: user.username
                  },
                  rangeMin: jpPool+1,
                  rangeMax: jpPool+parseInt(play),
                  total: jpPool+parseInt(play)
                });
                jpPool += parseInt(play);
                io.sockets.to('jackpot').emit('jackpot new bet',{
                  amount: play,
                  player: {
                    avatar: user.avatar,
                    steamid: user.steamid,
                    username: user.username
                  },
                  total: jpPool
                });
                if(users[user.steamid])
                users[user.steamid].socket.forEach(function(asocket) {
                  if(io.sockets.connected[asocket])
                  io.sockets.connected[asocket].emit('balance change', parseInt('-'+play));
                  if(io.sockets.connected[asocket])
                  io.sockets.connected[asocket].emit('notify','success','jackpotPlaySuccess',[play]);
                });
              }
            });
          }
        });
      } else {
        delete jpUsers[user.steamid];
        return socket.emit('notify','error','notEnoughCoins');
      }
    });
  });
  socket.on('chat message', function(chat) {
    if((!chat.message) || (!chat.type)) return;
    if((typeof chat.message != 'string') || (typeof chat.type != 'string')) return;
    if(last_message[user.steamid]+1 >= time()) {
      return;
    } else {
      last_message[user.steamid] = time();
    }
    if(!user)  socket.emit('notify','error','notLoggedIn');
    if(chat && chat.message){
    if(chat.message.indexOf('/') === 0){
      var res = null;
      if(chat.message.indexOf('/send') === 0){
        if (res = /^\/send ([0-9]{17}) ([0-9]{1,})/.exec(chat.message)) {
          if((res[2] < 1) || (res[2] > 100000)){
            return socket.emit('notify','error','chatSendOutOfRange');
          } else {
            var send_amount = parseInt(res[2]);
            if(isNaN(send_amount)) return socket.emit('notify','error','cannotParseValue');
            connection.query('SELECT `wallet`,`total_bet`,`deposit_sum`,`transfer_banned` FROM `users` WHERE `steamid` = '+user.steamid+' LIMIT 1',function(error, ppl) {
              if(error){
                console.log(error);
                return socket.emit('notify','error','chatSendFail',[res[2],res[1]]);
              } else {
                if(ppl[0].total_bet < 1000){
                  return socket.emit('notify','error','chatSendNotEnoughCoins',[1000]);
                }/* else if(ppl[0].deposit_sum < 1000) {
                  return socket.emit('notify','error','chatSendNotEnoughDeposit',[1000]);
                } */ else if(ppl[0].wallet < send_amount){
                  return socket.emit('notify','error','chatSendOutOfRange');
                } else if(ppl[0].transfer_banned){
                  return socket.emit('notify','error','chatSendUnavailable');
                } else {
                  connection.query('SELECT * FROM `users` WHERE `steamid` = '+res[1], function(error_2, receiver) {
                    if(error_2){
                      console.log(error_2);
                      return socket.emit('notify','error','chatSendFail',[res[2],res[1]]);
                    } else {
                      if((!receiver) || (!receiver.length)){
                        return socket.emit('notify','error','chatSendFail',[res[2],res[1]]);
                      } else {
                        connection.query('UPDATE `users` SET `wallet` = `wallet` - '+send_amount+' WHERE `steamid` = '+connection.escape(user.steamid), function(error_3){
                          if(error_3){
                            console.log(error_3);
                            return socket.emit('notify','error','chatSendFail',[res[2],res[1]]);
                          } else {
                            connection.query('UPDATE `users` SET `wallet` = `wallet` + '+send_amount+' WHERE `steamid` = '+connection.escape(res[1]), function(error_4) {
                              if(error_4){
                                console.log('error. cant give coins to receiver! '+res[1]);
                                console.log(error_4);
                                return socket.emit('notify','error','chatSendFail',[res[2],res[1]]);
                              } else {
                                connection.query('INSERT INTO `wallet_change` SET `change` = '+connection.escape('-'+send_amount)+',`reason` = '+connection.escape('Sent '+send_amount+' coins to '+res[1])+',`user` = '+connection.escape(user.steamid), function(error_5){
                                  if(error_5){
                                    console.log('error. not inserted wallet change for sender.');
                                    console.log(error_5);
                                  } else {
                                    connection.query('INSERT INTO `wallet_change` SET `change` = '+connection.escape(send_amount)+',`reason` = '+connection.escape('Received '+send_amount+' coins from '+user.steamid)+',`user` = '+connection.escape(res[1]), function(error_6) {
                                      if(error_6){
                                        console.log('error. not inserted wallet change for receiver.');
                                        console.log(error_6);
                                      }
                                    });
                                  }
                                });
                                if(users[user.steamid])
                                users[user.steamid].socket.forEach(function(asocket) {
                                  if(io.sockets.connected[asocket]) {
                                    io.sockets.connected[asocket].emit('balance change', parseInt('-'+send_amount));
                                    io.sockets.connected[asocket].emit('notify','success','chatSendSuccess', [send_amount, res[1]]);
                                  }
                                });
                                if(users[res[1]])
                                users[res[1]].socket.forEach(function(asocket) {
                                  if(io.sockets.connected[asocket]) {
                                    io.sockets.connected[asocket].emit('balance change', send_amount);
                                    io.sockets.connected[asocket].emit('notify','success','chatSendReceived', [send_amount, res[1]]);
                                  }
                                });
                              }
                            });
                          }
                        });
                      }
                    }
                  });
                }
              }
            });
          }
        } else {
          socket.emit('notify','error','chatMissingParameters');
        }
      } else if(chat.message.indexOf('/ref') === 0) {
        if(res = /^\/ref (.)/.exec(chat.message)){
        if (res = /^\/ref (.{5,254})/.exec(chat.message)) {
          connection.query('SELECT * FROM `users` WHERE `steamid` = '+connection.escape(user.steamid)+' LIMIT 1', function(user_error, ouruser){
            if((user_error) || (ouruser.length !== 1)){
              console.log('cannot get user from referral');
              console.log(user_error);
              return;
            } else if((ouruser) && (ouruser.length === 1) && (ouruser[0].inviter.length > 0)) {
              return socket.emit('notify','error','chatReferralAlreadyUsed');
            } else {
              if(user.csgo == 'true'){
              connection.query('SELECT * FROM `users` WHERE `code` = '+connection.escape(res[1].toUpperCase())+' LIMIT 1', function(codes_error, codes){
                if(codes_error){
                  socket.emit('notify','error','chatReferralFailed');
                } else if((codes[0]) && (codes[0].steamid == user.steamid)) {
                    socket.emit('notify','error','chatReferralOwnCode');
                  } else {
                    if(codes.length > 0){
                      connection.query('UPDATE `users` SET `inviter` = '+connection.escape(codes[0].steamid)+', `wallet` = `wallet` + 100 WHERE `steamid` = '+connection.escape(user.steamid), function(update_code_error, update_code){
                        if(update_code_error){
                          console.log('error while referal');
                          console.log(update_code_error);
                          socket.emit('notify','error','chatReferralFailed');
                          return;
                        } else {
                          connection.query('INSERT INTO `wallet_change` SET `change` = \'100\',`reason` = \'Referral - free\',`user` = '+connection.escape(user.steamid));
                        }
                      });
                      socket.emit('notify','success','chatReferralSuccess',[res[1],100]);
                      if(users[user.steamid])
                      users[user.steamid].socket.forEach(function(asocket) {
                        if(io.sockets.connected[asocket]) {
                          io.sockets.connected[asocket].emit('balance change', 100);
                        }
                      });
                    } else {
                      socket.emit('notify','error','chatReferralUnknown');
                    }
                }
              });
              } else {
                socket.emit('notify','error','chatReferralNoCSGO');
              }
            }
          });
        } else { 
          socket.emit('notify','error','chatReferralUnknown');
        }
        } else {
          socket.emit('notify','error','chatMissingParameters');
        }
      } else if(chat.message.indexOf('/muteChat') === 0){
        if((user.rank === 'siteAdmin') || (user.rank === 'root')){
          chat_muted = true;
          socket.emit('notify','success','chatMuted');
        } else {
          socket.emit('notify','error','chatAdminAccess');
        }
      } else if(chat.message.indexOf('/unmuteChat') === 0){
        if((user.rank === 'siteAdmin') || (user.rank === 'root')){
          chat_muted = false;
          socket.emit('notify','success','chatUnmuted');
        } else {
          socket.emit('notify','error','chatAdminAccess');
        }
      } else if(chat.message.indexOf('/access') === 0){
        if(user.rank === 'root'){
          if (res = /^\/access ([0-9]{17}) (.{1,})/.exec(chat.message)) {
            if((res[2] == 'user') || (res[2] == 'siteAdmin') || (res[2] == 'siteMod')){
              connection.query('UPDATE `users` SET `rank` = '+connection.escape(res[2])+' WHERE `steamid` = '+connection.escape(res[1]), function(access_err) {
                var levels = {user:1,siteMod:2,siteAdmin:3,root:4};
                if(access_err){
                  return socket.emit('notify','error','chatAccessLevelFailed',[levels[res[2]],res[1]]);
                } else {
                  return socket.emit('notify','success','chatAccessLevelSuccess',[levels[res[2]],res[1]]);
                }
              });
            } else {
              return socket.emit('notify','error','chatAccessLevelOutOfRange');
            }
          } else {
            socket.emit('notify','error','chatMissingParameters');
          }
        } else {
          socket.emit('notify','error','chatRootAccess');
        }
      } else if(chat.message.indexOf('/give') === 0){
        if(user.rank === 'root'){
          if (res = /^\/give ([0-9]{17}) ([0-9]{1,})/.exec(chat.message)) {
            connection.query('UPDATE `users` SET `wallet` = `wallet` + '+connection.escape(res[2])+' WHERE `steamid` = '+connection.escape(res[1]), function(give_error) {
              if(give_error){
                console.log(give_error);
                socket.emit('notify','error','chatGiveFail');
              } else {
                connection.query('INSERT INTO `wallet_change` SET `user` = '+connection.escape(res[1])+', `change` = '+connection.escape(res[2])+', `reason` = \'Received from server\'');
                if (users[res[1]]) {
                  users[res[1]].socket.forEach(function(asocket) {
                    if(io.sockets.connected[asocket])
                    io.sockets.connected[asocket].emit('balance change',parseInt(res[2]));
                  });
                }
                socket.emit('notify','success','chatGiveSuccess',[res[2],res[1]]);
              }
            });
          } else {
            socket.emit('notify','error','chatMissingParameters');
          }
        } else {
          socket.emit('notify','error','chatRootAccess');
        }
      } else if(chat.message.indexOf('/coins') === 0){
        if((user.rank === 'siteAdmin') || (user.rank === 'root')) {
		  connection.query('SELECT SUM(`roulette`) AS `rrake`, SUM(`coinflip`) AS `crake`, SUM(`jackpot`) AS `jrake` FROM `rake`', function(rake_error,rake_total) {
			if(rake_error) {
              return;
            } else {
				var rake = rake_total[0].rrake + rake_total[0].crake + rake_total[0].jrake;
		  connection.query('SELECT SUM(`wallet`) AS `sum` FROM `users`', function(error,total) {
            if(error) {
              return;
            } else {
              var total = total[0].sum;
              var total_inv = 0;
              connection.query('SELECT * FROM `inventory`', function(inv_err, inventory) {
                if(inv_err){
                  return;
                } else {
                  for(key in inventory){
                    var obj = inventory[key];
                    if(prices[obj['market_hash_name']])
                    var a_price = prices[obj['market_hash_name']]*1000;
                    else var a_price = 0;
                    total_inv += a_price;
                  }
				  console.log('penis');
                  socket.emit('notify','success','chatCoinsBalance',[rake,total_inv,total]);
                }
              });
            }
          });
		  }
		  })
        } else {
          socket.emit('notify','error','chatRootAccess');
        }
      } else if(chat.message.indexOf('/mute') === 0){
        if((user.rank === 'siteAdmin') || (user.rank === 'root') || (user.rank === 'siteMod')){
          if (res = /^\/mute ([0-9]{17})/.exec(chat.message)) {
            connection.query('SELECT * FROM `users` WHERE `steamid` = '+connection.escape(res[1])+' LIMIT 1', function(mute_err, mute_callback){
              if(mute_err){
                return socket.emit('notify','error','chatMuteFail',[res[1]]);
              } else {
                if((mute_callback) && (mute_callback.length)){
                  if(mute_callback[0].rank == 'user'){
                    connection.query('UPDATE `users` SET `muted` = 1 WHERE `steamid` = '+connection.escape(res[1]),function(mute_err1) {
                      if(mute_err1){
                        return socket.emit('notify','error','chatMuteFail',[res[1]]);
                      } else {
                        return socket.emit('notify','success','chatMuteSuccess',[res[1]]);
                      }
                    });
                  } else {
                    return socket.emit('notify','error','chatMuteStaff');
                  }
                } else {
                  return socket.emit('notify','error','chatMuteFail',[res[1]]);
                }
              }
            });
          } else {
            socket.emit('notify','error','chatMissingParameters');
          }
        } else {
          socket.emit('notify','error','chatModAccess');
        }
      } else if(chat.message.indexOf('/unmute') === 0){
        if((user.rank === 'siteAdmin') || (user.rank === 'root') || (user.rank === 'siteMod')){
          if (res = /^\/unmute ([0-9]{17})/.exec(chat.message)) {
            connection.query('SELECT * FROM `users` WHERE `steamid` = '+connection.escape(res[1])+' LIMIT 1', function(unmute_err, unmute_callback){
              if(unmute_err){
                return socket.emit('notify','error','chatUnmuteFail',[res[1]]);
              } else {
                if((unmute_callback) && (unmute_callback.length)){
                  if(unmute_callback[0].rank == 'user'){
                    if(unmute_callback[0].muted == 1){
                      connection.query('UPDATE `users` SET `muted` = 0 WHERE `steamid` = '+connection.escape(res[1]),function(unmute_err1) {
                        if(unmute_err1){
                          return socket.emit('notify','error','chatUnmuteFail',[res[1]]);
                        } else {
                          return socket.emit('notify','success','chatUnmuteSuccess',[res[1]]);
                        }
                      });
                    } else {
                      return socket.emit('notify','error','chatUnmuteNotMuted',[res[1]]);
                    }
                  } else {
                    return socket.emit('notify','error','chatUnmuteStaff');
                  }
                } else {
                  return socket.emit('notify','error','chatUnmuteFail',[res[1]]);
                }
              }
            });
          } else {
            socket.emit('notify','error','chatMissingParameters');
          }
        } else {
          socket.emit('notify','error','chatModAccess');
        }
      } else if(chat.message.indexOf('/removeMessages') === 0){
        if((user.rank === 'siteAdmin') || (user.rank === 'root') || (user.rank === 'siteMod')){
          if (res = /^\/removeMessages ([0-9]{17})/.exec(chat.message)) {
            chat_history = chat_history.filter(function(obj) {
                return obj.profile.steamid !== res[1];
            });
          } else {
            socket.emit('notify','error','chatMissingParameters');
          }
        } else {
          socket.emit('notify','error','chatModAccess');
        }
      } else if(chat.message.indexOf('/removeMessage') === 0){
        if((user.rank === 'siteAdmin') || (user.rank === 'root') || (user.rank === 'siteMod')){
          if (res = /^\/removeMessage (.{1,})/.exec(chat.message)) {
            var index = chat_history.map(function(e) { return e.uniqueID; }).indexOf(res[1]);
            if (index > -1) {
              chat_history.splice(index, 1);
            }
          } else {
            socket.emit('notify','error','chatMissingParameters');
          }
        } else {
          socket.emit('notify','error','chatModAccess');
        }
      } else {
        return socket.emit('notify','error','chatUnknownCommand');
      }
    } else {
      if(((chat_muted === false) && (user.muted == 0)) || (user.rank != 'user')){
      connection.query('SELECT `total_bet` FROM `users` WHERE `steamid` = '+connection.escape(user.steamid)+' LIMIT 1', function(err, row) {
        if(err) {
          socket.emit('notify','error','serverError');
          return;
        } else {
          if((row[0].total_bet < 1000) && (user.rank == 'user')) {
            socket.emit('notify','error','chatNotEnoughBets',[row[0].total_bet, 1000]);
            return;
          } else {
            chat.message = chat.message.replace(/<\/?[^>]+(>|$)/g, "");
            var uniqueID = generate(20);
            io.sockets.emit('chat message', {
              message: chat.message,
              profile: {
                avatar: user.avatar,
                rank: user.rank,
                steamid: user.steamid,
                username: user.username
              },
              time: time(),
              uniqueID: uniqueID
            });
            array_limit({
              message: chat.message,
              profile: {
                avatar: user.avatar,
                rank: user.rank,
                steamid: user.steamid,
                username: user.username
              },
              time: time(),
              uniqueID: uniqueID
            });
      }
      }
      });
    } else {
      return socket.emit('notify','error','chatIsMuted');
    }
    }
    }
  });
});



setInterval(function() {

var online = Object.keys(users).length;
  io.sockets.emit('users online', online);
},5000);

setInterval(function() {
 connection.query('SELECT * FROM `GA`', function(errGA, rowGA) {
  var giveAwayAmountOfTickets = rowGA.length;
  var giveAwayAmountToWin = giveAwayAmountOfTickets * 500 * 0.95;
  io.sockets.emit('giveaway amount', giveAwayAmountToWin);
  io.sockets.emit('giveaway tickets', giveAwayAmountOfTickets);
 });
 connection.query('SELECT COUNT(DISTINCT `steamid`) FROM `GA`', function(errGAU, rowGAU) {
  var giveAwayAmountOfUsers = rowGAU.length;
  io.sockets.emit('giveaway users', giveAwayAmountOfUsers);
 });
},5000);



function crashWithdraw(user){
  if(cstatus === 'closed'){
    var find = cbets.find(x => x.profile.steamid == user.steamid);
    if(find == undefined) return;
    if(find.done) return;
    find.done = 1;
    var multiplier = growthFunc(ctime);
    var profit = Math.floor(find.bet * multiplier);
    connection.query('UPDATE `users` SET `wallet` = `wallet` + '+profit+', `total_won` = `total_won` + '+profit+' WHERE `steamid` = '+connection.escape(user.steamid), function(err) {
        if(err){
          console.log('important error at wallet increase');
          console.log(err);
          if (users[user.steamid]) {
            users[user.steamid].socket.forEach(function(asocket) {
              if(io.sockets.connected[asocket])
              io.sockets.connected[asocket].emit('notify','error','serverError');
            });
          }
          return;
        } else {
          if (users[user.steamid]) {
            users[user.steamid].socket.forEach(function(asocket) {
              if(io.sockets.connected[asocket])
              io.sockets.connected[asocket].emit('balance change', profit);
            });
          }
          io.sockets.to('crash').emit('player drop',{
            bet: find.bet,
            multiplier: multiplier.toFixed(2).toString(),
            profile: {
              avatar: find.profile.avatar,
              steamid: find.profile.steamid,
              username: find.profile.username
            },
            profit: profit
          });
          connection.query('INSERT INTO `wallet_change` SET `user` = '+connection.escape(user.steamid)+', `change` = '+connection.escape(profit)+', `reason` = \'Crash #'+cgame+' '+'winning - '+multiplier.toFixed(2)+'\'', function(err2) {
            if(err2){
              console.log('database error at wallet_change');
              console.log(err2);
              return;
            }
          });
        }
    });
  } else return;
}

function jackpotTimer(){
  jpTimeleft = jpTime;
  jpAllow = true;
  io.sockets.to('jackpot').emit('jackpot new',jpTime);
  var _timeleft = setInterval(function(){
    --jpTimeleft;
    if(jpTimeleft == 1) jpAllow = false;
    else if(jpTimeleft == 0) {
      var winnerNumber = getRandomInt(1,jpPool);
      var winnerObject = jpBets.find(x => x.rangeMin <= winnerNumber && x.rangeMax >= winnerNumber);
      var winner = winnerObject.player.steamid;
      var winSum = (jpPool-parseInt(winnerObject.amount))-Math.floor((jpPool-parseInt(winnerObject.amount))*0.10)+parseInt(winnerObject.amount);
		rakeSum = (jpPool-parseInt(winnerObject.amount))-Math.floor((jpPool-parseInt(winnerObject.amount))*0.90)+parseInt(winnerObject.amount);      
	  if(jpBets.length >= 2) {
	  connection.query('UPDATE `users` SET `wallet` = `wallet` + '+winSum+', `total_won` = `total_won` + '+winSum+' WHERE `steamid` = '+connection.escape(winner), function(err69, row69) {
        if(err69){
          return;
        } else {
          connection.query('INSERT INTO `wallet_change` SET `user` = '+connection.escape(winner)+', `change` = '+connection.escape(winSum)+', `reason` = \'Jackpot winning!'+'\'', function(err70) {
            connection.query('UPDATE `rake` SET `jackpot` = `jackpot` + '+rakeSum+'');
			if(err70){
              console.log('database error at wallet_change');console.log(err70);
            }
            jpBets.forEach(function(obj) {
                if(JSON.stringify(obj) !== JSON.stringify(winnerObject)){
                  connection.query('UPDATE `users` SET `total_lose` = `total_lose` + '+obj.amount+' WHERE `steamid` = '+connection.escape(obj.player.steamid), function(err71) {
                    if(err71) console.log('error at total lose increase');
                  });
                  if (users[obj.player.steamid]) {
                    users[obj.player.steamid].socket.forEach(function(asocket) {
                      if(io.sockets.connected[asocket])
                      io.sockets.connected[asocket].emit('','','',[obj.amount]);
                    });
                  }
                }
            });
            jp_limit(winnerObject);
            if (users[winner]) {
              users[winner].socket.forEach(function(asocket) {
                if(io.sockets.connected[asocket])
                io.sockets.connected[asocket].emit('balance change', winSum);
                if(io.sockets.connected[asocket])
                io.sockets.connected[asocket].emit('notify','success','jackpotWon',[winSum]);
              });
            }
            var avatars = [];
            jpBets.forEach(function(obj) {avatars.push(obj.player)});
            io.sockets.to('jackpot').emit('jackpot end',{
              winner: winnerObject.player,
              players: avatars,
              won: winSum
            });
            clearInterval(_timeleft);
            jpPool = 0; jpBets = []; jpUsers = []; jpAllow = true; jpTimeleft = -1;
          });
        }
      });
    } else {
  connection.query('SELECT * FROM `users` WHERE `steamid` = '+connection.escape(winner)+' LIMIT 1', function(jperror, jpuserour){
        if(jperror){
          return;
        } else {
	connection.query('UPDATE `users` SET `wallet` = `wallet` + '+winSum+', `wager` = `wager` - '+winSum+', `total_bet` = `total_bet` - '+winSum+' WHERE `steamid` = '+connection.escape(winner), function(err69, row69) {
        if(err69){
          return;
        } else {
		  if(jpuserour[0].deposit_sum <= 2500) {
			 connection.query('UPDATE `users` SET `wager` = `wager` + '+winSum+' WHERE `steamid` = '+connection.escape(winner)); 
		  }
          connection.query('INSERT INTO `wallet_change` SET `user` = '+connection.escape(winner)+', `change` = '+connection.escape(winSum)+', `reason` = \'Jackpot winning!'+'\'', function(err70) {
            connection.query('UPDATE `rake` SET `jackpot` = `jackpot` + '+rakeSum+'');
			if(err70){
              console.log('database error at wallet_change');console.log(err70);
            }
            jpBets.forEach(function(obj) {
                if(JSON.stringify(obj) !== JSON.stringify(winnerObject)){
                  connection.query('UPDATE `users` SET `total_lose` = `total_lose` + '+obj.amount+' WHERE `steamid` = '+connection.escape(obj.player.steamid), function(err71) {
                    if(err71) console.log('error at total lose increase');
                  });
                  if (users[obj.player.steamid]) {
                    users[obj.player.steamid].socket.forEach(function(asocket) {
                      if(io.sockets.connected[asocket])
                      io.sockets.connected[asocket].emit('','','',[obj.amount]);
                    });
                  }
                }
            });
            jp_limit(winnerObject);
            if (users[winner]) {
              users[winner].socket.forEach(function(asocket) {
                if(io.sockets.connected[asocket])
                io.sockets.connected[asocket].emit('balance change', winSum);
                if(io.sockets.connected[asocket])
                io.sockets.connected[asocket].emit('notify','success','jackpotWon',[winSum]);
              });
            }
            var avatars = [];
            jpBets.forEach(function(obj) {avatars.push(obj.player)});
            io.sockets.to('jackpot').emit('jackpot end',{
              winner: winnerObject.player,
              players: avatars,
              won: winSum
            });
            clearInterval(_timeleft);
            jpPool = 0; jpBets = []; jpUsers = []; jpAllow = true; jpTimeleft = -1;
          });
        }
      });
	}
	});
	}
	}
  },1000);
}

function checkTimer() {
  if((timer == -1) && (!pause)) {
    timer = accept+wait;
    timerID = setInterval(function() {
      //console.log(timer);
      if (timer == 0) {
        away();
        lastrolls.push(winningNumber);
      }
      if(timer == -100) {
        currentBets = {'red': [], 'green': [], 'black': []};
        usersBr = {};
        timer = accept+wait;
        currentRollid = currentRollid+1;
        pause = false;
        actual_hash = sha256(generate(118)+'FUCKINGRETARDSINTHISFUCKINGCSGOGAMEXDDD'+sha256('ripGAME')+getRandomInt(1,100));
        io.sockets.to('roulette').emit('roulette new round', 15, actual_hash);
      }
      timer = timer-1;
    }, 100);
  }
}

function away() {
  pause = true;
  var secret = generate(20);
  var sh = sha256(sha256(actual_hash)+'WHATTHEFUCK'+currentRollid+'sweetcat'+secret);
  winningNumber = sh.substr(0, 8);
  winningNumber = parseInt(winningNumber, 16);
  winningNumber = math.abs(winningNumber) % 15;
  console.log('Rolled: '+winningNumber);
  console.log('Round #'+currentRollid+' secret: '+secret);
  io.sockets.to('roulette').emit('roulette ends', {
    id: currentRollid,
    winningNumber: winningNumber,
    secret: secret,
    hash: actual_hash,
    shift: Math.random()
  });
  setTimeout(function() {
    if((winningNumber >= 1) && (winningNumber <= 7)) { 
      currentBets['red'].forEach(function(itm) {
        connection.query('UPDATE `users` SET `wallet` = `wallet` + '+itm.amount*2+', `total_won` = `total_won` + '+itm.amount*2+' WHERE `steamid` = '+connection.escape(itm.player.steamid), function(err) {
          if(err){
            console.log('important error at wallet increase');
            console.log(err);
            if (users[itm.player.steamid]) {
              users[itm.player.steamid].socket.forEach(function(asocket) {
                if(io.sockets.connected[asocket])
                io.sockets.connected[asocket].emit('notify','error','serverError');
              });
            }
            return;
          } else {
            if (users[itm.player.steamid]) {
              users[itm.player.steamid].socket.forEach(function(asocket) {
                if(io.sockets.connected[asocket])
                io.sockets.connected[asocket].emit('balance change', itm.amount*2);
              });
            }
            connection.query('INSERT INTO `wallet_change` SET `user` = '+connection.escape(itm.player.steamid)+', `change` = '+connection.escape(itm.amount*2)+', `reason` = \'Roulette #'+currentRollid+' '+'winning!'+'\'', function(err2) {
              if(err2){
                console.log('database error at wallet_change');
                console.log(err2);
                return;
              }
            });
          }
        });
      });
      currentBets['black'].forEach(function(itm) {
        connection.query('UPDATE `users` SET `total_lose` = `total_lose` + '+itm.amount+' WHERE `steamid` = '+connection.escape(itm.player.steamid), function(err) {
		connection.query('UPDATE `rake` SET `roulette` = `roulette` + '+itm.amount+''); 
		if(err) console.log('error at total lose increase');
        });
      });
      currentBets['green'].forEach(function(itm) {
        connection.query('UPDATE `users` SET `total_lose` = `total_lose` + '+itm.amount+' WHERE `steamid` = '+connection.escape(itm.player.steamid), function(err) {
		connection.query('UPDATE `rake` SET `roulette` = `roulette` + '+itm.amount+''); 
		if(err) console.log('error at total lose increase');
        });
      });
    }
    if((winningNumber >= 8) && (winningNumber <= 14)) { 
      currentBets['black'].forEach(function(itm) {
        connection.query('UPDATE `users` SET `wallet` = `wallet` + '+itm.amount*2+', `total_won` = `total_won` + '+itm.amount*2+' WHERE `steamid` = '+connection.escape(itm.player.steamid), function(err) {
          if(err){
            console.log('important error at wallet increase');
            console.log(err);
            if (users[itm.player.steamid]) {
              users[itm.player.steamid].socket.forEach(function(asocket) {
                if(io.sockets.connected[asocket])
                io.sockets.connected[asocket].emit('notify','error','serverError');
              });
            }
            return;
          } else {
            if (users[itm.player.steamid]) {
              users[itm.player.steamid].socket.forEach(function(asocket) {
                if(io.sockets.connected[asocket])
                io.sockets.connected[asocket].emit('balance change', itm.amount*2);
              });
            }
            connection.query('INSERT INTO `wallet_change` SET `user` = '+connection.escape(itm.player.steamid)+', `change` = '+connection.escape(itm.amount*2)+', `reason` = \'Roulette #'+currentRollid+' '+'winning!'+'\'', function(err2) {
              if(err2){
                console.log('database error at wallet_change');
                console.log(err2);
                return;
              }
            });
          }
        });
      });
      currentBets['red'].forEach(function(itm) {
        connection.query('UPDATE `users` SET `total_lose` = `total_lose` + '+itm.amount+' WHERE `steamid` = '+connection.escape(itm.player.steamid), function(err) {
        connection.query('UPDATE `rake` SET `roulette` = `roulette` + '+itm.amount+'');  
		  if(err) console.log('error at total lose increase');
        });
      });
      currentBets['green'].forEach(function(itm) {
        connection.query('UPDATE `users` SET `total_lose` = `total_lose` + '+itm.amount+' WHERE `steamid` = '+connection.escape(itm.player.steamid), function(err) {
          connection.query('UPDATE `rake` SET `roulette` = `roulette` + '+itm.amount+''); 
		  if(err) console.log('error at total lose increase');
        });
      });
    }
    if((winningNumber >= 0) && (winningNumber <= 0)) { 
      currentBets['green'].forEach(function(itm) {
        connection.query('UPDATE `users` SET `wallet` = `wallet` + '+itm.amount*14+', `total_won` = `total_won` + '+itm.amount*14+' WHERE `steamid` = '+connection.escape(itm.player.steamid), function(err) {
          if(err){
            console.log('important error at wallet increase');
            console.log(err);
            if (users[itm.player.steamid]) {
              users[itm.player.steamid].socket.forEach(function(asocket) {
                if(io.sockets.connected[asocket])
                io.sockets.connected[asocket].emit('notify','error','serverError');
              });
            }
            return;
          } else {
            if (users[itm.player.steamid]) {
              users[itm.player.steamid].socket.forEach(function(asocket) {
                if(io.sockets.connected[asocket])
                io.sockets.connected[asocket].emit('balance change', itm.amount*14);
              });
            }
            connection.query('INSERT INTO `wallet_change` SET `user` = '+connection.escape(itm.player.steamid)+', `change` = '+connection.escape(itm.amount*14)+', `reason` = \'Roulette #'+currentRollid+' '+'winning!'+'\'', function(err2) {
              if(err2){
                console.log('database error at wallet_change');
                console.log(err2);
                return;
              }
            });
          }
        });
      });
      currentBets['black'].forEach(function(itm) {
        connection.query('UPDATE `users` SET `total_lose` = `total_lose` + '+itm.amount+' WHERE `steamid` = '+connection.escape(itm.player.steamid), function(err) {
		connection.query('UPDATE `rake` SET `roulette` = `roulette` + '+itm.amount+'');          
		 if(err) console.log('error at total lose increase');
        });
      });
      currentBets['red'].forEach(function(itm) {
        connection.query('UPDATE `users` SET `total_lose` = `total_lose` + '+itm.amount+' WHERE `steamid` = '+connection.escape(itm.player.steamid), function(err) {
		connection.query('UPDATE `rake` SET `roulette` = `roulette` + '+itm.amount+''); 
		if(err) console.log('error at total lose increase');
        });
      });
    }
  console.log('Done.');
  }, 7000);
  connection.query('INSERT INTO `roll_history` SET `roll` = '+connection.escape(winningNumber)+', `time` = '+connection.escape(time())+', `hash` = '+connection.escape(actual_hash));
}

/*                                                                                                                                                              */
/*                                                                                   BOT PART                                                                   */
/*                                                                                                                                                              */







/*                                                                                                                                                              */
/*                                                                                FUNCTIONS PART                                                                */
/*                                                                                                                                                              */

function load() {
  connection.query('SET NAMES utf8');
  connection.query('SELECT `id` FROM `roll_history` ORDER BY `id` DESC LIMIT 1', function(err, row) {
    if(err) {
      console.log('Can not get number from the last game');
      console.log(err);
      process.exit(0);
    }
    if(!row.length) {
      currentRollid = 1;
    } else {
      currentRollid = parseInt(row[0].id)+1;
    }
  });
  loadHistory();
}

function loadHistory() {
  connection.query('SELECT * FROM `roll_history` ORDER BY `id` LIMIT 10', function(err, row) {
    if(err) {
      console.log('Error while loading last rolls history');
      console.log(err);
      process.exit(0);
    }
    row.forEach(function(itm) {
      lastrolls.push(itm.roll);
    });
  });
  server.listen(8080);
}

function time() {
  return parseInt(new Date().getTime()/1000)
}

function generate(count) {
    return crypto.randomBytes(count).toString('hex');
}

function array_limit(wartosc){
  if(chat_history.length==25){
    chat_history.shift();
    chat_history.shift();
  }
  chat_history.push(wartosc);
}

function jp_limit(wartosc){
  if(jpWinners.length==10){
    jpWinners.shift();
  }
  jpWinners.push(wartosc);
}

function getRandomInt(min, max) {
    return Math.floor(Math.random() * (max - min + 1)) + min;
}