let activeNotification = null;

export function createNotification(type, message) {
    let activeNotificationType = activeNotification !== null ? activeNotification.classList[1].split("--")[1] : null;

    if (activeNotificationType === type) {
        return;
    } else if ((activeNotificationType !== type) && (activeNotification !== null)) {
        activeNotification.classList.add("notification--hidden");
        setTimeout(() => {
            activeNotification.remove();
            activeNotification = null;
        }, 600);

        setTimeout(() => {
            createNotification(type, message);
        }, 700);
        return;
    }

    const notification = document.createElement("div");
    notification.classList.add("notification", `notification--${type}`);

    const messageElement = document.createElement("p");
    messageElement.classList.add("notification__message");
    messageElement.textContent = message;
    notification.appendChild(messageElement);
    document.body.appendChild(notification);

    activeNotification = notification;

    setTimeout(() => {
        notification.classList.add("notification--hidden");
    }, 5000);

    setTimeout(() => {
        notification.remove();
        activeNotification = null;
    }, 5600);
}