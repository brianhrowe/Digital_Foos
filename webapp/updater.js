var updater = Class.create({  
    initialize: function(divToUpdate, match_id, interval, file) {  
        this.divToUpdate = divToUpdate;  
        this.match_id = match_id;
		this.interval = interval;
        this.file = file;  
        new PeriodicalExecuter(this.getUpdate.bind(this), this.interval);  
    },  
      
    getUpdate: function() {  
        var div = this.divToUpdate;  
        var matchid = this.match_id;  
        var file = this.file;              
        var oOptions = {  
            method: "POST",  
            asynchronous: true,  
            parameters: "match_id="+matchid,  
            onComplete: function (oXHR, Json) {  
                $(div).innerHTML = oXHR.responseText;  
            }  
        };  
        var oRequest = new Ajax.Updater(div, file, oOptions);  
    }  
});  