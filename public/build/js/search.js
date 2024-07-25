document.addEventListener('DOMContentLoaded', ()=>{
    iniciarApp();
})


function iniciarApp(){

    searchDate();
}

function searchDate(){
    const dateInput = document.querySelector('#date');
    dateInput.addEventListener('input', e=>{
        const dateSelected = e.target.value;
        console.log(dateSelected);
        window.location = `?date=${dateSelected}`;
    })
}