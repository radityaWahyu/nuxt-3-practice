<template>
  <NuxtLayout>
    <div>
      <h1>Dang</h1>
      <p>
        <strong>{{ props.error?.message }}</strong>
      </p>
      <p>Sorry about that.</p>
    </div>
  </NuxtLayout>
</template>
<script setup lang="ts">
import type { NuxtError } from "#app";

const props = defineProps({
  error: Object as () => NuxtError,
});

const handleError = () => clearError({ redirect: "/" });
</script>
