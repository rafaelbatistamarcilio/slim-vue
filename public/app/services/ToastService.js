
export const TOAST_EVENT = 'TOAST_EVENT';

export const toast = message => PubSub.publish(TOAST_EVENT, message);

export const watchToast = callback => PubSub.subscribe(TOAST_EVENT, (message, data) => callback(data));