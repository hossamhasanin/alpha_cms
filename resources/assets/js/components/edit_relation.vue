<script>

    export default {
        props:["field" , "all_tables" , "ids" , "relation_table" , "table_id"],
        data(){
            return {
                new_table: this.relation_table
            }
        },
        methods:{
            remove_relation(e) {
                $(".r_"+$(e).attr("_r")).remove();
                if (this.relation_table != "" && this.table_id != "" && this.ids != "") {
                    this.$http.delete("/api/v1/delete_relationship/" + this.relation_table + "/" + this.table_id + "/" + this.ids)
                        .then(response => {
                            console.log(response)
                        });
                }
                //console.log(this.relation_table)
            }
        }
    }

</script>

<template>
<div v-bind:class="'box box-primary r_'+ids">
    <div class="box-header">
        <h3 class="box-title">Relationship with : {{ relation_table == "" ? new_table : relation_table }}</h3>
    </div>
    <div class="box-body">
        <div class="row">
            <div class="col-md-3">
                <label for="field">field name</label>
                <input class="form-control" v-bind:name="'field_in_relationship['+ ids +']'" v-bind:value="field">
            </div>
            <div class="col-md-3">
                <label for="tables">relationship to the table</label>
                <select v-bind:name="'relationship['+ ids +']'" class="form-control" v-model="new_table">
                    <option v-bind:value="relationship" v-for="relationship in all_tables" :selected="relationship == relation_table ? true : false">{{ relationship }}</option>
                </select>
            </div>
            <div class="col-md-3">
                <label>Remove</label>
                <div class="btn btn-danger form-control" v-bind:_r="ids" @click="remove_relation($event.target)">Delete</div>
            </div>
        </div>
    </div>
</div>
</template>