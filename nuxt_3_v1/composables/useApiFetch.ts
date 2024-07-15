import type { UseFetchOptions } from 'nuxt/app'
import { useAlertStore } from '#imports';

export function useApiFetch<T>(path: string, options: UseFetchOptions<T> = {}) {
    let headers: any = {
        Accept: "application/json",
    };

    const router = useRouter();

    const config = useRuntimeConfig();

    const alertStore = useAlertStore();

    const token = useCookie('XSRF-TOKEN');

    if (token.value) {
        headers['X-XSRF-TOKEN'] = token.value as string;
    }

    if (process.server) {
        headers = {
            ...headers,
            ...useRequestHeaders(['referer', 'cookie'])
        }
    }

    return useFetch(config.public.baseUrl + path, {
        credentials: "include",
        watch: false,
        ...options,
        headers: {
            ...headers,
            ...options?.headers
        },
        onResponseError(error) {
            if (error.response.status == 500) alertStore.setServerError(error.response._data?.message, 500);
            if (error.response.status == 401) router.push({ path: "/login" });

        }
    });
}