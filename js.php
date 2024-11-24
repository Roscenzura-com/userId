<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<meta name="viewport" content="width=700">
<meta name="format-detection" content="telephone=no">
<title>Test</title>
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<script type="text/javascript">


var idUser = {

		  url: 'setId.php', // /checkIpLite/, 	  
		  data: { "navigator": {}, "screen":{}, "plugins": "", "timezone": '' },
		  idData: {},
		  isSaved: false,
		  propExclude: ['appVersion', 'orientation'],
		  idecho : "echo",
		  
		  start: function(){
		  
		  	if (window.localStorage) this.isSaved=localStorage.getItem('idUserCheckIpLite');
			
		    console.log("storage:" + this.isSaved);
		  }, 
		 
		 
		  save: function(){
		  
		  	localStorage.setItem('idUserCheckIpLite', true);
		  },  
		  
		  

		  get: function(){
				
				for(var prop in navigator) {

					if (navigator[prop] instanceof Object || navigator[prop]==='') continue;

					this.data['navigator'][prop]=navigator[prop];
				}
				
				for(var prop in screen) {

					if (navigator[prop] instanceof Object || screen[prop]==='') continue;

					this.data['screen'][prop]=screen[prop];
				}
				
				var prev;
				var plaginsArr= [];
		
				for(var i=0;i<navigator.plugins.length;i++) {
			
					var plugin = navigator.plugins[i];
			
					var plugin = plugin.name+(plugin.version || '');
			
					if (prev == plugin ) continue;
					
					plaginsArr.push(plugin);
					
					prev = plugin;
				}
				
				this.data['plugins']=plaginsArr.join(', ');
					
				this.data['timezone']=-new Date().getTimezoneOffset()/60;		
				
				
				for(var key in this.data) {

					if (this.data[key] instanceof Object)
					{
						for(var key2 in this.data[key]) 
						{

							if (this.propExclude.indexOf(key2) == -1) this.idData[key2]=this.data[key][key2];
						}
					
					}
					else 
					{
						if (this.propExclude.indexOf(key) == -1) this.idData[key]=this.data[key];
						
					}	
				}
				
		  },	
		  
		  	  	
		 sendData: function(){
				
				var _this=this;
				
				$.ajax({
					url: this.url,
					method: 'post',
					dataType: 'html',
					data: this.idData,
					success: function(data){

						_this.save();
					 
					}
				});
		  }, 
		  
						
		  echo:function(){
				
				for(var key in this.idData) console.log(key + ":" + this.idData[key]);
		  } 		

}


$(document).ready(function() {

  idUser.start();
  
  if (!idUser.isSaved)
  {
  	 idUser.get();
   
  	 setTimeout(function(){ idUser.echo(); },3000);
  	 setTimeout(function(){ idUser.sendData(); } , 3000); 
	 
   }
});
</script>
</head>
<body>
<div id="echo">

</div>

</body>
</html>
