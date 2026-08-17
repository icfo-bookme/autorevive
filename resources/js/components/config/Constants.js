// export const BASE_URL = "http://automax.test/";
export const BASE_URL = document.head.querySelector('meta[name="app-url"]').content;
export const CSRF_TOKEN = document.head.querySelector('meta[name="csrf-token"]').content;
