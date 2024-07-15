<template>
  <div class="max-w-screen-xl m-auto">
    <h2>Ini halaman tentang kami</h2>
  </div>
</template>
<script lang="ts" setup>
definePageMeta({
  middleware: ["auth"],
  permissions: ["manajemen-jurusan", "read-jurusan"],
});
</script>
