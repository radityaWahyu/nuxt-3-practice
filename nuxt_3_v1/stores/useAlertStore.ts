import { defineStore } from "pinia"

type ServerError = {
    isError: boolean,
    message: string
    statusCode: number
}

export const useAlertStore = defineStore('alert', () => {

    const initialStateError = () => ({
        isError: false,
        message: '',
        statusCode: 0
    });
    const serverError = ref<ServerError>(initialStateError())

    const setServerError = (message: string, statusCode: number) => {
        serverError.value.isError = true;
        serverError.value.message = message;
        serverError.value.statusCode = statusCode;
    }

    const clearServerError = () => {
        Object.assign(serverError.value, initialStateError());
    }

    return { serverError, setServerError, clearServerError }
})