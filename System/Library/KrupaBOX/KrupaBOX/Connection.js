(function(window) {

    window.Connection = {};

    Connection.getHost = function()
    {
        var docLocation = document.location;

        var host = null;
        if (docLocation.host != null)
            host = docLocation.host;
        else if(docLocation.hostname != null)
            host = docLocation.hostname;
        else if(docLocation.hostname != null)
            host = docLocation.hostname;

        host = String.from(host);

        if (host.startsWith("https")) host = host.substring(5, host.length);
        if (host.startsWith("http"))  host = host.substring(4, host.length);
        if (host.startsWith("://"))   host = host.substring(3, host.length);
        if (host.startsWith("//"))    host = host.substring(2, host.length);

        return host;
    };

    Connection.getProtocol = function()
    {
        var protocol = window.location.protocol;
        protocol = protocol.toString();
        if (protocol.endsWith(":"));
            protocol = protocol.subString(0, protocol.length - 1);
        protocol = protocol.toLower();
        if (protocol.isEmpty() == true)
            return null;
        return protocol;
    };

    Connection.getIpAddress = function()
    { return PostProcess.data.global.connection.ipAddress; };

    Connection.getLocation = function(delegate)
    {
        if (FunctionEx.isFunction(delegate) == false)
            return null;

        var request = new Http.Request(PostProcess.data.global.front.base + "/.async/");
        request.method      = "post";
        request.dataType    = "json";
        request.data.hash   = Browser.getHash();
        request.data.action = "Connection.getLocation";

        request.send(function(callback)
        { if (callback.error == "NULL") callback = null; delegate(callback); });
    };

    Connection.getLocalIpAddress = function(delegate)
    {
        if (FunctionEx.isFunction(delegate) == false)
            return null;
        var callback = delegate;
        var ip_dups = {};
        var RTCPeerConnection = window.RTCPeerConnection || window.mozRTCPeerConnection || window.webkitRTCPeerConnection;
        var useWebKit = !!window.webkitRTCPeerConnection;
        if(!RTCPeerConnection) {
            var win = iframe.contentWindow;
            RTCPeerConnection = win.RTCPeerConnection || win.mozRTCPeerConnection || win.webkitRTCPeerConnection;
            useWebKit = !!win.webkitRTCPeerConnection;
        }
        var mediaConstraints = { optional: [{RtpDataChannels: true}] };
        var servers = {iceServers: [{urls: "stun:stun.services.mozilla.com"}]};
        var pc = new RTCPeerConnection(servers, mediaConstraints);
        function handleCandidate(candidate){
            var ip_regex = /([0-9]{1,3}(\.[0-9]{1,3}){3}|[a-f0-9]{1,4}(:[a-f0-9]{1,4}){7})/
            var ip_addr = ip_regex.exec(candidate)[1];
            if(ip_dups[ip_addr] === undefined)
                callback(ip_addr);
            ip_dups[ip_addr] = true;
        }
        pc.onicecandidate = function(ice) { if(ice.candidate) handleCandidate(ice.candidate.candidate); };
        pc.createDataChannel("");
        pc.createOffer(function(result){ pc.setLocalDescription(result, function(){}, function(){}); }, function(){});
        setTimeout(function(){
            var lines = pc.localDescription.sdp.split('\n');
            lines.forEach(function(line){ if(line.indexOf('a=candidate:') === 0) handleCandidate(line); });
        }, 1000);
    };

})(window);
