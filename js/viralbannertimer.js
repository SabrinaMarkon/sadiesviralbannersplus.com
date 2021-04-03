// Countdown timer for Viral Banner ad views.
function countdown(counter, id) {

    let whichsadie = Math.floor(Math.random() * 3) + 1;

    async function countDown() {
        if (counter > 0) {
            document.getElementById("timerbar").innerHTML = '<img src="images/sadie-expression-' + whichsadie + '.png"><span class="sadietalknormal"><strong><span class="sadietalk-pink">' + counter + '</span>&nbsp;<span class="sadietalk-blue"> seconds</span></strong></span>';
            counter--;
        } else {
            clearInterval(timer);
            
            // Add this banner slot id to the visitor's session in php:
            // const result = await fetch();

            document.getElementById("timerbar").innerHTML = '<img src="images/sadie-expression-' + whichsadie + '.png"><span class="sadietalknormal"><strong><span class="sadietalk-blue">DONE!</span></strong></span>';
        }
    }

    let timer = setInterval(countDown, 1000);

}