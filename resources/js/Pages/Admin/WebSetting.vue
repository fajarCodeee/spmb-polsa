<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import Modal from "@/Components/Modal.vue";
import { Head, Link, useForm, usePage } from "@inertiajs/vue3";
import { nextTick, onMounted, ref } from "vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import SecondaryButton from "@/Components/SecondaryButton.vue";
import TextInput from "@/Components/TextInput.vue";
import InputLabel from "@/Components/InputLabel.vue";
import InputError from "@/Components/InputError.vue";
import DateInput from "@/Components/DateInput.vue";
import Combobox from "@/Components/Combobox.vue";
import TextareaInput from "@/Components/TextareaInput.vue";
import FileInput from "@/Components/FileInput.vue";

defineProps({
    webSettings: {
        type: Object,
        default: () => ({
            name: "",
            title_home: "",
            institution_short_name: "",
            institution_synopsis: "",
            institution_vision_mission: "",
            institution_history: "",
            title_dashboard: "",
            title_exam: "",
            footer: "",
            contact_telp: "",
            contact_email: "",
            contact_fax: "",
            contact_address: "",
            contact_maps: "",
            contact_facebook: "",
            contact_whatsapp: "",
            payment_bank: "",
            payment_account: "",
            payment_name: "",
            contact_instagram: "",
            contact_twitter: "",
            contact_youtube: "",
            link_univ: ""
        }),
    },
});

const websetting = usePage().props.webSettings;
const form = useForm({
    name: websetting.name || "",
    title_home: websetting.title_home || "",
    institution_short_name: websetting.institution_short_name || "",
    institution_synopsis: websetting.institution_synopsis || "",
    institution_vision_mission: websetting.institution_vision_mission || "",
    institution_history: websetting.institution_history || "",
    title_dashboard: websetting.title_dashboard || "",
    title_exam: websetting.title_exam || "",
    footer: websetting.footer || "",
    payment_bank: websetting.payment_bank || "",
    payment_account: websetting.payment_account || "",
    payment_name: websetting.payment_name || "",
    contact_telp: websetting.contact_telp || "",
    contact_email: websetting.contact_email || "",
    contact_fax: websetting.contact_fax || "",
    contact_address: websetting.contact_address || "",
    contact_maps: websetting.contact_maps || "",
    contact_facebook: websetting.contact_facebook || "",
    contact_whatsapp: websetting.contact_whatsapp || "",
    contact_instagram: websetting.contact_instagram || "",
    contact_twitter: websetting.contact_twitter || "",
    contact_youtube: websetting.contact_youtube || "",
    link_univ: websetting.link_univ || "",
    path_brosur: websetting.path_brosur || "",
    path_rincian_biaya: websetting.path_rincian_biaya || "",
});

const formbackup = useForm({});
</script>

<template>

    <Head title="Web Setting" />
    <AuthenticatedLayout>
        <div>
            <div class="pt-8 flex flex-col gap-4">
                <div class="mx-auto w-full">
                    <div class="shadow-md sm:shadow-lg p-4 sm:p-8 bg-white">
                        <div class="flex flex-col">
                            <header>
                                <h2 class="text-2xl font-semibold text-gray-900 dark:text-gray-100">
                                    Setting Site
                                </h2>
                            </header>
                            <form @submit.prevent="
                                form.patch(
                                    route('admin.web-setting.update')
                                )
                                ">
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <div class="col-span-1">
                                        <InputLabel for="name" value="Nama Website" />
                                        <TextInput id="name" class="mt-1 block w-full" v-model="form.name" />
                                        <InputError class="mt-2" :message="form.errors.name" />
                                    </div>
                                    <div class="col-span-1">
                                        <InputLabel for="institution_short_name" value="Singkatan Nama Kampus" />
                                        <TextInput id="institution_short_name" class="mt-1 block w-full"
                                            v-model="form.institution_short_name" />
                                        <InputError class="mt-2" :message="form.errors.institution_short_name" />
                                    </div>
                                    <div class="col-span-1">
                                        <InputLabel for="title_home" value="Judul Halaman Depan" />
                                        <TextInput id="title_home" class="mt-1 block w-full"
                                            v-model="form.title_home" />
                                        <InputError class="mt-2" :message="form.errors.title_home" />
                                    </div>
                                    <div class="col-span-1">
                                        <InputLabel for="title_dashboard" value="Judul Halaman Dashboard" />
                                        <TextInput id="title_dashboard" class="mt-1 block w-full"
                                            v-model="form.title_dashboard" />
                                        <InputError class="mt-2" :message="form.errors.title_dashboard
                                            " />
                                    </div>
                                    <div class="col-span-1">
                                        <InputLabel for="title_exam" value="Judul Halaman Ujian" />
                                        <TextInput id="title_exam" class="mt-1 block w-full"
                                            v-model="form.title_exam" />
                                        <InputError class="mt-2" :message="form.errors.title_exam" />
                                    </div>
                                    <div class="col-span-1">
                                        <InputLabel for="contact_telp" value="Kontak Telepon" />
                                        <TextInput id="contact_telp" class="mt-1 block w-full"
                                            v-model="form.contact_telp" />
                                        <InputError class="mt-2" :message="form.errors.contact_telp" />
                                    </div>
                                    <div class="col-span-1">
                                        <InputLabel for="contact_email" value="Kontak Email" />
                                        <TextInput id="contact_email" class="mt-1 block w-full"
                                            v-model="form.contact_email" />
                                        <InputError class="mt-2" :message="form.errors.contact_email" />
                                    </div>
                                    <div class="col-span-1">
                                        <InputLabel for="contact_fax" value="Kontak Fax" />
                                        <TextInput id="contact_fax" class="mt-1 block w-full"
                                            v-model="form.contact_fax" />
                                        <InputError class="mt-2" :message="form.errors.contact_fax" />
                                    </div>
                                    <div class="col-span-1">
                                        <InputLabel for="contact_address" value="Kontak Alamat" />
                                        <TextareaInput id="contact_address" class="mt-1 block w-full"
                                            v-model="form.contact_address" />
                                        <InputError class="mt-2" :message="form.errors.contact_address
                                            " />
                                    </div>
                                    <div class="col-span-1">
                                        <InputLabel for="footer" value="Footer" />
                                        <TextareaInput id="footer" class="mt-1 block w-full" v-model="form.footer" />
                                        <InputError class="mt-2" :message="form.errors.footer" />
                                    </div>
                                    <div class="col-span-1">
                                        <InputLabel for="institution_synopsis" value="Sinopsis" />
                                        <TextareaInput id="institution_synopsis" class="mt-1 block w-full"
                                            v-model="form.institution_synopsis" />
                                        <InputError class="mt-2" :message="form.errors.institution_synopsis" />
                                    </div>
                                    <div class="col-span-1">
                                        <InputLabel for="institution_vision_mission" value="Visi & Misi" />
                                        <TextareaInput id="institution_vision_mission" class="mt-1 block w-full"
                                            v-model="form.institution_vision_mission" />
                                        <InputError class="mt-2" :message="form.errors.institution_vision_mission" />
                                    </div>
                                    <div class="col-span-1">
                                        <InputLabel for="contact_facebook" value="Kontak Facebook" />
                                        <TextInput id="contact_facebook" class="mt-1 block w-full"
                                            v-model="form.contact_facebook" />
                                        <InputError class="mt-2" :message="form.errors.contact_facebook
                                            " />
                                    </div>

                                    <div class="col-span-1">
                                        <InputLabel for="contact_whatsapp" value="Kontak Whatsapp" />
                                        <TextInput id="contact_whatsapp" class="mt-1 block w-full"
                                            v-model="form.contact_whatsapp" />
                                        <InputError class="mt-2" :message="form.errors.contact_whatsapp
                                            " />
                                    </div>

                                    <div class="col-span-1">
                                        <InputLabel for="contact_instagram" value="Kontak Instagram" />
                                        <TextInput id="contact_instagram" class="mt-1 block w-full"
                                            v-model="form.contact_instagram" />
                                        <InputError class="mt-2" :message="form.errors.contact_instagram
                                            " />
                                    </div>

                                    <div class="col-span-1">
                                        <InputLabel for="contact_twitter" value="Kontak Twitter" />
                                        <TextInput id="contact_twitter" class="mt-1 block w-full"
                                            v-model="form.contact_twitter" />
                                        <InputError class="mt-2" :message="form.errors.contact_twitter
                                            " />
                                    </div>

                                    <div class="col-span-1">
                                        <InputLabel for="contact_youtube" value="Kontak Youtube" />
                                        <TextInput id="contact_youtube" class="mt-1 block w-full"
                                            v-model="form.contact_youtube" />
                                        <InputError class="mt-2" :message="form.errors.contact_youtube
                                            " />
                                    </div>

                                    <div class="col-span-1">
                                        <InputLabel for="link_univ" value="Link Universitas" />
                                        <TextInput id="link_univ" class="mt-1 block w-full" v-model="form.link_univ" />
                                        <InputError class="mt-2" :message="form.errors.link_univ" />
                                    </div>

                                    <div class="col-span-1">
                                        <InputLabel for="payment_bank" value="BANK" />
                                        <TextInput id="payment_bank" class="mt-1 block w-full"
                                            v-model="form.payment_bank" placholder="Bank BNI" />
                                        <InputError class="mt-2" :message="form.errors.payment_bank" />
                                    </div>

                                    <div class="col-span-1">
                                        <InputLabel for="payment_account" value="Nomer Rekening" />
                                        <TextInput id="payment_account" class="mt-1 block w-full"
                                            v-model="form.payment_account" placeholder="Cth: 00323-01-30-000028-7" />
                                        <InputError class="mt-2" :message="form.errors.payment_account" />
                                    </div>

                                    <div class="col-span-1">
                                        <InputLabel for="payment_name" value="Nama Pemilik Akun Bank" />
                                        <TextInput id="payment_name" class="mt-1 block w-full"
                                            v-model="form.payment_name" placeholder="Nama Lengkap Pemiliki Bank" />
                                        <InputError class="mt-2" :message="form.errors.payment_name" />
                                    </div>

                                </div>
                                <div class="flex justify-end gap-4">
                                    <PrimaryButton type="submit" class="mt-4" :disabled="form.processing">
                                        <span v-if="form.processing">
                                            Processing
                                        </span>
                                        <span v-else>Simpan</span>
                                    </PrimaryButton>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="w-1/2 mx-auto">
                    <div class="shadow-md sm:shadow-lg p-4 sm:p-8 bg-white">
                        <div
                            class="flex flex-column sm:flex-row flex-wrap space-y-4 sm:space-y-0 items-center justify-between">
                            <header>
                                <h2 class="text-lg font-semibold text-gray-900 dark:text-gray-100">
                                    Backup Project
                                </h2>
                            </header>
                        </div>
                        <form @submit.prevent="
                            formbackup.patch(
                                route('admin.web-setting.backup')
                            )
                            " class="mt-6 space-y-6">
                            <div class="flex justify-start">
                                <PrimaryButton type="submit" class="mt-4" :disabled="formbackup.processing">
                                    <span v-if="formbackup.processing">
                                        Processing
                                    </span>
                                    <span v-else>backup sekarang</span>
                                </PrimaryButton>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
