

function touch(selector, leftCallable = null, rightCallable = null, upCallable = null, downCallable = null){
    let touchStartX = 0;
    let touchStartY = 0;
    let touchEndX = 0;
    let touchEndY = 0;
    let zoneTouched = document.querySelectorAll("."+selector);

    zoneTouched[0].addEventListener("touchstart", function (event) {
        // Change the variables (start)
        touchStartX = event.changedTouches[0].screenX;
        touchStartY = event.changedTouches[0].screenY;
      });

      zoneTouched[0].addEventListener("touchend", function (event) {
        // Change the needed variables (end)
        touchEndX = event.changedTouches[0].screenX;
        touchEndY = event.changedTouches[0].screenY;
        // Do the action
        executed();
      });
      function executed(){
        if (touchEndX < touchStartX) { //Esto pasa cuando desliza a la izquierda
            if(leftCallable != null){
                leftCallable();
            }
          }
          if (touchEndX > touchStartX) { //Esto pasa cuando desliza a la derecha
            if(rightCallable != null){
                rightCallable();
            }
          }
           if (touchEndY < touchStartY) {
            if(downCallable != null){
                downCallable();
            }
          }
          if (touchEndY > touchStartY) {
            if(upCallable != null){
                upCallable();
            }
          }
          if ((touchEndY == touchStartY) & (touchEndX == touchStartX)) {
            //you tapped the screen
          } 
      }
}