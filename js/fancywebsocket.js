var FancyWebSocket = function(url)
{
	var callbacks = {};
	var ws_url = url;
	var conn;
<<<<<<< HEAD
=======
	
>>>>>>> 09ac4f20846b19b0921855aeaa2fbb6b3109855b
	this.bind = function(event_name, callback)
	{
		callbacks[event_name] = callbacks[event_name] || [];
		callbacks[event_name].push(callback);
		return this;
	};
<<<<<<< HEAD

=======
	
>>>>>>> 09ac4f20846b19b0921855aeaa2fbb6b3109855b
	this.send = function(event_name, event_data)
	{
		this.conn.send( event_data );
		return this;
	};
<<<<<<< HEAD
=======
	
>>>>>>> 09ac4f20846b19b0921855aeaa2fbb6b3109855b
	this.connect = function() 
	{
		if ( typeof(MozWebSocket) == 'function' )
		this.conn = new MozWebSocket(url);
		else
		this.conn = new WebSocket(url);
		
		this.conn.onmessage = function(evt)
		{
			dispatch('message', evt.data);
		};
		
		this.conn.onclose = function(){dispatch('close',null)}
		this.conn.onopen = function(){dispatch('open',null)}
	};
	
	this.disconnect = function()
	{
		this.conn.close();
	};
<<<<<<< HEAD

=======
	
>>>>>>> 09ac4f20846b19b0921855aeaa2fbb6b3109855b
	var dispatch = function(event_name, message)
	{
		if(message == null || message == "")//aqui es donde se realiza toda la accion
			{
<<<<<<< HEAD
				
			}
			else
			{
				//PONER AKI LAS NOTIFICACIONES EN TIEMPO REAL
=======
			}
			else
			{
>>>>>>> 09ac4f20846b19b0921855aeaa2fbb6b3109855b
				var JSONdata    = JSON.parse(message); //parseo la informacion
				switch(JSONdata[0].actualizacion)//que tipo de actualizacion vamos a hacer(un nuevo mensaje, solicitud de amistad nueva, etc )
				{
					case '1':
					actualiza_mensaje(message);
					break;
					case '2':
					actualiza_solicitud(message);
					break;
					
				}
				//aqui se ejecuta toda la accion
<<<<<<< HEAD
=======
				
				
				
				
				
				
>>>>>>> 09ac4f20846b19b0921855aeaa2fbb6b3109855b
			}
	}
};

var Server;
function send( text ) 
{
    Server.send( 'message', text );
}
$(document).ready(function() 
{
<<<<<<< HEAD
	Server = new FancyWebSocket('ws://192.168.1.62:12345');
=======
	Server = new FancyWebSocket('ws://192.168.1.3:12345');
>>>>>>> 09ac4f20846b19b0921855aeaa2fbb6b3109855b
    Server.bind('open', function()
	{
    });
    Server.bind('close', function( data ) 
	{
    });
    Server.bind('message', function( payload ) 
	{
    });
    Server.connect();
});



<<<<<<< HEAD

=======
function actualiza_mensaje(message)
{
	var JSONdata    = JSON.parse(message); //parseo la informacion
				var tipo = JSONdata[0].tipo;
				var mensaje = JSONdata[0].mensaje;
				var fecha = JSONdata[0].fecha;
				
				var contenidoDiv  = $("#"+tipo).html();
				var mensajehtml   = fecha+' : '+mensaje;
				
				$("#"+tipo).html(contenidoDiv+'0000111'+mensajehtml);
}
>>>>>>> 09ac4f20846b19b0921855aeaa2fbb6b3109855b
function actualiza_solicitud()
{
	alert("tipo de envio 2");
}
