/**
 * @Author: Thibault Napoléon <Imothep>
 * @Company: ISEN Yncréa Ouest
 * @Email: thibault.napoleon@isen-ouest.yncrea.fr
 * @Created Date: 29-Jan-2018 - 16:48:07
 * @Last Modified: 05-Feb-2018 - 23:30:24
 */

'use strict';

var login = 'cir2';
var twitts = ['Twitt n°1', 'Twitt n°2', 'Twitt n°3', 'Twitt n°4', 'Twitt n°5',
  'Twitt n°6', 'Twitt n°7', 'Twitt n°8', 'Twitt n°9'];
var current = 'Liste des twitts';

ajaxRequest('GET', 'php/request.php/twitts/', displayTwitts);
$('#all-button').unbind('click').click(function ()
{
  current = 'Liste des twitts';
  ajaxRequest('GET', 'php/request.php/twitts/', displayTwitts);
});
$('#my-button').unbind('click').click(function ()
{
  current = 'Liste de mes twitts';
  ajaxRequest('GET', 'php/request.php/twitts/?login=' + login, displayTwitts);
});
$('#add-button').unbind('click').click(function (event){
  event.preventDefault();
  ajaxRequest('POST', 'php/request.php/twitts/', function ()
  {
    ajaxRequest('GET', 'php/request.php/twitts/', displayTwitts);
  }, 'login=' + login + '&text=' + $('#twitt').val());
});

//------------------------------------------------------------------------------
//--- displayTwitts ------------------------------------------------------------
//------------------------------------------------------------------------------
// Display twitts.
// \param ajaxResponse The data received via the Ajax request.
function displayTwitts(ajaxResponse)
{
  var data;
  var text;

  // Decode JSON response.
  data = JSON.parse(ajaxResponse);

  // Fill twiits.
  $('#twitts').html('<h3>' + current + '</h3>');
  for (var i = 0; i < data.length; i++)
  {
    $('#twitts').append(
      '<div class="panel panel-default"><div class="panel-body">' +
      data[i].login + ' : ' + data[i].text +
      '<a><span id=del' + data[i].id +
      ' class="glyphicon glyphicon-trash pull-right" aria-hidden="true"></a>' +
      '<a><span id=mod' + data[i].id +
      ' class="glyphicon glyphicon-pencil pull-right" aria-hidden="true">' +
      '&nbsp;</a></div></div>');

    $('#mod' + data[i].id).unbind('click').click(function (event)
    {
      var id = event.target.id.substr(3);
      var textNum =
      ajaxRequest('PUT', 'php/request.php/twitts/' + id, function ()
        {
          ajaxRequest('GET', 'php/request.php/twitts/', displayTwitts);
        }, 'login=' + login + '&text=' + twitts[Math.floor(Math.random()*10)]);
    });
    $('#del' + data[i].id).unbind('click').click(function (event)
    {
      var id = event.target.id.substr(3);
      ajaxRequest('DELETE', 'php/request.php/twitts/' + id +'?login=' +
        login, function ()
        {
          ajaxRequest('GET', 'php/request.php/twitts/', displayTwitts);
        });
    });
  }
}
