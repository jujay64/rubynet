<template>
<nav aria-label="Pagination">
<ul class="pagination pagination-circular text-center">
  <li><a class="pagination-link" @click="onClickFirstPage" :disabled="isInFirstPage">First</a></li>
  <li><a class="pagination-link" @click="onClickPreviousPage" :disabled="isInFirstPage">Previous</a></li>
 
  <li v-for="page in pages">
                <a class="pagination-link" :class="{active: isPageActive(page.name)}"
                @click="onClickPage(page.name)" 
                :disabled="page.isDisabled">{{ page.name }}</a>
  </li>

  <li><a class="pagination-link" @click="onClickNextPage" :disabled="isInLastPage">Next</a></li>
  <li><a class="pagination-link" @click="onClickLastPage" :disabled="isInLastPage">Last</a></li>
</ul>
</nav>
</template>
<script>
export default {
	props: {
		maxVisibleButtons: {
			type: Number,
			required: false,
			default: 3
		},
		totalPages: {
			type: Number,
			required: true
		},
		total: {
			type: Number,
			required: true
		},
		currentPage: {
			type: Number,
			required: true
		}
	},
	computed: {
		isInFirstPage(){
			return this.currentPage === 1;
		},
		isInLastPage(){
			return this.currentPage === this.totalPages;
		},
		startPage(){
			//When on the first page
			if (this.currentPage === 1){
				return 1;
			}
			//When on the last page
			if(this.currentPage === this.totalPages){
				return (this.totalPages - this.maxVisibleButtons + 1) > 0 ?
						this.totalPages - this.maxVisibleButtons + 1 : 1;
			}
			//When in between
			return (this.totalPages - (this.currentPage - 2) < this.maxVisibleButtons) && (this.totalPages - this.maxVisibleButtons + 1) > 0 ? 
					this.totalPages - this.maxVisibleButtons + 1 : this.currentPage - 1;
		},
		pages(){
			const range = [];

			for (let i = this.startPage;
				i <= Math.min(this.startPage + this.maxVisibleButtons - 1, this.totalPages);
				i+= 1){
					range.push({
						name: i,
						isDisabled: i === this.currentPage
						});
				}
				return range;
		},
	},
	methods: {
		onClickFirstPage() {
			this.$emit('pagechanged', 1);
		},
		onClickPreviousPage(){
			this.$emit('pagechanged', this.currentPage - 1);
		},
		onClickPage(page){
			this.$emit('pagechanged', page);
		},
		onClickNextPage(){
			this.$emit('pagechanged', this.currentPage + 1);
		},
		onClickLastPage(){
			this.$emit('pagechanged', this.totalPages);
		},
		isPageActive(page) {
      		return this.currentPage === page;
    	}
	},
}
</script>