<script setup lang="ts">
import SideBar from '@/components/SideBar.vue';

import Table from '@/components/Table.vue';
import { router } from '@inertiajs/vue3';

const props = defineProps<{ incomings: any[] }>();

function handleCreate(form: any) {
    router.post('/barang', form, {
        preserveScroll: true,
        onSuccess: () => {
            alert('Barang masuk berhasil ditambahkan!');
            router.reload();
        },
        onError: (errors) => {
            alert('Gagal menambah barang masuk! ' + (errors ? JSON.stringify(errors) : '')); 
        },
    });
}

function handleUpdate(form: any) {
    if (!form.id) return;
    router.put(`/barang/${form.id}`, form, {
        preserveScroll: true,
        onSuccess: () => {
            alert('Barang masuk berhasil diupdate!');
            router.reload();
        },
        onError: (errors) => {
            alert('Gagal mengupdate barang masuk! ' + (errors ? JSON.stringify(errors) : ''));
        },
    });
}

function handleDelete(ids: number[]) {
    if (!ids.length) return;
    if (!confirm('Hapus data terpilih?')) return;
    router.delete('/barang', {
        data: { ids },
        preserveScroll: true,
        onSuccess: () => {
            alert('Barang masuk berhasil dihapus!');
            router.reload();
        },
        onError: (errors) => {
            alert('Gagal menghapus barang masuk! ' + (errors ? JSON.stringify(errors) : ''));
        },
    });
}
</script>

<template>
    <div class="container">
        <div class="row">
            <div class="col-2">
                <SideBar />
            </div>
            <div class="col-10 r">
                <h1 class="mb-3">Barang Masuk</h1>
                <Table
                  :headers="[{ key: 'material_name', label: 'Material Name' }, { key: 'quantity', label: 'Quantity' }, { key: 'satuan', label: 'Satuan' }]"
                  :data="incomings"
                  :perPage="10"
                  :create="true"
                  :delete="true"
                  :update="true"
                  @create="handleCreate"
                  @delete="handleDelete"
                  @update="handleUpdate"
                />
            </div>
        </div>
    </div>
</template>

<style scoped>
.r {
    margin-top: 2rem;
    margin-bottom: 2rem;
}
</style>
