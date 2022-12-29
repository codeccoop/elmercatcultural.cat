const buttonSi = document.getElementById( 'billing_neighbour_1' );
const buttonNo = document.getElementById( 'billing_neighbour_2' );

buttonSi.addEventListener( 'click', function() {
	buttonSi.labels[ 1 ].classList.add( 'clicked' );
	buttonNo.labels[ 0 ].classList.remove( 'clicked' );
} );
buttonNo.addEventListener( 'click', function() {
	buttonNo.labels[ 0 ].classList.add( 'clicked' );
	buttonSi.labels[ 1 ].classList.remove( 'clicked' );
} );

//VALIDATE DNI/NIF
const submitButton = document.getElementById( 'place_order' );
const inputID = document.getElementById( 'billing_DNI' );
const inputBirthday = document.getElementById( 'billing_birthday' );

validateID( inputID.value );
validateDate( inputBirthday.value );

function validateID( value ) {
    const isNull = value == null || value == "";
	const isValid = ValidateSpanishID( value ).valid;
	if ( ! isValid ) {
		if ( ! isNull ) inputID.classList.add( 'wrong' );
		submitButton.setAttribute( 'disabled', true );
	} else {
		inputID.classList.remove( 'wrong' );
		submitButton.removeAttribute( 'disabled' );
	}
}

function validateDate( value ) {
    const isNull = value == null || value == "";
	const dateFormat = /^\d{2}\/[0-1]{1}[1-9]{1}\/\d{4}$/;
	if ( ! dateFormat.test( value ) ) {
		if ( ! isNull ) inputBirthday.classList.add( 'wrong' );
		submitButton.setAttribute( 'disabled', true );
	} else {
		inputBirthday.classList.remove( 'wrong' );
		submitButton.removeAttribute( 'disabled' );
	}
}

inputID.addEventListener( 'input', ( ev ) => validateID( ev.target.value ) );
inputBirthday.addEventListener( 'input', ( ev ) => validateDate( ev.target.value ) );
