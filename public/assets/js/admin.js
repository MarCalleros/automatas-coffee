import { createNotification } from './notification.js';

(function() {
    const userStatusForms = document.querySelectorAll('.admin-user-status-form--status');
    const userConfirmedForms = document.querySelectorAll('.admin-user-status-form--confirmed');
    const messageStatusForms = document.querySelectorAll('.admin-message-status-form--status');
    const messageReadForms = document.querySelectorAll('.admin-message-status-form--read');
    const deliveryStatusForms = document.querySelectorAll('.admin-delivery-status-form');
    const deliverymanStatusForms = document.querySelectorAll('.admin-deliveryman-status-form');
    const adminForm = document.querySelector('.admin-form');
    const adminResetButton = document.querySelector('#admin-reset-button');

    const eyeContainerPasswordLogin = document.querySelector('#login-eye-container-password');
    const eyeIconPasswordLogin = document.querySelector('#login-eye-password');
    const slashIconPasswordLogin = document.querySelector('#login-slash-password');

    const btnReporte = document.querySelector('#btn-reporte');
    const btnPdf = document.querySelector('#btn-pdf');

    if (eyeContainerPasswordLogin) {
        eyeContainerPasswordLogin.addEventListener('click', function() {
            const passwordInput = document.querySelector('#password');

            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                eyeIconPasswordLogin.style.display = 'none';
                slashIconPasswordLogin.style.display = 'block';
            } else {
                passwordInput.type = 'password';
                eyeIconPasswordLogin.style.display = 'block';
                slashIconPasswordLogin.style.display = 'none';
            }
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

    if (userConfirmedForms) {
        userConfirmedForms.forEach(form => {
            const button = form.querySelector('button')
    
            button.addEventListener('click', async () => {
                const id = form.dataset.id;
                let confirmed = form.dataset.confirmed === "1" ? "0" : "1";
    
                const formData = new FormData();
                formData.append("id", id);
                formData.append("confirmed", confirmed);
    
                const response = await fetch("/admin/usuario", {
                    method: "POST",
                    body: formData
                });
    
                if (response.ok) {
                    form.dataset.confirmed = confirmed;
                    button.textContent = confirmed === "1" ? "Desconfirmar" : "Confirmar";
                    
                    const row = form.closest("tr");
                    const confirmedCell = row.querySelectorAll("td")[7];
                    const div = confirmedCell.querySelector("div");
                    
                    div.className = confirmed === "1"
                        ? "admin-table__data--active"
                        : "admin-table__data--inactive";
                    
                    div.textContent = confirmed === "1" ? "Confirmado" : "Sin Confirmar";
                    createNotification("success", "Estado del usuario cambiado correctamente");
                } else {
                    createNotification("error", "Error al cambiar el estado del usuario");
                }
            });
        });
    }

    if (messageStatusForms) {
        messageStatusForms.forEach(form => {
            const button = form.querySelector('button')

            button.addEventListener('click', async () => {
                const id = form.dataset.id;
                const estatus = form.dataset.estatus === "1" ? "0" : "1";

                const formData = new FormData();
                formData.append("id", id);
                formData.append("estatus", estatus);

                const response = await fetch("/admin/message", {
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
                    createNotification("success", "Estado del mensaje cambiado correctamente");
                } else {
                    createNotification("error", "Error al cambiar el estado del mensaje");
                }
            });
        });

        const textareas = document.querySelectorAll(".admin-form__area");

        textareas.forEach(textarea => {
            // Ajustar altura inicial
            textarea.style.height = 'auto';
            textarea.style.height = textarea.scrollHeight + 'px';

            // Si quieres que también se ajuste en tiempo real mientras escriben:
            textarea.addEventListener("input", () => {
                textarea.style.height = 'auto';
                textarea.style.height = textarea.scrollHeight + 'px';
            });
        });
    }

    if (messageReadForms) {
        messageReadForms.forEach(form => {
            const button = form.querySelector('button')

            button.addEventListener('click', async () => {
                const id = form.dataset.id;
                const leido = form.dataset.leido === "1" ? "0" : "1";

                const formData = new FormData();
                formData.append("id", id);
                formData.append("leido", leido);

                const response = await fetch("/admin/message", {
                    method: "POST",
                    body: formData
                });

                if (response.ok) {
                    form.dataset.leido = leido;
                    button.textContent = leido === "1" ? "Marcar como no leído" : "Marcar como leído";
                    
                    const row = form.closest("tr");
                    const leidoCell = row.querySelectorAll("td")[6];
                    const div = leidoCell.querySelector("div");
                    
                    div.className = leido === "1"
                        ? "admin-table__data--active"
                        : "admin-table__data--inactive";
                    
                    div.textContent = leido === "1" ? "Leído" : "No leído";
                    createNotification("success", "Estado del mensaje cambiado correctamente");
                } else {
                    createNotification("error", "Error al cambiar el estado del mensaje");
                }
            });
        });

        const textareas = document.querySelectorAll(".admin-form__area");

        textareas.forEach(textarea => {
            // Ajustar altura inicial
            textarea.style.height = 'auto';
            textarea.style.height = textarea.scrollHeight + 'px';

            // Si quieres que también se ajuste en tiempo real mientras escriben:
            textarea.addEventListener("input", () => {
                textarea.style.height = 'auto';
                textarea.style.height = textarea.scrollHeight + 'px';
            });
        });
    }

    if (deliveryStatusForms) {
        deliveryStatusForms.forEach(form => {
            const button = form.querySelector('button')

            button.addEventListener('click', async () => {
                const id = form.dataset.id;
                const estatus = form.dataset.estatus === "1" ? "0" : "1";

                const formData = new FormData();
                formData.append("id", id);
                formData.append("estatus", estatus);

                const response = await fetch("/admin/delivery", {
                    method: "POST",
                    body: formData
                });

                if (response.ok) {
                    form.dataset.estatus = estatus;
                    button.textContent = estatus === "1" ? "Cancelar Pedido" : "Reactivar Pedido";
                    
                    const row = form.closest("tr");
                    const estatusCell = row.querySelectorAll("td")[6];
                    const div = estatusCell.querySelector("div");
                    
                    div.className = estatus === "1"
                        ? "admin-table__data--active"
                        : "admin-table__data--inactive";
                    
                    div.textContent = estatus === "1" ? "Entregado" : "Pendiente";
                    createNotification("success", "Estado del pedido cambiado correctamente");
                } else {
                    createNotification("error", "Error al cambiar el estado del pedido");
                }
            });
        });

        const textareas = document.querySelectorAll(".admin-form__area");

        textareas.forEach(textarea => {
            // Ajustar altura inicial
            textarea.style.height = 'auto';
            textarea.style.height = textarea.scrollHeight + 'px';

            // Si quieres que también se ajuste en tiempo real mientras escriben:
            textarea.addEventListener("input", () => {
                textarea.style.height = 'auto';
                textarea.style.height = textarea.scrollHeight + 'px';
            });
        });
    }

    if (deliverymanStatusForms) {
        deliverymanStatusForms.forEach(form => {
            const button = form.querySelector('button')
    
            button.addEventListener('click', async () => {
                const id = form.dataset.id;
                const estatus = form.dataset.estatus === "1" ? "0" : "1";
    
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
                    const estatusCell = row.querySelectorAll("td")[10];
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

    if (adminForm) {
        adminForm.addEventListener('submit', async (event) => {
            event.preventDefault();
            
            // Verifica el ID del formulario para ejecutar la validación correspondiente
            if (adminForm.getAttribute('id') == 'admin-form') {
                if (!validateDeliverymanForm()) {
                    return;
                }
            } else if (adminForm.getAttribute('id') == 'admin-user-form') {
                if (!validateUserForm()) {
                    return;
                }
            } else if (adminForm.getAttribute('id') == 'admin-message-form') {
                if (!validateMessageForm()) {
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

    if (btnReporte) {
        btnReporte.addEventListener('click', async () => {
            let fechaInicio = document.querySelector('#reporte_inicio').value;
            let fechaFin = document.querySelector('#reporte_fin').value;
            console.log('Generando reporte...');
            console.log(`Fecha Inicio: ${fechaInicio}, Fecha Fin: ${fechaFin}`);

            if (!fechaInicio || !fechaFin) {
                createNotification('error', 'Por favor, selecciona ambas fechas para generar el reporte');
                return;
            }

            if (fechaInicio > fechaFin) {
                createNotification('error', 'La fecha de inicio no puede ser mayor que la fecha de fin');
                return;
            }

            fechaInicio += ' 00:00:00';
            fechaFin += ' 23:59:59';

            const response = await fetch(`/api/purchase/between?desde=${fechaInicio}&hasta=${fechaFin}`, {
                method: 'GET'
            });

            if (response.ok) {
                const data = await response.json();
                if (data.status === 'success') {
                    createNotification('success', 'Reporte generado correctamente');

                    const subtitle = document.querySelector('.admin__subtitle');
                    subtitle.textContent = `Reporte de entregas del ${fechaInicio.split(' ')[0]} al ${fechaFin.split(' ')[0]}`;
                    let total = 0;

                    const body = document.querySelector('.admin-table__body');
                    body.innerHTML = ''; // Limpiar la tabla antes de agregar los nuevos datos
                    data.deliveries.forEach(delivery => {
                        const row = document.createElement('tr');
                        row.classList.add('admin-table__row', 'admin-table__row--data');

                        row.innerHTML = `
                            <td class="admin-table__data">${delivery.identificador}</td>
                            <td class="admin-table__data">${delivery.usuario}</td>
                            <td class="admin-table__data">${delivery.repartidor}</td>
                            <td class="admin-table__data">${delivery.fecha}</td>
                            <td class="admin-table__data">${delivery.entregado}</td>
                            <td class="admin-table__data">${delivery.pago}</td>
                            <td class="admin-table__data">$${delivery.total}</td>
                            <td class="admin-table__data">${delivery.estatus}</td>
                        `;
                        body.appendChild(row);
                        total += parseFloat(delivery.total);
                    });

                    const price = document.querySelector('.admin__subtitle--price');
                    price.textContent = `Monto Total: $${total.toFixed(2)}`;
                } else {
                    createNotification('error', data.message || 'Error al generar el reporte');
                }
            } else {
                createNotification('error', 'Error al generar el reporte');
            }
        });
    }

    if (btnPdf) {
        btnPdf.addEventListener('click', () => {
            console.log('Generando PDF...');
            const table = document.querySelector('#pdf-table');
            const opciones = {
                margin:       0.5,
                filename:     'reporte.pdf',
                image:        { type: 'jpeg', quality: 0.98 },
                html2canvas:  { scale: 2 },
                jsPDF:        { unit: 'in', format: 'letter', orientation: 'landscape' }
            };

            html2pdf().set(opciones).from(table).save();
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
    const usuario = document.querySelector('#id_usuario').value;

    const errorNombre = document.querySelector('#error-nombre');
    const errorApellido1 = document.querySelector('#error-apellido1');
    const errorApellido2 = document.querySelector('#error-apellido2');
    const errorTelefono = document.querySelector('#error-telefono');
    const errorCurp = document.querySelector('#error-curp');
    const errorRfc = document.querySelector('#error-rfc');
    const errorNss = document.querySelector('#error-nss');
    const errorTipoSangre = document.querySelector('#error-tipo-sangre');
    const errorVigencia = document.querySelector('#error-vigencia');
    const errorUsuario = document.querySelector('#error-usuario');

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
    const mensajeUsuario = "Seleccione un usuario";

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

    if (!usuario) {
        errorUsuario.textContent = mensajeUsuario;
        errorUsuario.classList.add('admin-form__error--active');
        error = true;
    } else {
        errorUsuario.classList.remove('admin-form__error--active');
    }

    if (error) {
        return false;
    }

    return true;
}
const botonnfc = document.querySelector('#admin-nfc_id-button');
if (botonnfc) {
    const socket = io('https://scritp-nfc.onrender.com', {
        transports: ['websocket']
    });

    socket.on('connect', () => {
        console.log('Socket.IO conectado');
    });

    botonnfc.addEventListener('click', async (event) => {
        botonnfc.textContent = 'Esperando tarjeta NFC...';
        const nfcId = document.querySelector('#nfc_id').value;

        if (socket.connected) {
            console.log('Enviando NFC ID:', nfcId);
            socket.emit('nfc_id',nfcId);
        } else {
            console.error('Socket.IO no está conectado');
        }

        socket.on('escritura_terminada', (data) => { 
            console.log('Escritura terminada:');
            createNotification('success', 'NFC ID guardado correctamente');
            botonnfc.textContent = 'NFC Guardado';
        });
    });
    
}

function validateUserForm() {
    // Mirar por el enlace y ver si contiene /edit
    const isEdit = window.location.href.includes('/edit');
    const isemployee = window.location.href.includes('/empleado');

    let error = false;

    const nombre = document.querySelector('#nombre').value;
    const edad = document.querySelector('#edad').value;
    const email = document.querySelector('#email').value;
    const usuario = document.querySelector('#usuario').value;
    const password = document.querySelector('#password').value;
    if (!isemployee) {
        const tipoUsuario = document.querySelector('#id_tipo_usuario').value;
    }
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

    if (!isEdit) {
        if (!password || !regexPassword.test(password)) {
            errorPassword.textContent = password ? mensajePassword : mensajeVacio;
            errorPassword.classList.add('admin-form__error--active');
            error = true;
        } else {
            errorPassword.classList.remove('admin-form__error--active');
        }
    } else {
        if (password) {
            if (!regexPassword.test(password)) {
                errorPassword.textContent = mensajePassword;
                errorPassword.classList.add('admin-form__error--active');
                error = true;
            } else {
                errorPassword.classList.remove('admin-form__error--active');
            }
        }
    }
    if (!isemployee) {
        if (!tipoUsuario) {
        errorTipoUsuario.textContent = mensajeTipoUsuario;
        errorTipoUsuario.classList.add('admin-form__error--active');
        error = true;
        } else {
            errorTipoUsuario.classList.remove('admin-form__error--active');
        }  
    }
    

    if (error) {
        return false;
    }

    return true;
}

function validateMessageForm() {
    let error = false;

    const respuesta = document.querySelector('#respuesta').value;

    const errorRespuesta = document.querySelector('#error-respuesta');

    const mensajeVacio = "Este campo es obligatorio";

    if (!respuesta) {
        errorRespuesta.textContent = mensajeVacio;
        errorRespuesta.classList.add('admin-form__error--active');
        error = true;
    } else {
        errorRespuesta.classList.remove('admin-form__error--active');
    }

    if (error) {
        return false;
    }

    return true;
}