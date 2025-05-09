const form= document.querySelector(#form)
const name= document.querySelector(#name)
const number= document.querySelector(#number)
const email= document.querySelector(#email)
const int= document.querySelector(#int)

form.addEventListener('Submit'(e)= > {
    e.preventDefault();
    validateInputs();
})

function validateInputs(){
    const nameval=name.value.trim();
    const numberval=number.value.trim();
    const emailval=email.value.trim();
    const intval=int.value.trim();}

    if(nameVal===''){
        setError(name,'Name is required')}
    else{
        setSuccess(name)}

    if(numberval===''){
        setError(number,'Number is required')}
    else if(numberval.length>11){
        setError(number,'Number must be in 10 digits')}
    else{
        setSuccess(number)
    }
    
    if(emailVal===''){
        setError(email,'Email is required')}
    else if(!ValidateEmail(validateEmail)){
        setError(email,'Please ener a valid email')}
    else{
        setSuccess(email)
    }

    if(numberval===''){
        setError(number,'Number is required')}
    else if(!validatenumber(numberVal)){
        setError(number,'Number must be in 10 digits')}
    else{
        setSuccess(number)
    }

    if(intVal===''){
        setError(int,'Message is required')}
    else{
        setSuccess(int)
    }

    function validatenumber(number){
        if([/^[0-9] {10} $/].test(form.number.value))
        {return(true)
        }
        else{
        alert(....)
        return(false)}
        }



function setError(element,message){
    const input=element.parentElement;
    const errorElement=input.querySelector('.error')
    errorElement.innerText=message;
    input.classList.Add('error')
    input.classList.remove('success')
}

function setSuccess(element){
    const input=element.parentElement;
    const errorElement=input.querySelector('.error')
    errorElement.innerText='';
    input.classList.Add('success')
    input.classList.remove('error')
}

function validateEmail(mail) 
{
 if (/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/.test(myForm.emailAddr.value))
  {
    return (true)
  }
    alert("You have entered an invalid email address!")
    return (false)
}

function deleteDonor(id) {
    if (confirm("Are you sure you want to delete this donor?")) {
        fetch('delete_donor.php?id=' + id, {
            method: 'GET'
        })
        .then(response => response.text())
        .then(data => {
            // Check if deletion was successful
            if (data.includes('success')) {
                alert("Donor deleted successfully!");
                // Remove the donor's row from the table without refreshing
                document.getElementById('row_' + id).remove();
            } else {
                alert("Error deleting donor!");
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert("Something went wrong!");
        });
    }
}




