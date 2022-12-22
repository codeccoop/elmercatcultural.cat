const buttonSi = document.getElementById('billing_neighbour_1');
const buttonNo = document.getElementById('billing_neighbour_2');

buttonSi.addEventListener('click', function() {
    buttonSi.labels[1].classList.add('clicked');
    buttonNo.labels[0].classList.remove('clicked');
});
buttonNo.addEventListener('click', function() {
    buttonNo.labels[0].classList.add('clicked');
    buttonSi.labels[1].classList.remove('clicked');
});