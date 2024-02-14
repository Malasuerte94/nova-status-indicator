import IndexField from "./components/IndexField";
import DetailField from "./components/DetailField";
import FormField from "./components/FormField";

Nova.booting((Vue, router) => {
    Vue.component('index-indicator-field', IndexField);
    Vue.component('detail-indicator-field', DetailField);
    Vue.component('form-indicator-field', FormField);
})
