// ==============================
// EVENT TICKET BOOKING SYSTEM
// MAIN JAVASCRIPT FILE
// ==============================



// ==============================
// DARK MODE SYSTEM
// ==============================

const darkModeBtn =
    document.getElementById('darkModeToggle');

if(darkModeBtn){

    darkModeBtn.addEventListener('click', () => {

        // TOGGLE DARK MODE

        document.body.classList.toggle('dark-mode');

        // SAVE THEME

        if(document.body.classList.contains('dark-mode')){

            localStorage.setItem('theme', 'dark');

        }else{

            localStorage.setItem('theme', 'light');

        }

    });

}



// ==============================
// LOAD SAVED THEME
// ==============================

window.addEventListener('DOMContentLoaded', () => {

    const savedTheme =
        localStorage.getItem('theme');

    if(savedTheme === 'dark'){

        document.body.classList.add('dark-mode');

    }

});



// ==============================
// TOAST NOTIFICATION SYSTEM
// ==============================

function showToast(message, type = 'dark'){

    const toastEl =
        document.getElementById('liveToast');

    if(!toastEl){

        return;

    }

    const toastBody =
        toastEl.querySelector('.toast-body');

    // SET MESSAGE

    toastBody.innerText = message;

    // CHANGE COLOR

    toastEl.className =
        `toast align-items-center text-bg-${type} border-0`;

    // SHOW TOAST

    const toast =
        new bootstrap.Toast(toastEl);

    toast.show();

}



// ==============================
// SMOOTH SCROLL FOR LINKS
// ==============================

document.querySelectorAll('a[href^="#"]').forEach(link => {

    link.addEventListener('click', function(e){

        const target =
            document.querySelector(
                this.getAttribute('href')
            );

        if(target){

            e.preventDefault();

            target.scrollIntoView({
                behavior: 'smooth'
            });

        }

    });

});



// ==============================
// BUTTON LOADING EFFECT
// ==============================

document.querySelectorAll('.btn').forEach(button => {

    button.addEventListener('click', () => {

        // SKIP IF ALREADY DISABLED

        if(button.disabled){

            return;

        }

        // OPTIONAL LOADING EFFECT

        if(button.classList.contains('loading-btn')){

            const originalText =
                button.innerHTML;

            button.innerHTML =
                'Processing...';

            button.disabled = true;

            // RESET AFTER 3 SEC

            setTimeout(() => {

                button.innerHTML =
                    originalText;

                button.disabled = false;

            }, 3000);

        }

    });

});



// ==============================
// AUTO CLOSE ALERTS
// ==============================

setTimeout(() => {

    document.querySelectorAll('.alert').forEach(alert => {

        alert.style.transition =
            '0.5s';

        alert.style.opacity =
            '0';

        setTimeout(() => {

            alert.remove();

        }, 500);

    });

}, 4000);



// ==============================
// MOBILE NAVBAR AUTO CLOSE
// ==============================

document.querySelectorAll('.navbar-nav .nav-link')
.forEach(link => {

    link.addEventListener('click', () => {

        const navbar =
            document.querySelector('.navbar-collapse');

        if(navbar &&
           navbar.classList.contains('show')){

            new bootstrap.Collapse(navbar).hide();

        }

    });

});