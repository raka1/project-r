<template>
    <div class="sidebar">
        <div class="mb-4"><a href="/"><img src="/logo.png" alt="Logo" style="max-width: 8rem; height: auto;"></img></a></div>
        <div><a href="/">Dashboard</a></div>
        <div><a href="/barang">Barang Masuk</a></div>
        <div><a href="/produksi">Produksi</a></div>
        <div><a href="/invoice">Invoice</a></div>
    </div>
</template>

<style>
a {
    text-decoration: none;
    color: black;
}

a:hover {
    text-decoration: underline;
}

.sidebar {
    margin-top: 2rem;
    margin-bottom: 2rem;
    border-right: 0.2rem solid #F05340;
    min-height: calc(100% - 4rem);
}
</style>