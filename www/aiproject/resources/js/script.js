function formType(e){
    let employeeForm = document.getElementById('employee-form');
    let buildingForm = document.getElementById('building-form');
    if (e === "room"){
        employeeForm.style.display = "none";
        buildingForm.style.display = "block";
    }
    else if (e === "employee"){
        employeeForm.style.display = "block";
        buildingForm.style.display = "none";
    }else{
        throw new Error('Parameter is not valid!');
    }
}