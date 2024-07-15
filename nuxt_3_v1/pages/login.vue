<template>
  <div
    class="flex justify-center items-center max-w-screen min-h-[calc(100vh-160px)] py-2"
  >
    <Card class="m-auto w-[calc(100vw*0.3)]">
      <CardHeader>
        <CardTitle class="text-2xl"> Log In Sistem </CardTitle>
        <CardDescription class="text-xs">
          Masukkan username dan password anda, apabila terjadi kendala silahkan
          hubungi <strong>Administrator</strong>
        </CardDescription>
      </CardHeader>
      <CardContent class="grid gap-4">
        <div class="grid gap-2">
          <Label for="username">Username</Label>
          <Input id="username" type="text" v-model="form.username" />
          <p
            v-for="error in auth.$state.validationError?.password"
            class="text-xs text-red-400"
          >
            {{ error }}
          </p>
        </div>
        <div class="grid gap-2">
          <Label for="password">Password</Label>
          <Input id="password" type="password" v-model="form.password" />
          <p
            v-for="error in auth.$state.validationError?.password"
            class="text-xs text-red-400"
          >
            {{ error }}
          </p>
        </div>
      </CardContent>
      <CardFooter class="flex flex-col gap-2">
        <Button class="w-full" @click="submitForm">
          <span v-if="auth.isLoading">Proses Login...</span>
          <span v-else>Masuk Sistem </span>
        </Button>
        <Button class="w-full" variant="outline" @click="backToHome">
          Halaman Beranda
        </Button>
      </CardFooter>
    </Card>
  </div>
</template>
<script lang="ts" setup>
definePageMeta({});

type FormFields = {
  username: string;
  password: string;
};

const formInitialState = () => ({ username: "", password: "" });

const form = ref<FormFields>(formInitialState());

const auth = useAuthStore();

const submitForm = async () => {
  const response = await auth.login(form.value);

  if (response) backToHome();
};

const backToHome = () => navigateTo("/");
</script>
