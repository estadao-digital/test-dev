var Connection2 = (function(){

    function Connection2(url) {

        this.open = false;

        this.socket = new WebSocket("wss://" + url);
        this.setupConnectionEvents();
    }

    Connection2.prototype = {
        setupConnectionEvents : function () {
            var self = this;

            self.socket.onopen = function(evt) { self.connectionOpen(evt); };
            self.socket.onmessage = function(evt) { self.connectionMessage(evt); };
            self.socket.onclose = function(evt) { self.connectionClose(evt); };
        },

        connectionOpen : function(evt){
            this.open = true;
        },
        connectionMessage : function(evt){
            var data = JSON.parse(evt.data);

            this.addChatMessage(data.msg);
        },
        connectionClose : function(evt){
            this.open = false;
        },

        sendMsg : function(message){
            this.socket.send(JSON.stringify({
                msg : message
            }));
        },

        addChatMessage : function(data){
            console.log(data);
            if(data == 'check_new') {
                load_item(true, false);
            }

        },

    };

    return Connection2;

})();
