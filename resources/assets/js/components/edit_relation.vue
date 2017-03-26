<script>

    export default {
        props:["field" , "all_tables" , "ids" , "relation_table" , "table_id"],
        data(){
            return {
                //relationships: this.relationships,
                //field: this.field
            }
        },
        methods:{
            remove_relation(e) {
                $(".r_"+$(e).attr("_r")).remove();
            }
        }
    }

</script>

<template>
<div v-bind:class="'box box-primary r_'+ids">
    <div class="box-header">
        <h3 class="box-title">Relationship with : {{ relation_table }}</h3>
    </div>
    <div class="box-body">
        <div class="row">
            <div class="col-md-3">
                <label for="field">field name</label>
                <div class="form-control">{{ field }}</div>
            </div>
            <div class="col-md-3">
                <label for="tables">relationship to the table</label>
                <select v-bind:name="'relationship['+ ids +']'" class="form-control">
                    <option v-bind:value="relationship" v-for="relationship in all_tables" :selected="relation_table == relationship ? true : false">{{ relationship }}</option>
                </select>
            </div>
            <div class="col-md-3">
                <div class="btn btn-danger" v-bind:_r="ids" @click="remove_relation($event.target)">Delete</div>
            </div>
        </div>
    </div>
</div>
</template>