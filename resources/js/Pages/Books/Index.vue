<script setup>
// Mengambil layout dashboard yang sudah dibuat pada Pertemuan 5 (lengkap dengan Sidebar)
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Link, router } from "@inertiajs/vue3";
import { ref } from "vue";

// 'books' di sini menerima data yang dikirim dari BookController@index pada Langkah 4
const props = defineProps({
    books: Object,
    search: String, // menerima kata kunci terakhir yang dikirim dari Langkah 7
});

const keyword = ref(props.search);

function cari() {
    router.get("/books", { search: keyword.value });
}

function hapus(id) {
    // confirm() menampilkan kotak dialog Ya/Batal (lihat Dasar Teori E.5)
    // Kode di dalam if hanya berjalan apabila pengguna menekan 'Ya'
    if (confirm("Yakin ingin menghapus buku ini?")) {
        router.delete(route("books.destroy", id));
        // baris di atas mengirim permintaan hapus ke method destroy() pada Langkah 4
    }
}
</script>

<template>
    <AuthenticatedLayout>
        <h1>Data Buku</h1>

        <div v-if="$page.props.flash.success">
            {{ $page.props.flash.success }}
        </div>
        <!-- Link menuju form tambah buku, akan diarahkan ke Books/Create.vue (Langkah 7) -->
        <Link href="/books/create">+ Tambah Buku</Link>

        <!-- @keyup.enter memanggil function cari() hanya saat tombol Enter ditekan -->
        <input
            v-model="keyword"
            @keyup.enter="cari"
            type="text"
            placeholder="Cari judul atau pengarang..."
        />
        <table>
            <thead>
                <tr>
                    <th>Kode</th>
                    <th>Judul</th>
                    <th>Pengarang</th>
                    <th>Tahun</th>
                    <th>Stok</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <!-- v-for mengulang setiap data buku, sama seperti perulangan foreach -->
                <tr v-for="book in books.data" :key="book.id">
                    <td>{{ book.kode_buku }}</td>
                    <td>{{ book.judul }}</td>
                    <td>{{ book.pengarang }}</td>
                    <td>{{ book.tahun }}</td>
                    <td>{{ book.stok }}</td>
                    <td>
                        <Link :href="`/books/${book.id}/edit`">Edit</Link>
                        <button @click="hapus(book.id)">Hapus</button>
                    </td>
                </tr>
            </tbody>
        </table>
    </AuthenticatedLayout>
</template>
