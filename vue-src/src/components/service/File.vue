<template>
    <div class="row container-fluid mt-1 p-0 g-3 align-items-center input">
        <div class="col-sm-3 p-0">
            <label :for="id" class="col-form-label input-label">{{this.label}}<span class='require' v-if="this.require"> *</span></label>
        </div>
        <div class="col-sm-9 input-wrapper p-0">
            <div class="input-filecontainer">
                <div v-if="this.image">
                    <img :src='this.image'>
                </div>
                <div>
                    <label :for='id'>Выбрать файлы</label>
                </div>
                <input class='input-filecontainer-input' :id="id" type='file' v-on:input="this.getFile">
            </div>
            <Popper class="bs-tooltip" :content='this.hint'/>
        </div>
    </div> 
</template>

<script>
import Popper from '@/components/service/Popper';
export default {
    components: {
        Popper
    },
    data() {
        return {
            file: this.dataValue ? this.dataValue : '',
            image: this.dataValue ? this.dataValue : '',
            type: ''
        }
    },
    props: {
        id: [String, Boolean],
        label: [String],
        hint: [String],
        dataValue: [String, Boolean],
        require: [Boolean]
    },
    methods: {
        getFile() {
            this.file = document.querySelector(`#${this.id}`).files[0];
            this.type = '';
            this.image = false;
            this.convertFile();
        },
        convertFile() {
            if (this.file.type == 'image/jpeg' || this.file.type == 'image/jpg' || this.file.type == 'image/png') {
                this.type = this.file.type;
                this.getBase64()
            } else {
                alert(`Недопустимый формат ${this.file.type} допустимы jpeg/jpg/png`) 
            }
        },
        getBase64() {
            var reader = new FileReader();
            reader.readAsDataURL(this.file);
            reader.onload = () => {
                this.file = reader.result;
                this.setValue();
                this.image = reader.result;
            };
            reader.onerror = function (error) {
                this.file = false;
                this.image = false;
                this.setValue(); 
            };
        },
        setValue() {
            this.$emit('updateParentState', {
                id: this.id,
                value: this.file
            })
        }
    },

}
</script>

<style lang="scss" scoped>
.input {
    font-family: 'HelveticaNeue roman';
    &-wrapper {
        position: relative;
        display: flex;
        flex-direction: row;
        flex-wrap: nowrap;
        align-items: center;
        justify-content: space-between;
    }
    &-filecontainer {
        display: flex;
        flex-direction: column;
        flex-wrap: nowrap;
        justify-content: center;
        label {
            color: $color-href;
            cursor: pointer;
        }
        img {
            max-width: 10rem;
        }
        &-input {
            display: none;
        }

    }
}
</style>