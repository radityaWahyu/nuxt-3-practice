<template>
  <div
    class="bg-slate-900 min-h-screen flex flex-1 flex-col justify-between text-gray-50"
  >
    <AppHeader />
    <div>
      <slot />
    </div>

    <AppFooter />
  </div>

  <AppErrorServer
    :open="alert.$state.serverError.isError"
    :message="alert.$state.serverError.message"
    @close-alert="alert.clearServerError"
  />
</template>
<script lang="ts" setup>
import { useAlertStore } from "#imports";
const alert = useAlertStore();

const errorLoging = (error: any) => {
  console.log(error);
};
// const error = useError();
// const closeAlert = () => {
//   clearError();
// };
</script>
