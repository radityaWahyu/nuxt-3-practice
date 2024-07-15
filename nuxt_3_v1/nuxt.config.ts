// https://nuxt.com/docs/api/configuration/nuxt-config
export default defineNuxtConfig({
  devtools: { enabled: true },
  modules: [
    "@nuxtjs/tailwindcss",
    "@nuxtjs/color-mode",
    "shadcn-nuxt",
    "nuxt-icon",
    "@pinia/nuxt",
    '@pinia-plugin-persistedstate/nuxt',
  ],
  colorMode: {
    classSuffix: ''
  },
  shadcn: {
    /**
     * Prefix for all the imported component
     */
    prefix: '',
    /**
     * Directory that the component lives in.
     * @default "./components/ui"
     */
    componentDir: './components/ui'
  },
  runtimeConfig: {
    public: {
      baseUrl: process.env.BASE_URL,
      apiUrl: process.env.API_URL,
      csrfSanctumUrl: process.env.SANCTUM_CSRF_URL
    }
  }
})