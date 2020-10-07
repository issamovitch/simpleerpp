<template>
    <div>
        <nav v-if="pagination.hasPages">
            <ul class="pagination" v-bind:style="stylee">
                <!-- Previous Page Link -->
                <li v-if="pagination.onFirstPage" class="page-item disabled"><span class="page-link" aria-hidden="true">&lsaquo;</span></li>
                <li v-else class="page-item"><inertia-link :preserveScroll="true" class="page-link" :href="pagination.previousPageUrl">&lsaquo;</inertia-link></li>
                <!-- Pagination Elements -->
                <template v-for="element in pagination.elements">
                    <!-- "Three Dots" Separator -->
                    <li v-if="element=='...'" class="page-item disabled" aria-disabled="true"><span class="page-link">{{ element }}</span></li>
                    <!-- Array Of Links -->
                    <template v-else v-for="(url,page) in element">
                        <li v-if="page==pagination.currentPage" class="page-item active" aria-current="page"><span class="page-link">{{ page }}</span></li>
                        <li v-else class="page-item"><inertia-link :preserveScroll="true" class="page-link" :href="url">{{ page }}</inertia-link></li>
                    </template>
                </template>
                <!-- Next Page Link -->
                <li v-if="pagination.hasMorePages" class="page-item"><inertia-link :preserveScroll="true" class="page-link" :href="pagination.nextPageUrl">&rsaquo;</inertia-link></li>
                <li v-else class="page-item disabled"><span class="page-link" aria-hidden="true">&rsaquo;</span></li>
            </ul>
        </nav>
    </div>
</template>

<script>
export default {
    props : ["pagination", "stylee"]
}
</script>
