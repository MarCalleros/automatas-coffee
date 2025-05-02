import { createNotification } from './notification.js';

(function() {
    const deliverymanStatusForms = document.querySelectorAll('.admin-deliveryman-status-form');
    const userStatusForms = document.querySelectorAll('.admin-user-status-form');
    const adminForm = document.querySelector('.admin-form');
    const adminResetButton = document.querySelector('#admin-reset-button');

    if (deliverymanStatusForms) {
        deliverymanStatusForms.forEach(form => {
            const button = form.querySelector('button')
    
            button.addEventListener('click', async () => {
                const id = form.dataset.id;
                let estatus = form.dataset.estatus === "1" ? "0" : "1";
    
                const formData = new FormData();
                formData.append("id", id);
                formData.append("estatus", estatus);
    
                const response = await fetch("/admin/deliveryman", {
                    method: "POST",
                    body: formData
                });
    
                if (response.ok) {
                    form.dataset.estatus = estatus;
                    button.textContent = estatus === "1" ? "Dar de Baja" : "Dar de Alta";
                    
                    const row = form.closest("tr");
                    const estatusCell = row.querySelectorAll("td")[9];
                    const div = estatusCell.querySelector("div");
                    
                    div.className = estatus === "1"
                        ? "admin-table__data--active"
                        : "admin-table__data--inactive";
                    
                    div.textContent = estatus === "1" ? "Alta" : "Baja";
                    createNotification("success", "Estado del repartidor cambiado correctamente");
                } else {
                    createNotification("error", "Error al cambiar el estado del repartidor");
                }
            });
        });
    }

    if (userStatusForms) {
        userStatusForms.forEach(form => {
            const button = form.querySelector('button')
    
            button.addEventListener('click', async () => {
                const id = form.dataset.id;
                let estatus = form.dataset.estatus === "1" ? "0" : "1";
    
                const formData = new FormData();
                formData.append("id", id);
                formData.append("estatus", estatus);
    
                const response = await fetch("/admin/usuario", {
                    method: "POST",
                    body: formData
                });
    
                if (response.ok) {
                    form.dataset.estatus = estatus;
                    button.textContent = estatus === "1" ? "Dar de Baja" : "Dar de Alta";
                    
                    const row = form.closest("tr");
                    const estatusCell = row.querySelectorAll("td")[6];
                    const div = estatusCell.querySelector("div");
                    
                    div.className = estatus === "1"
                        ? "admin-table__data--active"
                        : "admin-table__data--inactive";
                    
                    div.textContent = estatus === "1" ? "Alta" : "Baja";
                    createNotification("success", "Estado del usuario cambiado correctamente");
                } else {
                    createNotification("error", "Error al cambiar el estado del usuario");
                }
            });
        });
    }

    if (adminForm) {
        adminForm.addEventListener('submit', async (event) => {
            event.preventDefault();

             // Verifica el ID del formulario para ejecutar la validación correspondiente
            if (adminForm.id === 'admin-form') {
                if (!validateDeliverymanForm()) {
                    return;
                }
            } else if (adminForm.id === 'admin-user-form') {
                if (!validateUserForm()) {
                    return;
                }
            }

            const adminSubmitButton = adminForm.querySelector('#admin-submit-button');
            adminSubmitButton.disabled = true;
            adminSubmitButton.textContent = 'Guardando...';

            const formData = new FormData(adminForm);
            const response = await fetch(adminForm.action, {
                method: adminForm.method,
                body: formData
            });

            const data = await response.json();

            if (data.success) {
                adminForm.reset();

                if (data.updatedData) {
                    Object.keys(data.updatedData).forEach(key => {
                        const input = adminForm.querySelector(`[name="${key}"]`);
                        if (input) input.value = data.updatedData[key];
                    });
                }

                createNotification("success", "Datos guardados correctamente");
            } else {
                createNotification("error", data.error || "Error al guardar los datos");
            }
            
            adminSubmitButton.disabled = false;
            adminSubmitButton.textContent = 'Guardar';
        });
    }

    if (adminResetButton) {
        adminResetButton.addEventListener('click', () => {
            const errorElements = document.querySelectorAll('.admin-form__error--active');
            errorElements.forEach(element => {
                element.classList.remove('admin-form__error--active');
            });
        });
    }
})();

function validateDeliverymanForm() {
    let error = false;

    const nombre = document.querySelector('#nombre').value;
    const apellido1 = document.querySelector('#apellido1').value;
    const apellido2 = document.querySelector('#apellido2').value;
    const telefono = document.querySelector('#telefono').value;
    const curp = document.querySelector('#curp').value;
    const rfc = document.querySelector('#rfc').value;
    const nss = document.querySelector('#nss').value;
    const tipoSangre = document.querySelector('#tipo_sangre').value;
    const vigencia = document.querySelector('#vigencia').value;

    const errorNombre = document.querySelector('#error-nombre');
    const errorApellido1 = document.querySelector('#error-apellido1');
    const errorApellido2 = document.querySelector('#error-apellido2');
    const errorTelefono = document.querySelector('#error-telefono');
    const errorCurp = document.querySelector('#error-curp');
    const errorRfc = document.querySelector('#error-rfc');
    const errorNss = document.querySelector('#error-nss');
    const errorTipoSangre = document.querySelector('#error-tipo-sangre');
    const errorVigencia = document.querySelector('#error-vigencia');

    const regexNombre = /^[A-Za-zÁÉÍÓÚÑáéíóúñ\s]{1,30}$/
    const regexApellido = /^[A-Za-zÁÉÍÓÚÑáéíóúñ\s]{1,20}$/
    const regexTelefono = /^\d{10}$/;
    const regexCurp = /^[A-Z]{4}\d{6}[HM][A-Z]{5}[A-Z\d]{2}$/i
    const regexRfc = /^[A-ZÑ&]{3,4}\d{6}[A-Z0-9]{3}$/i
    const regexNss = /^\d{11}$/;

    const mensajeVacio = "Este campo es obligatorio";
    const mensajeNombre= "El nombre solo puede contener letras y espacios";
    const mensajeTelefono = "El teléfono debe contener 10 dígitos";
    const mensajeCurp = "El CURP no es valido";
    const mensajeRfc = "El RFC no es valido";
    const mensajeNss = "El NSS no es valido";
    const mensajeTipoSangre = "Seleccione un tipo de sangre";
    const mensajeVigencia = "Seleccione una fecha valida";

    if (!nombre || !regexNombre.test(nombre)) {
        errorNombre.textContent = nombre ? mensajeNombre : mensajeVacio;
        errorNombre.classList.add('admin-form__error--active');
        error = true;
    } else {
        errorNombre.classList.remove('admin-form__error--active');
    }

    if (!apellido1 || !regexApellido.test(apellido1)) {
        errorApellido1.textContent = mensajeVacio;
        errorApellido1.classList.add('admin-form__error--active');
        error = true;
    } else {
        errorApellido1.classList.remove('admin-form__error--active');
    }

    if (!apellido2 || !regexApellido.test(apellido2)) {
        errorApellido2.textContent = mensajeVacio;
        errorApellido2.classList.add('admin-form__error--active');
        error = true;
    } else {
        errorApellido2.classList.remove('admin-form__error--active');
    }

    if (!telefono || !regexTelefono.test(telefono)) {
        errorTelefono.textContent = telefono ? mensajeTelefono : mensajeVacio;
        errorTelefono.classList.add('admin-form__error--active');
        error = true;
    } else {
        errorTelefono.classList.remove('admin-form__error--active');
    }

    if (!curp || !regexCurp.test(curp)) {
        errorCurp.textContent = curp ? mensajeCurp : mensajeVacio;
        errorCurp.classList.add('admin-form__error--active');
        error = true;
    } else {
        errorCurp.classList.remove('admin-form__error--active');
    }

    if (!rfc || !regexRfc.test(rfc)) {
        errorRfc.textContent = rfc ? mensajeRfc : mensajeVacio;
        errorRfc.classList.add('admin-form__error--active');
        error = true;
    } else {
        errorRfc.classList.remove('admin-form__error--active');
    }

    if (!nss || !regexNss.test(nss)) {
        errorNss.textContent = nss ? mensajeNss : mensajeVacio;
        errorNss.classList.add('admin-form__error--active');
        error = true;
    } else {
        errorNss.classList.remove('admin-form__error--active');
    }

    if (!tipoSangre) {
        errorTipoSangre.textContent = mensajeTipoSangre;
        errorTipoSangre.classList.add('admin-form__error--active');
        error = true;
    } else {
        errorTipoSangre.classList.remove('admin-form__error--active');
    }

    if (!vigencia) {
        errorVigencia.textContent = mensajeVigencia;
        errorVigencia.classList.add('admin-form__error--active');
        error = true;
    } else {
        errorVigencia.classList.remove('admin-form__error--active');
    }

    if (error) {
        return false;
    }

    return true;
}

function validateUserForm() {
    let error = false;

    const nombre = document.querySelector('#nombre').value;
    const edad = document.querySelector('#edad').value;
    const email = document.querySelector('#email').value;
    const usuario = document.querySelector('#usuario').value;
    const password = document.querySelector('#password').value;
    const tipoUsuario = document.querySelector('#id_tipo_usuario').value;

    const errorNombre = document.querySelector('#error-nombre');
    const errorEdad = document.querySelector('#error-edad');
    const errorEmail = document.querySelector('#error-email');
    const errorUsuario = document.querySelector('#error-usuario');
    const errorPassword = document.querySelector('#error-password');
    const errorTipoUsuario = document.querySelector('#error-tipo-usuario');

    const regexNombre = /^[A-Za-zÁáÉéÍíÓóÚúÑñ\s]+$/
    const regexEdad = /^[1-9][0-9]?$/
    const regexEmail = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/
    const regexUsuario = /^[a-zA-Z0-9]{5,}$/
    const regexPassword = /^(?=.*[A-Za-z])(?=.*\d)(?=.*[@$!%*?&_\-#])[A-Za-z\d@$!%*?&_\-#]{8,}$/

    const mensajeVacio = "Este campo es obligatorio";
    const mensajeNombre= "El nombre solo puede contener letras y espacios";
    const mensajeEdad = "La edad debe ser un número entre 1 y 99";
    const mensajeEmail = "El email no es valido";
    const mensajeUsuario = "El usuario debe contener al menos 5 caracteres alfanuméricos";
    const mensajePassword = "La contraseña debe contener al menos 8 caracteres, una letra, un número y un símbolo especial";
    const mensajeTipoUsuario = "Seleccione un tipo de usuario";

    if (!nombre || !regexNombre.test(nombre)) {
        errorNombre.textContent = nombre ? mensajeNombre : mensajeVacio;
        errorNombre.classList.add('admin-form__error--active');
        error = true;
    } else {
        errorNombre.classList.remove('admin-form__error--active');
    }

    if (!edad || !regexEdad.test(edad)) {
        errorEdad.textContent = edad ? mensajeEdad : mensajeVacio;
        errorEdad.classList.add('admin-form__error--active');
        error = true;
    }
    else {
        errorEdad.classList.remove('admin-form__error--active');
    }

    if (!email || !regexEmail.test(email)) {
        errorEmail.textContent = email ? mensajeEmail : mensajeVacio;
        errorEmail.classList.add('admin-form__error--active');
        error = true;
    } else {
        errorEmail.classList.remove('admin-form__error--active');
    }

    if (!usuario || !regexUsuario.test(usuario)) {
        errorUsuario.textContent = usuario ? mensajeUsuario : mensajeVacio;
        errorUsuario.classList.add('admin-form__error--active');
        error = true;
    } else {
        errorUsuario.classList.remove('admin-form__error--active');
    }

    if (!password || !regexPassword.test(password)) {
        errorPassword.textContent = password ? mensajePassword : mensajeVacio;
        errorPassword.classList.add('admin-form__error--active');
        error = true;
    } else {
        errorPassword.classList.remove('admin-form__error--active');
    }

    if (!tipoUsuario) {
        errorTipoUsuario.textContent = mensajeTipoUsuario;
        errorTipoUsuario.classList.add('admin-form__error--active');
        error = true;
    } else {
        errorTipoUsuario.classList.remove('admin-form__error--active');
    }

    if (error) {
        return false;
    }

    return true;
}