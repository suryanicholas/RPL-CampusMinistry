$("#confirmation-button").click(function(){
    if($(".confirmation-area").hasClass("show")){
        $(".confirmation-area").removeClass("show");
        setTimeout(function(){
            $(".logout-confirmation").css('display','none');
        },500);
    } else{
        $(".logout-confirmation").css('display','flex');
        setTimeout(function(){
            $(".confirmation-area").addClass("show");
        },10);
    }
});
function cancelConfirmation(){
    $(".confirmation-area").removeClass("show");
    setTimeout(function(){
        $(".logout-confirmation").css('display','none');
    },500);
}