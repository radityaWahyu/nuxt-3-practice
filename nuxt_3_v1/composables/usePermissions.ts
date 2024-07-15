export function usePermissions<T>() {

    const auth = useAuthStore();

    const checkPermission = (permissions: Array<string> | any): boolean => {
        let response = false;
        auth.$state.userLogin?.permissions?.forEach((permissionName) => {
            console.log(permissionName);
            response = permissions.includes(permissionName.toString());
        })

        //console.log(permissions);
        return response;
    };


    return {
        checkPermission
    }
}

