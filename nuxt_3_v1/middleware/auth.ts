export default defineNuxtRouteMiddleware((to, from) => {
    const auth = useAuthStore();
    const { checkPermission } = usePermissions();


    const isLoggedIn = computed(() => !!auth.$state.userLogin)

    console.log(isLoggedIn.value);

    if (!isLoggedIn.value) {
        //console.log(auth.isLoggedIn);
        return abortNavigation({ message: 'Halaman tidak ditemukan', statusCode: 404 });
    }

    if (!checkPermission(to.meta.permissions)) return abortNavigation({ message: 'Halaman tidak ditemukan', statusCode: 404 });
    return;
})