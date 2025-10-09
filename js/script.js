const outlets = document.querySelectorAll('.info-lokasi');
const nextButton = document.getElementById('nextOutlet');

let currentIndex = 0;

function showOutlet(index) { 
    outlets.forEach((el, i) => {
        el.classList.remove('active');
        if (i === index) {
            el.classList.add('active');
        }
    });
}

nextButton.addEventListener('click', () => {
    currentIndex = (currentIndex + 1) % outlets.length;
    showOutlet(currentIndex);
});

showOutlet(currentIndex);