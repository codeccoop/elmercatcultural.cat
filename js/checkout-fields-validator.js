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

//VALIDATE DNI/NIF 
var inputID= document.getElementById('billing_DNI');

var submitButton = document.getElementById('place_order');
submitButton.setAttribute('disabled', true);
inputID.addEventListener('input', (ev)=>{
    var DNI = ValidateSpanishID(ev.target.value);
    if(DNI.valid === false){
        inputID.classList.add('wrong');
        submitButton.setAttribute('disabled', true);
    }
    else{
        inputID.classList.remove('wrong');
        submitButton.removeAttribute('disabled');
    }
    

});

//VALIDATE birthday 
var dateFormat = /^\d{2}\/[0-1]{1}[1-9]{1}\/\d{4}$/;
var inputBirthday = document.getElementById('billing_birthday');
inputBirthday.addEventListener('input', (ev)=> {
    if (!ev.target.value.match(dateFormat)) {
        inputBirthday.classList.add('wrong');
        submitButton.setAttribute('disabled', true);
    } else {
        inputBirthday.classList.remove('wrong');
        submitButton.removeAttribute('disabled');
    }
})


