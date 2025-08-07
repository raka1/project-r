<script setup lang="ts">
import SideBar from '@/components/SideBar.vue';
import Table from '@/components/Table.vue';
import { router } from '@inertiajs/vue3';

const props = defineProps<{ invoices: any[] }>();

import { ref, computed } from 'vue';
const selectedRows = ref<any[]>([]);
const selectedRow = computed(() => selectedRows.value.length === 1 ? selectedRows.value[0] : null);

function handleSelect(rows: any[]) {
  selectedRows.value = rows;
}

function printInvoice() {
  if (!selectedRow.value) return;
  const invoice = selectedRow.value;
  const printWindow = window.open('', '', 'width=800,height=600');
  if (printWindow) {
    printWindow.document.write(`
      <html>
      <head>
        <title>Invoice ${invoice.invoice_number}</title>
        <style>
          body { font-family: Arial, sans-serif; padding: 2rem; }
          .invoice-box { max-width: 600px; margin: auto; border: 1px solid #eee; padding: 2rem; }
          h2 { margin-bottom: 1.5rem; }
          table { width: 100%; border-collapse: collapse; margin-top: 1rem; }
          td, th { padding: 8px; border-bottom: 1px solid #eee; }
        </style>
      </head>
      <body>
        <div class="invoice-box">
          <h2>Invoice</h2>
          <table>
            <tr><th>Invoice Number</th><td>${invoice.invoice_number}</td></tr>
            <tr><th>Product Name</th><td>${invoice.product_name}</td></tr>
            <tr><th>Quantity</th><td>${invoice.quantity}</td></tr>
            <tr><th>Total Price</th><td>${invoice.total_price}</td></tr>
          </table>
        </div>
        <script>
            setTimeout(function() {
                window.print();
                window.close();
            }, 500);
        <\/script>
      </body>
      </html>
    `);
    printWindow.document.close();
  }
}
</script>

<template>
    <div class="container">
        <div class="row">
            <div class="col-2">
                <SideBar />
            </div>
            <div class="col-10 r">
                <h1>Invoice</h1>
                <button class="mb-3" @click="printInvoice" :disabled="!selectedRow">Print Selected Invoice</button>
                <Table
                  :headers="[
                    { key: 'invoice_number', label: 'Invoice Number' },
                    { key: 'product_name', label: 'Product Name' },
                    { key: 'quantity', label: 'Quantity' },
                    { key: 'total_price', label: 'Total Price' }
                  ]"
                  :data="invoices"
                  :perPage="10"
                  :selected="selectedRows"
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
</style>
