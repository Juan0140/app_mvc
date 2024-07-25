let paso = 1;
const pasoInicial = 1
const pasoFinal = 3

const appointment = {
    id: '',
    name: '',
    date: '',
    hour: '',
    services: []
}

document.addEventListener('DOMContentLoaded', () => {
    iniciarApp();
    showSection();
    buttonsPagination();
    nextPage();
    backPage();
    consultAPI();
    nameClient();
    idClient();
    selectDate();
    selectHour();
    showResume();
});

function iniciarApp() {
    tabs();
}


function showSection() {
    //?Seleccionar clase a ocultar
    const sectionBack = document.querySelector('.show');
    if (sectionBack) {
        sectionBack.classList.remove('show')
    }


    //? Seleccionar la seccion con el paso
    const section = document.querySelector(`#step-${paso}`)
    section.classList.add('show');

    //?Quita actual al tab anterior
    const tabBack = document.querySelector('.actual');
    if (tabBack) {
        tabBack.classList.remove('actual');
    }

    //?Resalta el tab actual
    const tab = document.querySelector(`[data-step='${paso}']`);
    tab.classList.add('actual');

}

function tabs() {
    const botones = document.querySelectorAll('.tabs button');
    botones.forEach(boton => {
        boton.addEventListener('click', e => {
            paso = parseInt(e.target.dataset.step);
            showSection();
            buttonsPagination();
        })
    })
}

function buttonsPagination() {
    const nextPage = document.querySelector('#next');
    const backPage = document.querySelector('#back');

    if (paso === 1) {
        backPage.classList.add('hide');
        nextPage.classList.remove('hide')
    } else if (paso === 3) {
        backPage.classList.remove('hide')
        nextPage.classList.add('hide')
        showResume();
    } else {
        backPage.classList.remove('hide')
        nextPage.classList.remove('hide')
    }

    showSection();
}

function nextPage() {
    const nextPage = document.querySelector('#next');
    nextPage.addEventListener('click', () => {
        if (paso >= pasoFinal) return;
        paso++
        buttonsPagination();
    })
}

function backPage() {
    const backPage = document.querySelector('#back');
    backPage.addEventListener('click', () => {
        if (paso <= pasoInicial) return;
        paso--
        buttonsPagination();
    })
}


//*Funcion asincorna porque no sabemos cuanto tiempo tardara en traernos los datos
async function consultAPI() {
    try {
        const url = "/api/services"; //?endpoint de la API
        const result = await fetch(url);  //*Await detiene la ejecucion de codigo hasta que se descargue todo
        const services = await result.json();
        showServices(services)


    } catch (error) {
        console.log(error);
    }
}

function showServices(services) {
    services.forEach(service => {
        const { id, name, price } = service

        const nameService = document.createElement('P')
        nameService.classList.add('service-name')
        nameService.textContent = name

        const priceService = document.createElement('P')
        priceService.classList.add('service-price')
        priceService.textContent = `$${price}`

        const serviceDiv = document.createElement('DIV')
        serviceDiv.classList.add('service')
        serviceDiv.dataset.idService = id

        //*Esto es un callback para que podamos llamar al servicio que se presione y no llamar todos los servicios de jalon
        serviceDiv.onclick = function () {
            selectService(service)
        }


        serviceDiv.appendChild(nameService);
        serviceDiv.appendChild(priceService);

        document.querySelector('#services').appendChild(serviceDiv);
    })
}

function selectService(service) {
    const { id } = service
    const { services } = appointment;
    const serviceDiv = document.querySelector(`[data-id-service="${id}"]`)

    //? Comprobar si el servicio ya esta en memoria
    if (services.some(added => added.id === id)) {
        appointment.services = services.filter(added => added.id !== id)
        serviceDiv.classList.remove('selected')
    } else {
        serviceDiv.classList.add('selected')
        appointment.services = [...services, service]
    }
}

function idClient() {
    const id = document.querySelector('#id').value;
    appointment.id = id
}

function nameClient() {
    const name = document.querySelector('#name').value;
    appointment.name = name
}

function selectDate() {
    const actualDat = new Date() + 1;

    const inputDate = document.querySelector('#date');
    inputDate.addEventListener('blur', e => {
        const selectedDate = new Date(e.target.value);
        const day = selectedDate.getUTCDay();


        console.log('Fecha actual:', actualDat);
        console.log('Fecha seleccionada:', selectedDate);

        if ([6, 0].includes(day)) {
            appointment.date = '';
            e.target.value = '';
            showAlert('No abrimos fines de semana', 'error', '.form');
        } else if (selectedDate < actualDat) {
            appointment.date = '';
            e.target.value = '';
            showAlert('No se pueden elegir fechas anteriores', 'error', '.form');
        } else {
            appointment.date = e.target.value;

        }
    });
}

function showAlert(message, type, element, visible = true) {

    const alerPrev = document.querySelector('.alert')
    if (alerPrev) {
        alerPrev.remove()
    };
    console.log("si")
    const alert = document.createElement("DIV")
    alert.textContent = message
    alert.classList.add('alert')
    alert.classList.add(type)

    const reference = document.querySelector(element)
    reference.appendChild(alert);
    if (visible) {
        setTimeout(() => {
            alert.remove();

        }, 3000)
    }
}

function selectHour() {
    const inputHour = document.querySelector('#hour')
    inputHour.addEventListener('blur', e => {
        const hourApp = e.target.value
        const hour = hourApp.split(":")[0];
        if (hour < 10 || hour > 18) {
            console.log(hour)
            showAlert("Horas no validas", 'error', '.form')
            e.target.value = '';
        } else {
            appointment.hour = e.target.value

        }
    })
}

function showResume() {
    const resume = document.querySelector('.content-resume');
    //?Limpiar el contenido del resumen
    while (resume.firstChild) {
        resume.removeChild(resume.firstChild);
    }

    if (Object.values(appointment).includes('') || appointment.services.length === 0) {
        showAlert("Hacen falta Datos o Servcios", 'error', '.content-resume', false)
        return;
    }

    const { name, date, hour, services } = appointment;
    const nameClient = document.createElement('P')
    nameClient.innerHTML = `<span>Nombre: </span>${name}`

    const dateObj = new Date(date);
    const month = dateObj.getMonth();
    const day = dateObj.getDate() + 2;
    const year = dateObj.getFullYear();

    const dateUTC = new Date(Date.UTC(year, month, day))

    const options = {
        weekday: 'long',
        year: 'numeric',
        month: 'long',
        day: 'numeric'
    }
    const dateFormated = dateUTC.toLocaleDateString('es-MX', options);

    const dateApon = document.createElement('P')
    dateApon.innerHTML = `<span>Fecha: </span>${dateFormated}`

    const hourApon = document.createElement('P')
    hourApon.innerHTML = `<span>Hora: </span>${hour}`


    //?Heading para servicios
    const headingService = document.createElement('H3')
    headingService.textContent = "SERVICIOS"
    resume.appendChild(headingService)

    services.forEach(service => {
        const { id, name, price } = service
        const contentService = document.createElement('DIV')
        contentService.classList.add('content-service')
        const textService = document.createElement('P');
        textService.textContent = name

        const priceService = document.createElement('P');
        priceService.innerHTML = `<span>Precio: $</span>${price}`

        contentService.appendChild(textService)
        contentService.appendChild(priceService)

        resume.appendChild(contentService)
    })
    const headingApon = document.createElement('H3')
    headingApon.textContent = "Informacion Cita"
    resume.appendChild(headingApon)

    //?Boton para crear una cita
    const buttonReserv = document.createElement('BUTTON')
    buttonReserv.classList.add('button')
    buttonReserv.textContent = "Reservar Cita"
    buttonReserv.onclick = resevAppon;


    resume.appendChild(nameClient);
    resume.appendChild(dateApon);
    resume.appendChild(hourApon);
    resume.appendChild(buttonReserv);
}

async function resevAppon() {
    const { id, date, hour, services } = appointment
    console.log(services)
    const idServices = services.map(service => service.id)
    const data = new FormData();
    data.append('date', date)
    data.append('hour', hour)
    data.append('userId', id)
    data.append('services', idServices)

    // console.log([...data])
    // return;

    //? Peticion a la API
    try {
        const url = '/api/appointment';
        const response = await fetch(url, {
            method: 'POST',
            body: data
        })

        result = await response.json();
        paso = result.resultado
        console.log(result)
        console.log(paso)

        if (result.resultado) {
            Swal.fire({
                icon: 'success',
                title: 'Cita creada',
                text: 'Tu cita ha sido creada con exito',
                button: 'Ok'
            }).then(() => {
                window.location.reload();
            })
        }
    } catch (error) {
        Swal.fire({
            icon: 'error',
            tittle: 'Error',
            text: 'Hubo un error al intentar crear la cita',
            button: 'Ok'
        })
    }

}
