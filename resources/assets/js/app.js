import Vue from 'vue'
import VueRouter from 'vue-router'
import axios from 'axios'
import VueAxios from 'vue-axios'

// importing custom components
import add_relation from './components/add_relation';

import add_field from './components/add_field';

require("./bootstrap-toggle.min.js");

// Adding the X-CSRF-Token to all axios request
axios.interceptors.request.use(function(config){
  config.headers['X-CSRF-TOKEN'] = window.Laravel.csrfToken
  return config
})

// Making axios available as $http 
// so that the ajax calls are not axios dependent
Vue.prototype.$http = axios

Vue.use(VueAxios, axios)
Vue.use(VueRouter)

Vue.component('add_relation', add_relation);

Vue.component('add_field', add_field);

/*var tmp = Vue.extend({ 
    template: '<add_relation></add_relation>'
})*/


 new Vue({
  el: '#app',
  data: {
    message: 'Hello World!',
    all_relations: [],
    field_names: [],
    relation_order: 0,
    field_order: 1,
    all_fields: []
  },
  methods: {
  	add_relation() {
  		var inputCount = document.getElementById("fields").getElementsByClassName("f-name").length;
  		for (var r = 0; r < inputCount; r++) {
          if (this.field_names.indexOf($(".f_name-"+r).val()) === -1 && $(".f_name-"+r).val() !== ""){
            this.field_names.push($(".f_name-"+r).val())
          }
        }
 		
 		this.relation_order += 1;        
        this.all_relations.push({component: 'add_relation', props: {relation_field: this.field_names , order: this.relation_order}});
  	},
  	add_field() {
  		this.field_order += 1;
        this.all_fields.push({component: 'add_field', props: {order: this.field_order}});
  	},
  	chose_all(ord){
        //document.getElementsByClassName("v_check-"+ord).checked = true;
        //console.log($(".v_check-1").checked = true)
        $(".v_check-"+ord).prop('checked', $("#check_all-"+ord).prop("checked"));
  	}
  }

})



