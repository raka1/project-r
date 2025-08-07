<script setup lang="ts">
import { ref, computed, watch, defineEmits } from 'vue';

interface Header {
    key: string;
    label: string;
}

const props = defineProps<{
    headers: Header[];
    data: any[];
    perPage?: number;
    create?: boolean;
    update?: boolean;
    delete?: boolean;
}>();

const emit = defineEmits(['create', 'delete', 'update', 'select']);

const showCreateForm = ref(false);
const showUpdateForm = ref(false);
const createForm = ref<Record<string, any>>({});
const creating = ref(false);
const updateForm = ref<Record<string, any>>({});
const updating = ref(false);
const selected = ref<number[]>([]);

function deleteSelected() {
    emit('delete', selected.value);
    selected.value = [];
}

function toggleCreateForm() {
    if (!showCreateForm.value) {
        showUpdateForm.value = false;
        updateForm.value = {};
    }
    showCreateForm.value = !showCreateForm.value;
}

function toggleUpdateForm() {
    if (!showUpdateForm.value) {
        showCreateForm.value = false;
        createForm.value = {};
    }
    if (showUpdateForm.value) {
        showUpdateForm.value = false;
        updateForm.value = {};
        return;
    }
    if (selected.value.length !== 1) return;
    const id = selected.value[0];
    const row = props.data.find((r: any) => (r.id ?? r[props.headers[0].key]) === id);
    if (row) {
        updateForm.value = { ...row };
        showUpdateForm.value = true;
    }
}

function submitCreateForm() {
    creating.value = true;
    emit('create', { ...createForm.value });
    showCreateForm.value = false;
    createForm.value = {};
    creating.value = false;
}

function submitUpdateForm() {
    updating.value = true;
    emit('update', { ...updateForm.value });
    showUpdateForm.value = false;
    updateForm.value = {};
    updating.value = false;
    selected.value = [];
}

const currentPage = ref(1);
const perPage = computed(() => props.perPage ?? 10);

const totalPages = computed(() =>
    Math.ceil((props.data?.length ?? 0) / perPage.value)
);

const paginatedData = computed(() => {
    const start = (currentPage.value - 1) * perPage.value;
    return props.data?.slice(start, start + perPage.value) ?? [];
});

watch(selected, (newSelected) => {
  if (!props.data) {
    emit('select', []);
    return;
  }
  
  const selectedData = props.data.filter((row: any) => 
    newSelected.includes(row.id ?? row[props.headers[0].key])
  );
  emit('select', selectedData);
}, { immediate: true });

watch(
    () => props.data,
    () => {
        currentPage.value = 1;
    }
);

watch(selected, (val) => {
    if (showUpdateForm.value && val.length !== 1) {
        showUpdateForm.value = false;
        updateForm.value = {};
    }
});

function goToPage(page: number) {
    if (page >= 1 && page <= totalPages.value) {
        currentPage.value = page;
    }
}

function handleSelectAll(event: Event) {
    const target = event.target as HTMLInputElement | null;
    selected.value = target && target.checked
        ? paginatedData.value.map(row => row.id ?? row[props.headers[0].key])
        : [];
}
</script>

<template>
    <div>
        <div v-if="props.create !== false || props.delete !== false" class="mb-3"
            style="display: flex; gap: 0.5rem; align-items: center;">
            <button v-if="props.create !== false" @click="toggleCreateForm">{{ showCreateForm ? 'Close' : 'Show' }}
                Create Form</button>
            <button v-if="props.update !== false" @click="toggleUpdateForm" :disabled="selected.length !== 1">{{
                showUpdateForm ? 'Close' : 'Show' }} Update Form</button>
            <button v-if="props.delete !== false" @click="deleteSelected" :disabled="selected.length === 0">Delete
                Selected</button>
        </div>
        <form v-if="showCreateForm" @submit.prevent="submitCreateForm" class="form-aligned">
            <div v-for="header in headers" :key="header.key" class="form-row">
                <label :for="header.key">{{ header.label }}</label>
                <input :id="header.key" v-model="createForm[header.key]" :name="header.key" />
            </div>
            <button type="submit" :disabled="creating">Submit</button>
        </form>
        <form v-if="showUpdateForm" @submit.prevent="submitUpdateForm" class="form-aligned">
            <div v-for="header in headers" :key="header.key" class="form-row">
                <label :for="'update-' + header.key">{{ header.label }}</label>
                <input :id="'update-' + header.key" v-model="updateForm[header.key]" :name="header.key" />
            </div>
            <button type="submit" :disabled="updating">Update</button>
        </form>
        <table class="mb-3">
            <thead>
                <tr>
                    <th><input type="checkbox"
                            :checked="selected.length === paginatedData.length && paginatedData.length > 0"
                            @change="handleSelectAll" /></th>
                    <th>No.</th>
                    <th v-if="true" style="display:none">ID</th>
                    <th v-for="header in headers" :key="header.key">
                        {{ header.label }}
                    </th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="(row, idx) in paginatedData" :key="row.id ?? row[headers[0].key]">
                    <td><input type="checkbox" :value="row.id ?? row[headers[0].key]" v-model="selected" /></td>
                    <td>{{ (currentPage - 1) * perPage + idx + 1 }}</td>
                    <td v-if="true" style="display:none">{{ row.id }}</td>
                    <td v-for="header in headers" :key="header.key">
                        {{ row[header.key] }}
                    </td>
                </tr>
                <tr v-if="paginatedData.length === 0">
                    <td :colspan="headers.length + 3">
                        No data available.
                    </td>
                </tr>
            </tbody>
        </table>
        <div v-if="totalPages > 1">
            <button class="me-2" @click="goToPage(currentPage - 1)" :disabled="currentPage === 1">Prev</button>
            <span>Page {{ currentPage }} of {{ totalPages }}</span>
            <button class="ms-2" @click="goToPage(currentPage + 1)" :disabled="currentPage === totalPages">Next</button>
        </div>
    </div>
</template>

<style scoped>
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