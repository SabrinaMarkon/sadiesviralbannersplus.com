// Countdown timer for Viral Banner ad views.
function countdown(counter, redirecturl) {

    function countDown() {
        if (counter > 0) {
            document.getElementById("plzwait").innerHTML = '<b>'+counter+'<\/b> seconds';
            counter--;
        } else {
            clearInterval(timer);
            window.location = redirecturl;
        }
    }

    let timer = setInterval(countDown, 1000);

    // $(document).ready(function (){
    //     var count = 0;
    //     function myCount() {
    //       if (count == 0) {
    //         count += 1;  
    //       } else if (count > 10) {
    //         count = 0;
    //       }
    //       $('.count').text(count);
    //     }
    //     setInterval(myCount,200);
    //   });


	// if ((0 <= 100) || (0 > 0)) {
	// 	counter--;
	// 	if(counter > 0) {
	// 		document.getElementById("plzwait").innerHTML = '<b>'+counter+'<\/b> seconds';
	// 		setTimeout('countdown()',1000);
	// 	}
	// 	if(counter < 1)
	// 	{
	// 	window.location = redirecturl;
	// 	}
	// }
}