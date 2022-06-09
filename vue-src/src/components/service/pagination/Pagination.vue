<template>
    <div v-if='this.content[2]' class='d-flex align-items-center justify-content-center'>
        <ul class="pagination pagination-sm">
            <li v-for="row in this.buttons" :key="row"
            class="page-item"
            :class="{'active': row == this.page}" 
            v-on:click='() => {this.changePage(row)}' 
            aria-current="page">
                <span class="page-link">{{row}}</span>
            </li>
        </ul>
    </div>
</template>

<script>

export default {
    props: {
        data: [Array, Object],
        count: {
            type: [Number, Boolean],
            default: 10,
        },
        max: {
            type: [Number, Boolean],
            default: 6,
        },
    },
    watch: {
        data(newData, oldData) {
            if (newData != oldData) {
                this.pages = false;
                this.content = {};
                this.page = 1,
                this.getPages();
                this.setData();
                this.setButtons();
                this.returnContent();
            }
        }
    },
    data() {
        return {
            pages: false,
            page: 1,
            content: {},
            buttons: []
        }
    },
    methods: {
        returnContent() {
            this.$emit('updateContentState', this.content[this.page])
        },
        getPages() {
            this.pages = Math.ceil(this.data.length / this.count);
        },
        setData() {
            let tmp = 0;
            for (let i = 0; i < this.pages; i ++  ) {
                this.content[i + 1] = this.data.slice(tmp, this.count + tmp);
                tmp += this.count;
            }
        },
        changePage(i) {
            if (i == '<<') {
                i = 1;
            } else if (i == '>>') {
                i = this.pages;
            }
            this.page = i;
            this.setButtons();
            this.returnContent();
        },
        setButtons() {
            this.buttons = [];
            if (this.pages <= this.max && this.pages > 1) {
                for (let key in this.content) {
                    this.buttons.push(key);
                }
            } else {
                this.buttons.push('<<');
                let c = this.max/2;
                for (let key in this.content) {
                        if (this.page - key <= c && this.page - key > 0) {
                            this.buttons.push(+key);
                        } else if (key == this.page) {
                            this.buttons.push(this.page);
                        } else if (key - this.page <= c &&  key - this.page > 0  ) {
                            this.buttons.push(+key);
                        }

                }
                this.buttons.push('>>');
            }
        }
    },    
}
</script>

<style lang="scss">
.pagination > li > span
{
    background-color: white;
    color: $color-grey;
    cursor: pointer;
}

.pagination > li > span:focus,
.pagination > li > span:hover,
.pagination > li > span:focus,
.pagination > li > span:hover
{
    color: white;
    background-color: $color-warning;
    border-color: $color-warning;
}

.pagination > .active > span
{
    color: white;
    background-color: $color-warning !Important;
    border: solid 1px $color-warning !Important;
    filter: saturate(200%);
}

.pagination > .active > span:hover
{
    background-color: $color-warning !Important;
    border: solid 1px $color-warning;
}
</style>