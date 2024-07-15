<template>
  <header class="border-b-[1px] border-gray-400/30 h-[60px]">
    <div
      class="flex justify-between items-center max-w-screen-xl h-full m-auto"
    >
      <div class="flex justify-between w-[350px]">
        <div><Icon name="uim:adobe-alt" class="w-10 h-10" /></div>
        <ul class="flex gap-5 text-sm font-light items-center">
          <li>Beranda</li>
          <li>Tentang Kami</li>
          <li>Hubungi Kami</li>
        </ul>
      </div>
      <div v-if="auth.isLoading" class="flex flex-col gap-2">
        <Skeleton class="h-2 w-[150px]" />
        <Skeleton class="h-2 w-[100px]" />
      </div>
      <div class="flex gap-2" v-else>
        <AppTopAvatar
          :username="auth.$state.userLogin?.nama"
          :roles="auth.$state.userLogin?.role"
          v-show="auth.isLoggedIn"
        />
        <Button
          class="max-h-8"
          variant="outline"
          v-show="!auth.isLoggedIn"
          @click="navigateTo('/login')"
        >
          Log In
        </Button>
        <Button class="max-h-8 px-8" v-show="!auth.isLoggedIn">Register</Button>
        <Button class="max-h-8" v-show="auth.isLoggedIn" @click="logout">
          Log Out
        </Button>
      </div>
    </div>
  </header>
</template>

<script lang="ts" setup>
const auth = useAuthStore();
const router = useRouter();

const logout = async () => {
  const response = await auth.logout();
  console.log(response);
  if (response) {
    router.push({ path: "/login" });
  }
};
</script>
