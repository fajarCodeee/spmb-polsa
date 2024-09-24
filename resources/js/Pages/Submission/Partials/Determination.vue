<script setup>
import { onMounted, ref } from "vue";
import { useForm } from "@inertiajs/vue3";
import Container from "@/Components/Container.vue";
import Card from "@/Components/Card.vue";
import Display from "@/Components/Display.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";

const props = defineProps({
    form: {
        default: null,
        type: Object,
    },
});

const print = async () => {
    try {
        const response = await fetch(route("form.pdf-print"), {
            method: "GET",
        });

        const pdfBlob = await response.blob();
        const url = window.URL.createObjectURL(pdfBlob);
        const link = document.createElement("a");
        link.href = url;
        link.setAttribute("download", "hasil-seleksi.pdf");
        document.body.appendChild(link);
        link.click();
    } catch (error) {
        console.log(error);
    }
};

onMounted(() => {
    console.log(props.form);

})

const randomNumber = Math.floor(100000 + Math.random() * 900000);

const copyToClipboard = (text) => {
    const elem = document.createElement("textarea");
    elem.value = text.replace(/ |-/g, "");
    document.body.appendChild(elem);
    elem.select();
    document.execCommand("copy");
    document.body.removeChild(elem);
    statusCopy.value = true;
    setTimeout(() => {
        statusCopy.value = false;
    }, 3000);
};
const statusCopy = ref(false);
</script>
<template>
    <div>
        <Container>
            <Card>
                <div class="p-0 md:p-8 relative">
                    <div class="bg-white p-14 rounded-lg shadow-md">
                        <h2 class="text-2xl font-bold text-center">
                            Panitia Penerimaan Mahasiswa Baru
                        </h2>
                        <h3 class="text-xl font-semibold text-center capitalize">
                            Politeknik Sawunggalih Aji
                            {{ form.wave.tahun_akademik }}
                        </h3>
                        <div class="flex flex-col gap-4 mt-24">
                            <Display label="Nama" :value="form.name" />
                            <Display label="Email" :value="form.email" />
                            <Display label="Tempat, Tanggal lahir"
                                :value="`${form.birth_place_city}, ${form.birth_date}`" />
                            <Display label="Program Studi" :value="form.prodi" />
                            <Display label="No. Peserta" :value="form.no_exam" />
                            <Display label="Status" :value="form.end_status" />

                            <div>
                                <p>
                                    Berdasarkan hasil penilaian yang telah
                                    dilakukan, peserta seleksi yang bernama
                                    <b>{{ form.name }}</b> dinyatakan:
                                </p>

                                <div v-if="form.end_status == 'approved'">
                                    <p
                                        class="text-green font-bold uppercase text-center bg-green-200 p-4 rounded-lg mt-4">
                                        Diterima
                                    </p>
                                    <br>
                                    <p>
                                        Selanjutnya, silahkan melakukan pembayaran <b>Registrasi</b>
                                        untuk melanjutkan
                                        proses registrasi mahasiswa
                                    </p>
                                    <br>
                                    <p>
                                        Informasi Pembayaran
                                    </p>
                                    <p>
                                        Lakukan pembayaran sebesar
                                        <span class="font-semibold text-blue-700">{{
                                            new Intl.NumberFormat("id-ID", {
                                                style: "currency",
                                                currency: "IDR",
                                            }).format(props.form.biaya_registrasi)
                                        }}</span>
                                        ke rekening berikut:
                                    </p>
                                    <p class="font-semibold text-lg">
                                        {{ $page.props.web_settings.payment_bank }}
                                    </p>
                                    <div class="inline-flex items-center gap-x-3">
                                        <div class="text-sm font-medium text-gray-800 dark:text-white">
                                            {{ $page.props.web_settings.payment_account }}
                                        </div>

                                        <button type="button"
                                            class="p-2 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-gray-200 bg-white text-gray-800 shadow-sm hover:bg-gray-50 disabled:opacity-50 disabled:pointer-events-none dark:bg-slate-900 dark:border-gray-700 dark:text-white dark:hover:bg-gray-800 dark:focus:outline-none dark:focus:ring-1 dark:focus:ring-gray-600"
                                            @click="
                                                copyToClipboard(
                                                    $page.props.web_settings.payment_account
                                                )
                                                ">
                                            <svg class="w-4 h-4 group-hover:rotate-6 transition"
                                                xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                                stroke-linecap="round" stroke-linejoin="round" :class="{
                                                    'hidden ': statusCopy,
                                                }">
                                                <rect width="8" height="4" x="8" y="2" rx="1" ry="1" />
                                                <path
                                                    d="M16 4h2a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2h2" />
                                            </svg>

                                            <svg class="w-4 h-4 text-blue-600" xmlns="http://www.w3.org/2000/svg"
                                                width="24" height="24" viewBox="0 0 24 24" fill="none"
                                                stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                                stroke-linejoin="round" :class="{
                                                    'block ': statusCopy,
                                                    hidden: !statusCopy,
                                                }">
                                                <polyline points="20 6 9 17 4 12" />
                                            </svg>
                                        </button>
                                    </div>
                                    <p>A.n {{ $page.props.web_settings.payment_name }}</p>
                                    <p class="mt-4">
                                        <span class="font-semibold text-base">Kode Pembayaran:
                                        </span>
                                        <span class="font-semibold text-blue-700">{{
                                            randomNumber
                                        }}</span>
                                    </p>
                                    <p class="text-red-600 italic">* Pilih Jenis Pembayaran <b>Registrasi</b>
                                    </p>

                                </div>

                                <div v-else-if="form.end_status == 'rejected'">
                                    <div class="bg-red-200 p-4 rounded-lg mt-4">
                                        <p class="text-red font-bold uppercase text-center">
                                            Ditolak
                                        </p>
                                    </div>
                                    <div class="mt-4">
                                        <p>
                                            Alasan penolakan:
                                            {{ form.reason_rejected }}
                                        </p>
                                    </div>
                                </div>
                                <div v-else>
                                    <div class="bg-yellow-200 p-4 rounded-lg mt-4">
                                        <p class="text-yellow font-bold uppercase text-center">
                                            Menunggu
                                        </p>
                                    </div>
                                    <div class="mt-4">
                                        <p class="text-center font-semibold">
                                            sedang menunggu verifikasi panitia
                                        </p>
                                    </div>
                                </div>
                            </div>

                            <!-- <div class="flex justify-start items-center gap-4 mt-8">
                                <PrimaryButton v-if="form.end_status == 'approved'" @click="print">
                                    Cetak Bukti Kelulusan
                                </PrimaryButton>
                            </div> -->
                        </div>
                    </div>

                    <div v-if="form.end_status == 'submitted'"
                        class="absolute top-0 left-0 bg-gray-800 text-white p-4 rounded-lg opacity-80 w-full h-full flex justify-center items-center">
                        <p class="text-center">
                            Pengumuman belum dapat dikeluarkan karena belum
                            diverifikasi oleh admin.
                        </p>
                    </div>
                </div>
            </Card>
        </Container>
    </div>
</template>
