import { defineStore } from "pinia"

type FormData = {
    nama: string;
}
type jurusan = {
    id: string;
    nama: string;
};

type jurusanResponse = {
    data: jurusan[];
    first_page_url: string;
    current_page: number;
    from: number;
    last_page: number;
    last_page_url: string;
    next_page_url: string;
    per_page: number;
    prev_page_url: string;
    to: number;
    total: number;
};



export const useJurusanStore = defineStore('jurusan', () => {
    const jurusanUrl = "/api/v1/jurusan";
    const isCreated = ref<boolean>(false);


    const validationError = ref<{ nama?: string }>({});


    const getJurusan = async (page: any) => {

        const getJurusan = await useApiFetch<jurusanResponse>(`${jurusanUrl}`,
            {
                key: `jurusanlist-${page}`,
                query: { page: page },
                // server: false
            }
        );

        console.log(getJurusan.data);

        return getJurusan;
    }

    const createJurusan = async (formData: FormData) => {
        const isPending = ref<boolean>(false);
        const { data, pending, error, execute } = await useApiFetch(jurusanUrl, {
            method: "POST",
            body: formData,
            immediate: false,
        });

        async function store() {
            await execute();
            isPending.value = pending.value
            if (error.value?.statusCode == 403) {
                throw createError({
                    statusCode: 403,
                    statusMessage: "anda tidak memiliki akses",
                    message: "anda tidak memilki akses",
                });
            }

            if (error.value?.statusCode == 422) {
                validationError.value = error.value?.data?.errors;
            }
        }






        return {
            data,
            store,
            isPending
        };
    }

    const resetValidationError = () => validationError.value = {}




    return {
        isCreated,
        validationError,
        createJurusan,
        getJurusan,
        resetValidationError
    }
})