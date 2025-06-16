export function createAlert(message, messageBold, textButtonContinue, textButtonCancel) {
    return new Promise((resolve) => {
        let scrollY = window.scrollY;

        document.body.style.position = 'fixed';
        document.body.style.top = `-${scrollY}px`;
        document.body.style.width = '100%';

        const alert = document.createElement('div');
        alert.classList.add('alert');
        alert.innerHTML = `
            <div class="background__shadow background__shadow--active background__blur background__blur--active" id="background-login"></div>

            <div class="alert-modal alert-modal--active">
                <button class="modal__close" id="profile-close">
                    <svg class="close-icon" width="31" height="31" viewBox="0 0 31 31" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M29.5762 0.547733C28.9254 -0.103151 27.87 -0.103151 27.2192 0.547733L15.0619 12.705L2.90463 0.547733C2.25376 -0.103151 1.19848 -0.103151 0.547611 0.547733C-0.103273 1.1986 -0.103273 2.25388 0.547611 2.90475L12.7049 15.062L0.547644 27.2192C-0.103239 27.8702 -0.103239 28.9254 0.547644 29.5764C1.19851 30.2272 2.25379 30.2272 2.90466 29.5764L15.0619 17.419L27.2192 29.5764C27.87 30.2272 28.9254 30.2272 29.5762 29.5764C30.227 28.9254 30.227 27.8702 29.5762 27.2194L17.4189 15.062L29.5762 2.90475C30.227 2.25388 30.227 1.1986 29.5762 0.547733Z" fill="black"/>
                    </svg>
                </button>

                <h2 class="alert-modal__title">Alerta</h2>

                <div class="alert-modal__content">
                    <div class="alert-modal__icon-container">
                        <svg class="alert-icon" width="75px" height="75px" viewBox="-0.5 0 25 25" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                            <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                            <g id="SVGRepo_iconCarrier"> 
                                <path d="M10.8809 16.15C10.8809 16.0021 10.9101 15.8556 10.967 15.7191C11.024 15.5825 11.1073 15.4586 11.2124 15.3545C11.3175 15.2504 11.4422 15.1681 11.5792 15.1124C11.7163 15.0567 11.8629 15.0287 12.0109 15.03C12.2291 15.034 12.4413 15.1021 12.621 15.226C12.8006 15.3499 12.9399 15.5241 13.0211 15.7266C13.1024 15.9292 13.122 16.1512 13.0778 16.3649C13.0335 16.5786 12.9272 16.7745 12.7722 16.9282C12.6172 17.0818 12.4204 17.1863 12.2063 17.2287C11.9922 17.2711 11.7703 17.2494 11.5685 17.1663C11.3666 17.0833 11.1938 16.9426 11.0715 16.7618C10.9492 16.5811 10.8829 16.3683 10.8809 16.15ZM11.2408 13.42L11.1008 8.20001C11.0875 8.07453 11.1008 7.94766 11.1398 7.82764C11.1787 7.70761 11.2424 7.5971 11.3268 7.5033C11.4112 7.40949 11.5144 7.33449 11.6296 7.28314C11.7449 7.2318 11.8697 7.20526 11.9958 7.20526C12.122 7.20526 12.2468 7.2318 12.3621 7.28314C12.4773 7.33449 12.5805 7.40949 12.6649 7.5033C12.7493 7.5971 12.813 7.70761 12.8519 7.82764C12.8909 7.94766 12.9042 8.07453 12.8909 8.20001L12.7609 13.42C12.7609 13.6215 12.6809 13.8149 12.5383 13.9574C12.3958 14.0999 12.2024 14.18 12.0009 14.18C11.7993 14.18 11.606 14.0999 11.4635 13.9574C11.321 13.8149 11.2408 13.6215 11.2408 13.42Z" fill="#ff5100"></path> 
                                <path d="M12 21.5C17.1086 21.5 21.25 17.3586 21.25 12.25C21.25 7.14137 17.1086 3 12 3C6.89137 3 2.75 7.14137 2.75 12.25C2.75 17.3586 6.89137 21.5 12 21.5Z" stroke="#ff5100" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path> 
                            </g>
                        </svg>
                    </div>

                    <p class="alert-modal__text">${message}<b>${messageBold}</b></p>
                </div>

                <div class="alert-modal__buttons-container">
                    <button type="button" class="alert-modal__button alert-modal__button--continue">${textButtonContinue}</button>
                    <button type="button" class="alert-modal__button alert-modal__button--cancel">${textButtonCancel}</button>
                </div>
            </div>
        `;

        document.body.appendChild(alert);

        const closeButton = alert.querySelector('.modal__close');
        const continueButton = alert.querySelector('.alert-modal__button--continue');
        const cancelButton = alert.querySelector('.alert-modal__button--cancel');

        const cleanUp = () => {
            alert.remove();
            document.body.style.position = '';
            document.body.style.top = '';
            window.scrollTo(0, scrollY);
        };

        closeButton.addEventListener('click', () => {
            cleanUp();
            resolve(false);
        });

        cancelButton.addEventListener('click', () => {
            cleanUp();
            resolve(false);
        });

        continueButton.addEventListener('click', () => {
            cleanUp();
            resolve(true);
        });
    });
}