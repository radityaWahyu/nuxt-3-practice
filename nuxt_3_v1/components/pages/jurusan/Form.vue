<template>
  <Dialog :open="open">
    <DialogContent class="sm:max-w-[425px]">
      <DialogHeader>
        <DialogTitle class="text-slate-50">Tambah Jurusan</DialogTitle>
        <DialogDescription class="text-xs">
          Silahkan menginputkan data jurusan baru, setelah itu silahkan menekan
          tombol simpan.
        </DialogDescription>
      </DialogHeader>
      <div class="grid gap-4 py-4">
        <div class="grid grid-cols-4 items-center gap-4">
          <Label for="jurusan" class="text-right text-slate-50">
            Jurusan
          </Label>
          <Input
            id="name"
            v-model="form.nama"
            class="col-span-3 text-slate-50"
            :disabled="jurusan.isCreated"
          />
        </div>
        <p
          v-for="error in jurusan.$state.validationError.nama"
          class="text-xs text-red-400"
        >
          {{ error }}
        </p>
      </div>
      <DialogFooter>
        <Button variant="secondary" @click="close">Batal </Button>
        <Button type="submit" @click="submitForm">
          <span v-if="isPending">Loading</span>
          <span v-else>Simpan</span>
        </Button>
      </DialogFooter>
    </DialogContent>
  </Dialog>
</template>
<script lang="ts" setup>
import { useJurusanStore } from "#imports";

type ModalProps = {
  open: boolean;
  id?: string;
};

type FormFields = {
  nama: string;
};

const formInitialState = () => ({ nama: "" });

const form = ref<FormFields>(formInitialState());

const { open, id } = defineProps<ModalProps>();
const emit = defineEmits<{
  (e: "close-modal", value: boolean): void;
  (e: "submit-modal", value: boolean): void;
}>();

const jurusan = useJurusanStore();
const { data, store, isPending } = await jurusan.createJurusan(form.value);

const submitForm = async () => {
  await store();
  if (data.value) {
    resetForm();
    emit("submit-modal", true);
  }
};

const resetForm = () => {
  Object.assign(form.value, formInitialState());
  //form.value.nama = "";

  jurusan.resetValidationError();
};

const close = () => {
  resetForm();
  emit("close-modal", true);
};
</script>
