<script>
	export default {
		props: ["relation_field" , "order"],
		mounted () {
			this.fetch_fields(this.relation_field);
			this.fetch_tables();
		},
		data () {
			return {
				koko: "koko"
			}
		},
		methods : {
			fetch_fields(fields) {
				var fetch_field = $("#fetch_field-"+this.order);
				for (var is = 0; is < fields.length; is++) {
					fetch_field.append('<option value="'+ fields[is] +'" > '+ fields[is] +'</option>');
				}
				//console.log(fields);

			},
			remove_relation(re) {
			    $(re).remove();
			},
			fetch_tables() {
				var fetch_table = $("#fetch_table-"+this.order);
				for (var f = 0; f < window.tests.length; f++) {
					fetch_table.append('<option value="'+ window.tests[f].table +'" > '+ window.tests[f].table +'</option>');
			        	//console.log(window.tests[f].table)
			    }
			}
		}
	}
</script>

<template>
	<div v-bind:class="'row relation-' + order">
		<div class='col-xs-2 col-md-2'>
			<select class='form-control' v-bind:id="'fetch_field-' + order" name='relation_fields[]'>
				<option>chose</option>
			</select>
		</div>
		<div class='col-xs-2 col-md-2'>
			<select class='form-control' v-bind:id="'fetch_table-' + order"  name='relation_tabels[]'>
				<option>chose</option>
			</select>
		</div>
		<div class='col-xs-1 col-md-1'>
			<div class="btn btn-danger pull-right remove_field" @click="remove_relation('.relation-'+order)" >X</div>
		</div>
	</div>

</template>