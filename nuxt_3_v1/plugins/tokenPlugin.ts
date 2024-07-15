export default defineNuxtPlugin(nuxtApp => {
    const { getToken, token, getUser, isLoggedIn } = useAuthStore()


    const getUserProfile = async () => {
        await getUser();
    };



    // if (!isLoggedIn && loggedIn) {
    //     //console.log(isLoggedIn);
    //     getUserProfile();
    // }
    const getCsrfToken = async () => await getToken();

    if (!token) getCsrfToken();



})