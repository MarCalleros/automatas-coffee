let activeNotification = null;
let timeoutHide = null;
let timeoutRemove = null;

export function createNotification(type, message) {
    if (activeNotification) {
        clearTimeout(timeoutHide);
        clearTimeout(timeoutRemove);
        activeNotification.remove();
        activeNotification = null;
    }

    const notification = document.createElement("div");
    notification.classList.add("notification", `notification--${type}`);

    const messageElement = document.createElement("p");
    messageElement.classList.add("notification__message");
    messageElement.textContent = message;
    notification.appendChild(messageElement);
    document.body.appendChild(notification);

    activeNotification = notification;

    timeoutHide = setTimeout(() => {
        notification.classList.add("notification--hidden");
    }, 5000);

    timeoutRemove = setTimeout(() => {
        notification.remove();
        activeNotification = null;
    }, 5600);
}