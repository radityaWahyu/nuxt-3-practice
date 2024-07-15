<template>
  <div class="text-xs flex items-center gap-3">
    <Avatar class="bg-slate-700">
      <AvatarFallback>US</AvatarFallback>
    </Avatar>
    <div>
      <h2 class="font-semibold uppercase">{{ username }}</h2>
      <p class="font-light capitalize">{{ role }}</p>
    </div>
  </div>
</template>

<script lang="ts" setup>
type AvatarProps = {
  username: string;
  roles?: string[];
};

const { username, roles } = withDefaults(defineProps<AvatarProps>(), {
  username: "NO Data",
  roles: () => ["no-data"],
});

const role = computed(() => roles.toString());
</script>
