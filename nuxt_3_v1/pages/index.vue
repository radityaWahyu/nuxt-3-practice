<template>
  <main class="min-h-[calc(100vh-160px)] text-sm py-2">
    <div class="max-w-screen-xl m-auto flex flex-col flex-1 gap-5">
      <div class="flex items-center justify-between max-w-[calc(100vw*0.42)]">
        <div class="flex items-center gap-2">
          <Icon name="carbon:arrow-left" class="w-6 h-6" />
          <h1 class="text-xl font-semibold md:text-2x text-slate-50">
            Simple CRUD Nuxt 3 + Laravel API
          </h1>
        </div>
        <Button @click="isModalOpen = true">Tambah Jurusan</Button>
        <Button @click="refreshData">Reload Jurusan</Button>
        <Button @click="throwError">Throw Error</Button>
      </div>
      <div class="flex flex-col flex-1 gap-4">
        <Alert class="max-w-xl text-slate-50">
          <Icon
            name="carbon:ibm-engineering-workflow-mgmt"
            class="w-5 h-5"
            color="white"
          />
          <AlertTitle> Informasi </AlertTitle>
          <AlertDescription>
            Halaman beranda ini dipergunakan untuk menampilkan fitur CRUD
            (Create, Read, Update dan Delete) dengan menggunakan backend
            Framework Laravel dan frontend menggunakan Nuxt 3.
          </AlertDescription>
        </Alert>
        <div v-if="can(['manage-jurusan', 'read-jurusan'])">
          <div v-if="isPending"><p>Memuat Data...</p></div>
          <div v-else class="flex flex-col gap-3">
            <Card
              class="max-w-xl p-0"
              v-for="(jurusan, index) in jurusans?.data"
              v-bind:key="index"
            >
              <CardHeader>
                <CardTitle>{{ jurusan.nama }}</CardTitle>
                <CardDescription> Nama Kompetensi Keahlian </CardDescription>
              </CardHeader>
              <CardFooter class="flex gap-2 justify-end">
                <Button variant="destructive"> Cancel </Button>
                <Button>Hapus</Button>
              </CardFooter>
            </Card>
            <div class="flex gap-6 items-center">
              <Pagination
                v-slot="{ page }"
                :total="jurusans?.total"
                :items-per-page="jurusans?.per_page"
                v-model:page="pageData"
                @update:page="updateData"
              >
                <PaginationList
                  v-slot="{ items }"
                  class="flex items-center gap-1"
                >
                  <!-- <PaginationFirst /> -->
                  <PaginationPrev class="w-auto px-4">Pervious</PaginationPrev>

                  <!-- <template v-for="(item, index) in items">
                  <PaginationListItem
                    v-if="item.type === 'page'"
                    :key="index"
                    :value="item.value"
                    as-child
                  >
                    <Button
                      class="w-10 h-10 p-0"
                      :variant="item.value === page ? 'default' : 'outline'"
                    >
                      {{ item.value }}
                    </Button>
                  </PaginationListItem>
                  <PaginationEllipsis v-else :key="item.type" :index="index" />
                </template> -->

                  <PaginationNext class="w-auto px-4"> Next </PaginationNext>
                  <!-- <PaginationLast /> -->
                </PaginationList>
              </Pagination>
              <p class="font-light text-xs">
                Menampilkan data {{ jurusans?.from }}-{{ jurusans?.to }} dari
                total <strong>{{ jurusans?.total }}</strong> data
              </p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </main>
  <PagesJurusanForm
    :open="isModalOpen"
    @close-modal="modalClosed"
    @submit-modal="isSubmited"
  />
</template>
<script lang="ts" setup>
const { checkPermission: can } = usePermissions();
const { getJurusan } = useJurusanStore();

let isModalOpen = ref<boolean>(false);

let pageData = ref<number>(1);
const pageNumber = computed(() => pageData.value);

const {
  data: jurusans,
  pending: isPending,
  error,
  execute: refreshData,
  refresh,
} = await getJurusan(pageNumber);

const modalClosed = (data: boolean) => (isModalOpen.value = !data);
const isSubmited = (data: boolean) => (isModalOpen.value = !data);
const updateData = (page: number) => {
  pageData.value = page;
  refresh();
};

if (error.value?.statusCode == 403) {
  throw createError({
    statusCode: 403,
    statusMessage: "Akses Terbatas",
    message: "Akses Terbatas",
  });
}

const throwError = () => {
  throw createError({
    statusCode: 403,
    statusMessage: "coba error",
    message: "error",
  });
};
</script>
