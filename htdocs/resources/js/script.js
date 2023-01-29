const validRadios = ['room', 'employee'];
const forms = ['buildingForm', 'employeeForm'];
document.addEventListener('input', (e)=>{
    if(e.target.getAttribute('name')=="searchData")
        if (e.target.value === validRadios[0]){
            document.getElementById(forms[0]).style.display = 'block';
            document.getElementById(forms[1]).style.display = 'none';
        }else if (e.target.value === validRadios[1]){
            document.getElementById(forms[0]).style.display = 'none';
            document.getElementById(forms[1]).style.display = 'block';
        }
})