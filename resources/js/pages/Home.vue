<script setup lang="ts">
import SideBar from '@/components/SideBar.vue';
import { ref, onMounted } from 'vue';
import axios from 'axios';

const totalInvoices = ref(0);
const totalQuantity = ref(0);

onMounted(async () => {
  try {
    const res = await axios.get('/invoice/total');
    totalInvoices.value = res.data.total ?? 0;
    totalQuantity.value = res.data.quantity ?? 0;
  } catch (e) {
    totalInvoices.value = 0;
    totalQuantity.value = 0;
  }
});
</script>

<template>
    <div class="container">
        <div class="row">
            <div class="col-5 col-md-4 col-lg-3 col-xl-2">
                <SideBar />
            </div>
            <div class="col-7 col-md-8 col-lg-9 col-xl-10 r">
                <h1>Dashboard</h1>
                <div class="row">
                    <div class="col-12 col-sm-9 col-md-6 col-lg-4 dashboard-card">
                        <h2>Total Transaksi</h2>
                        <div class="dashboard-total">{{ totalInvoices }}</div>
                    </div>
                    <div class="col-12 col-sm-9 col-md-6 col-lg-4 dashboard-card">
                        <h2>Total Barang Terjual</h2>
                        <div class="dashboard-total">{{ totalQuantity }}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<style scoped>
.r {
    margin-top: 2rem;
    margin-bottom: 2rem;
}
.dashboard-card {
    background: #fff;
    border-radius: 8px;
    box-shadow: 0 2px 8px rgba(0,0,0,0.07);
    padding: 2rem 1.5rem;
    margin-top: 2rem;
    max-width: 350px;
}
.dashboard-total {
    font-size: 2.5rem;
    font-weight: bold;
    color: #2d8cf0;
    margin-top: 1rem;
}
</style>
