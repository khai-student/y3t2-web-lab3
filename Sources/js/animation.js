function animation(){
   var logo = document.getElementById('logoBall');
   var positionXstart = logo.offsetLeft;
   var positionYstart = logo.offsetTop;
   var positionX = 0;
   var positionY = 0;
   var id = setInterval(anim, 1000/120);
   var dur = true;

   function anim() {
      if (positionX >= 600 && positionY == 31) {
         logo.style.top = positionYstart + "px";
         logo.style.left = positionXstart + "px";
         clearInterval(id);
         return;
      }
      if (dur) {
         logo.style.top = positionYstart + positionY + "px";
         logo.style.left = positionXstart + positionX*0.5 + "px";
         positionY++;
         positionX++;
      } else {
         logo.style.top = positionYstart + positionY + "px";
         logo.style.left = positionXstart + positionX*0.5 + "px";
         positionY--;
         positionX++;
      }
      if(positionY == 31 || positionY == 0){
         dur = !dur;
      }

   }
}
