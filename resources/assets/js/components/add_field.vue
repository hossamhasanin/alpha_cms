<script>
	export default {
		props: ["order"],
		data () {
			return {

			}
		},
		methods : {
			remove_field(fi) {
				$(fi).remove();
			}
		}
	}
</script>


<template>
	<tr v-bind:class="'field-'+ order ">
		<td>
		  <input v-bind:class="'form-control f_name-'+ order " placeholder='Field Name' v-bind:name="'field_name['+ order +']'" type='text'>
		</td>
		<td>
		  <select class='form-control' v-bind:name="'field_type['+ order +']'">
		  	<option>chose</option>
		  	<option value='float'>Float</option>
		  	<option value='dateTime'>DateTime</option>
		  	<option value='integer'>Integer</option>
		  	<option value='longText'>LongText</option>
		  	<option value='mediumText'>MediumText</option>
		  	<option value='string'>Varchare</option>
		  	<option value='text'>Text</option>
		  </select>
		</td>
		<td>
			<input type='checkbox' v-bind:name="'nullable['+ order +']'" data-toggle='toggle' >
		</td>
		<td>
			<input class='form-control d_value-"+ i +"' placeholder='Defualt value' v-bind:name="'defualt_value['+ order +']'" type='text'>
		</td>
		<td>
			<div class='btn btn-danger remove_field' @click="remove_field('.field-'+order)" num= "+ i +">X</div>
		</td>
	</tr>
</template>