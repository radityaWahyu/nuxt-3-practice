import { defineStore } from "pinia"
import { parse, stringify } from 'zipson'


type FormLogin = {
    username: string;
    password: string;
}


type UserLogin = {
    id?: string;
    nama?: string;
    role?: Array<string>;
    permissions?: Array<string>;
    token?: string;
    username?: string;
}

export const useAuthStore = defineStore('auth', () => {
    const config = useRuntimeConfig()

    const token = useCookie('XSRF-TOKEN');

    // const loggedIn = ref<boolean>(false);

    const alertStore = useAlertStore();

    let isLoading = ref<boolean>(false);

    let userLogin = ref<UserLogin | null>(null);

    const validationError = ref<{ username?: string, password?: string } | null>({});

    const getToken = async (): Promise<void> => {
        const { error } = await useApiFetch(config.public.csrfSanctumUrl);
    };

    const isLoggedIn = computed(() => !!userLogin.value);


    const login = async (formLogin: FormLogin): Promise<boolean> => {
        isLoading.value = true;

        const { error, data, pending } = await useApiFetch(config.public.apiUrl + '/login', {
            method: "POST",
            body: formLogin,
        });

        isLoading.value = false;

        if (error.value?.statusCode == 404) { alertStore.setServerError(error.value.data?.message, 404); return false; };

        if (error.value?.statusCode == 422) {
            validationError.value = error.value.data?.errors;
            return false;
        }

        validationError.value = {};
        userLogin.value = data.value as UserLogin;
        // loggedIn.value = true;

        return true;

    }

    const logout = async (): Promise<boolean> => {

        isLoading.value = true;

        const { error } = await useApiFetch(config.public.apiUrl + "/logout",)

        isLoading.value = false;

        if (error.value) { console.log(error.value); return false; }

        userLogin.value = null;
        // loggedIn.value = false;

        return true;
    }

    const getUser = async (): Promise<void> => {
        isLoading.value = true;

        const { error, data } = await useApiFetch(config.public.apiUrl + "/get-user");

        if (error.value) { console.log(error.value); }

        userLogin.value = data.value as UserLogin;
        isLoading.value = false;

    }

    const resetValidationError = () => validationError.value = {};



    return {
        token,
        validationError,
        // loggedIn,
        isLoading,
        isLoggedIn,
        userLogin,
        login,
        logout,
        getToken,
        getUser,
        resetValidationError
    }
}, {
    persist: {
        key: 'is_authentication',
        storage: persistedState.cookiesWithOptions({
            sameSite: 'strict',
        }),

    }
})