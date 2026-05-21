function validateRegister(){
    let password = document.getElementById("password").value;
    let fullname = document.getElementById("fullname").value;
    let phone = document.getElementById("phone").value;

    let fioRegex = /^[А-Яа-яЁё\s]+$/;
    let phoneRegex = /^\+7\(\d{3}\)-\d{3}-\d{2}-\d{2}$/;

    if (password.lenght <6){
        alert("миннимум 6 символов");
        return false;
    }
    if(!fioRegex.test(fullname)){
        alert("в ФИО только кириллица");
        return false;
    }
    if(!phoneRegex.test(phone)){
        alert ("Телефон: +7(XXX)-XXX-XX-XX");
        return false;
    }

    return true;

}