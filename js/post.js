this.ajaxPost=function(e,t,n,r){
    if(typeof n=="undefined"){
        n=false
    }
    if(typeof r=="undefined"){
        r=false
    }
    var i=$("form").serialize();
    $.ajax({type:"post",url:e,data:i,beforeSend:function(){
        $("#carregando").show();
        $(t).html("Carregando...")
    },
    success:function(e){
        $(t).hide();
        $(t).html(e);
        $(t).fadeIn("slow");
        $("#carregando").hide();
        if(n){
            n.call()
        }
    },
    error:function()
    {
        alert("ERRO ao executar função de transição !");
        return false
    }
});
if(r){
    setTimeout(function(){
        $(t).hide()
    },1e4)
}
return true
}