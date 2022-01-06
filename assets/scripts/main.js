
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
//end admin-list.php input validation


//slider for rooms photo
var slideIndex = 1;
let changeNum = 0;
let inpSlideHidden = document.getElementsByClassName('slid');
let inpSlideHiddenVal = 0;

let prev = document.getElementsByClassName('prev');
let next = document.getElementsByClassName('next');
for(let i=0;i<prev.length;i++){
    prev[i].addEventListener("click",function(){
        console.log('prev');
        changeNum = this.getAttribute('data');
        let photoCount = document.getElementsByClassName("photoCount"+changeNum)[0].value;
        let showPhotoIndex = document.getElementsByClassName("showPhotoIndex"+changeNum)[0].value;
        if(showPhotoIndex==1){
            showPhotoIndex = photoCount--;
            document.getElementsByClassName("showPhotoIndex"+changeNum)[0].value = showPhotoIndex;
            let thisdiv = document.getElementsByClassName('roomsId_'+changeNum);
            for(let t=0;t<thisdiv.length;t++){
                thisdiv[t].setAttribute('style','display:none');
            }
            thisdiv[showPhotoIndex-1].setAttribute('style','display:block');
        } else {
            showPhotoIndex--;
            document.getElementsByClassName("showPhotoIndex"+changeNum)[0].value = showPhotoIndex;
            let thisdiv = document.getElementsByClassName('roomsId_'+changeNum);
            for(let t=0;t<thisdiv.length;t++){
                thisdiv[t].setAttribute('style','display:none');
            }
            thisdiv[showPhotoIndex-1].setAttribute('style','display:block');
        }
        console.log(showPhotoIndex);       
        
    })
}
for(let i=0;i<next.length;i++){
    next[i].addEventListener("click",function(){
        console.log('next');
        changeNum = this.getAttribute('data');
        let photoCount = document.getElementsByClassName("photoCount"+changeNum)[0].value;
        let showPhotoIndex = document.getElementsByClassName("showPhotoIndex"+changeNum)[0].value;
        if(showPhotoIndex==photoCount){
            showPhotoIndex = 1;
            document.getElementsByClassName("showPhotoIndex"+changeNum)[0].value = showPhotoIndex;
            let thisdiv = document.getElementsByClassName('roomsId_'+changeNum);
            for(let t=0;t<thisdiv.length;t++){
                thisdiv[t].setAttribute('style','display:none');
            }
            thisdiv[showPhotoIndex-1].setAttribute('style','display:block');
        } else {
            showPhotoIndex++;
            document.getElementsByClassName("showPhotoIndex"+changeNum)[0].value = showPhotoIndex;
            let thisdiv = document.getElementsByClassName('roomsId_'+changeNum);
            for(let t=0;t<thisdiv.length;t++){
                thisdiv[t].setAttribute('style','display:none');
            }
            thisdiv[showPhotoIndex-1].setAttribute('style','display:block');
        }
        console.log(showPhotoIndex);       
        
    })
}


//end slider for rooms photo























