//admin-list.php input validation
$( "input" ).on('input',function() {
    if($(this).val().length >30 ){
        $(this).css("color", "red");
    } else {
        $(this).css("color", "black")
    }
});

$('form').submit(function() {
    for(let i=1;i<$('input').length;i++){
        if($('input').eq(i).val().length>30){
            return false;
        }
    }
});