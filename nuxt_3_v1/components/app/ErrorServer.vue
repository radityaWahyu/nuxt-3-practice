<template>
  <Dialog :open="open">
    <DialogContent class="sm:max-w-[425px]">
      <DialogHeader>
        <DialogTitle class="text-slate-50">Peringatan</DialogTitle>
      </DialogHeader>
      <h2></h2>
      <div class="text-red-300 text-center text-xs">
        {{ message }}
      </div>
      <DialogFooter>
        <Button @click="close" class="w-full">Tutup </Button>
      </DialogFooter>
    </DialogContent>
  </Dialog>
</template>
<script lang="ts" setup>
type ModalProps = {
  statusCode?: number;
  open?: boolean;
  message?: string;
};

const { open, message, statusCode } = defineProps<ModalProps>();

const emit = defineEmits<{
  (e: "close-alert", value: boolean): void;
}>();

const close = () => emit("close-alert", true);
</script>
