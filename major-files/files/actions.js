function validateForm(form) {

    var valid = true;

    if(!form.fname.value.length || !form.lname.value.length || !form.email.value.length
        || !form.password.value.length || !form.address.value.length || !form.suburb.value.length
        || !form.state.value.length || !form.postcode.value.length || !form.phone.value.length
        || !form.admin.value.length){       
        valid = false;
        document.getElementById('allField').style.display = 'inline-block';
    }else {
        document.getElementById('allField').style.display = "none";    //hide the error message
        form.title.style.border = "1px solid #ccc";                        //set the border back to normal
             
    }

        var firstName = document.getElementById('fname').value;
        var fnameRGEX = /^[A-Z][a-z]$/;
        var fnameResult = fnameRGEX.test(firstName);
    if(!fnameResult){       
        valid = false;
        document.getElementById('fname-error').style.display = 'inline-block';
        }else {
        document.getElementById('fname-error').style.display = "none"; //hide the error message
        form.fname.style.border = "1px solid #ccc";                    //set the border back to normal                                               
        }

        var lastName = document.getElementById('lname').value;
        var lnameRGEX = /^[A-Z][a-z]$/;
        var lnameResult = lnameRGEX.test(lastName);  
    if(!lnameResult){
        valid = false;
        document.getElementById('lname-error').style.display = 'inline-block';
        }else {
        document.getElementById('lname-error').style.display = "none";
        form.lname.style.border = "1px solid #ccc";             
        }

        var email = document.getElementById('email').value;
        var emailRGEX = /^\w+@[a-zA-Z_]+?\.[a-zA-Z]{2,3}$/;
        var emailResult = emailRGEX.test(email);
        if(!emailResult){
            valid = false;
            document.getElementById('email-error').style.display = 'inline-block';
        }
        else{
            document.getElementById('email-error').style.display = "none";
            form.email.style.border = "1px solid #ccc";
        }

    
        var postcode = document.getElementById('postcode').value;
        var postcodeRGEX = /^\d{4}$/;
        var postcodeResult = postcodeRGEX.test(postcode);
        if(!postcodeResult){
            valid = false;
            document.getElementById('postcode-error').style.display = 'inline-block';
        }
        else{
            document.getElementById('postcode-error').style.display = "none";
            form.postcode.style.border = "1px solid #ccc";
        }

        var state = document.getElementById('state').value;
        var stateRGEX = /^[A-Z]{2,3}$/;
        var stateResult = stateRGEX.test(state);
        if(!stateResult){
            valid = false;
            document.getElementById('state-error').style.display = 'inline-block';
        }
        else{
            document.getElementById('state-error').style.display = "none";
            form.state.style.border = "1px solid #ccc";
        }

        var password = document.getElementById('password').value;
        var passwordRGEX = /^(?=.*\d).{8,}$/;
        var passwordResult = passwordRGEX.test(password);
        if(!passwordResult){
            valid = false;
            document.getElementById('password-error').style.display = 'inline-block';
        }
        else{
            document.getElementById('password-error').style.display = "none";
            form.password.style.border = "1px solid #ccc";
        }
    return valid;
}

function validateFormProfile(form){
    var valid = true;

    var email = document.getElementById('email').value;
        var emailRGEX = /^\w+@[a-zA-Z_]+?\.[a-zA-Z]{2,3}$/;
        var emailResult = emailRGEX.test(email);
        if(!emailResult){
            valid = false;
            document.getElementById('email-error').style.display = 'inline-block';
        }
        else{
            document.getElementById('email-error').style.display = "none";
            form.email.style.border = "1px solid #ccc";
        }

    
        if(!form.fname.value.length || !form.lname.value.length || !form.email.value.length
            || !form.password.value.length || !form.address.value.length || !form.suburb.value.length
            || !form.state.value.length || !form.postcode.value.length || !form.phone.value.length){       
            valid = false;
            document.getElementById('allField').style.display = 'inline-block';
        }else {
            document.getElementById('allField').style.display = "none";    //hide the error message
            form.title.style.border = "1px solid #ccc";                        //set the border back to normal
                 
        }

        var postcode = document.getElementById('postcode').value;
        var postcodeRGEX = /^\d{4}$/;
        var postcodeResult = postcodeRGEX.test(postcode);
        if(!postcodeResult){
            valid = false;
            document.getElementById('postcode-error').style.display = 'inline-block';
        }
        else{
            document.getElementById('postcode-error').style.display = "none";
            form.postcode.style.border = "1px solid #ccc";
        }

        var state = document.getElementById('state').value;
        var stateRGEX = /^[A-Z]{2,3}$/;
        var stateResult = stateRGEX.test(state);
        if(!stateResult){
            valid = false;
            document.getElementById('state-error').style.display = 'inline-block';
        }
        else{
            document.getElementById('state-error').style.display = "none";
            form.state.style.border = "1px solid #ccc";
        }
    return valid;
}

function validateFormBooking(form){
    valid = true;

    if(!form.cardNumber.value.length || !form.cardName.value.length || !form.cardExpiry.value.length){       
        valid = false;
        document.getElementById('allField').style.display = 'inline-block';
    }else {
        document.getElementById('allField').style.display = "none";    //hide the error message
        form.title.style.border = "1px solid #ccc";                        //set the border back to normal
             
    }

    return valid;
}