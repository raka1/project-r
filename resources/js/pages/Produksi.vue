<script setup lang="ts">
import SideBar from '@/components/SideBar.vue';
import Table from '@/components/Table.vue';
import { router } from '@inertiajs/vue3';
import { ref, computed } from 'vue';

const props = defineProps<{ products: any[] }>();

interface RawMaterial {
    incoming_id: number | null;
    quantity: number | null;
}

const createForm = ref({
    name: '',
    stock: '',
    price: ''
});
const creating = ref(false);
const showCreateForm = ref(false);

const updateForm = ref({
    id: null,
    name: '',
    stock: '',
    price: ''
});
const showUpdateForm = ref(false);
const updating = ref(false);
const selectedRows = ref<any[]>([]);
const invoicing = ref(false);

const selectedRow = computed(() => {
    return selectedRows.value.length === 1 ? selectedRows.value[0] : null;
});

function toggleCreateForm() {
    showCreateForm.value = !showCreateForm.value;
}

function toggleUpdateForm() {
    if (!selectedRow.value) return;
    if (showUpdateForm.value) {
        updateForm.value = { id: null, name: '', stock: '', price: '' };
        showUpdateForm.value = false;
        return;
    }
    updateForm.value = {
        id: selectedRow.value.id,
        name: selectedRow.value.name,
        stock: selectedRow.value.stock,
        price: selectedRow.value.price
    };
    showUpdateForm.value = true;
}

function sellProduct() {
    if (!selectedRow.value) return;
    invoicing.value = true;
    router.post('/invoice', { product_name: selectedRow.value.name }, {
        preserveScroll: true,
        onSuccess: () => {
            alert('Produk berhasil dijual!');
            router.reload();
        },
        onError: (errors) => {
            if (errors && errors.stock) {
                alert('Stok produk habis!');
            } else {
                alert('Gagal menjual produk! ' + (errors ? JSON.stringify(errors) : ''));
            }
        },
        onFinish: () => {
            invoicing.value = false;
        }
    });
}

function submitCustomCreate() {
    creating.value = true;
    handleCreate({ ...createForm.value });
    createForm.value = { name: '', stock: '', price: '' };
    creating.value = false;
    showCreateForm.value = false;
}

function submitCustomUpdate() {
    updating.value = true;
    handleUpdate({ ...updateForm.value });
    updateForm.value = { id: null, name: '', stock: '', price: '' };
    updating.value = false;
    showUpdateForm.value = false;
}

function handleSelect(rows: any[]) {
    selectedRows.value = rows;
    if (rows.length !== 1 && showUpdateForm.value) {
        showUpdateForm.value = false;
        updateForm.value = { id: null, name: '', stock: '', price: '' };
    }
}

function handleCreate(form: any) {
    router.post('/produksi', form, {
        preserveScroll: true,
        onSuccess: () => {
            alert('Produksi berhasil ditambahkan!');
            router.reload();
        },
        onError: (errors) => {
            alert('Gagal menambah produksi! ' + (errors ? JSON.stringify(errors) : ''));
        },
    });
}

function handleUpdate(form: any) {
    if (!form.id) return;
    router.put(`/produksi/${form.id}`, form, {
        preserveScroll: true,
        onSuccess: () => {
            alert('Produksi berhasil diupdate!');
            router.reload();
            window.location.reload();
        },
        onError: (errors) => {
            alert('Gagal mengupdate produksi! ' + (errors ? JSON.stringify(errors) : ''));
        },
    });
}

function handleDelete(ids: number[]) {
    if (!ids.length) return;
    if (!confirm('Hapus data terpilih?')) return;
    router.delete('/produksi', {
        data: { ids },
        preserveScroll: true,
        onSuccess: () => {
            alert('Produksi berhasil dihapus!');
            router.reload();
        },
        onError: (errors) => {
            alert('Gagal menghapus produksi! ' + (errors ? JSON.stringify(errors) : ''));
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
                <h1>Produksi</h1>
                <div style="display: flex; gap: 2rem; align-items: flex-start;">
                    <div>

                        <button class="mb-2" @click="toggleCreateForm">{{ showCreateForm ? 'Hide' : 'Show' }} Create Form</button>
                        <button class="mb-2" @click="toggleUpdateForm" :disabled="!selectedRow">{{ showUpdateForm ? 'Hide' : 'Show' }} Update Form</button>
                        <button class="mb-2" @click="sellProduct" :disabled="!selectedRow || invoicing">Sell</button>
                        
                        <form v-if="showCreateForm" @submit.prevent="submitCustomCreate" class="form-aligned mb-4">
                            <div class="form-row">
                                <label for="name">Nama Produk</label>
                                <input id="name" v-model="createForm.name" name="name" required />
                            </div>
                            <div class="form-row">
                                <label for="stock">Stok</label>
                                <input id="stock" v-model="createForm.stock" name="stock" />
                            </div>
                            <div class="form-row">
                                <label for="price">Harga</label>
                                <input id="price" v-model="createForm.price" name="price" required />
                            </div>
                            <div class="form-row">
                                <label style="font-weight: bold;">Materials</label>
                                <button type="button" style="margin-left: 1rem;">+ Add Material</button>
                            </div>
                            <button type="submit" :disabled="creating">Submit</button>
                        </form>
                        
                        <form v-if="showUpdateForm" @submit.prevent="submitCustomUpdate" class="form-aligned mb-4">
                            <div class="form-row">
                                <label for="update-name">Nama Produk</label>
                                <input id="update-name" v-model="updateForm.name" name="name" required />
                            </div>
                            <div class="form-row">
                                <label for="update-stock">Stok</label>
                                <input id="update-stock" v-model="updateForm.stock" name="stock" />
                            </div>
                            <div class="form-row">
                                <label for="update-price">Harga</label>
                                <input id="update-price" v-model="updateForm.price" name="price" required />
                            </div>
                            <div class="form-row">
                                <label style="font-weight: bold;">Materials</label>
                                <button type="button" style="margin-left: 1rem;">+ Add Material</button>
                            </div>
                            <button type="submit" :disabled="updating">Update</button>
                        </form>
                    </div>
                </div>
                
                <Table
                  :headers="[
                    { key: 'name', label: 'Nama Produk' },
                    { key: 'stock', label: 'Stok' },
                    { key: 'price', label: 'Harga' }
                  ]"
                  :data="products"
                  :perPage="10"
                  :create="false"
                  :update="false"
                  :delete="true"
                  @delete="handleDelete"
                  @select="handleSelect"
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

.form-aligned {
    display: flex;
    flex-direction: column;
    max-width: 350px;
    margin-bottom: 1rem;
}

.form-row {
    display: flex;
    align-items: center;
    margin-bottom: 0.5rem;
}

.form-row label {
    min-width: 120px;
    margin-right: 0.5rem;
    text-align: right;
}

.form-row input {
    flex: 1;
    padding: 0.2rem 0.4rem;
}
</style>