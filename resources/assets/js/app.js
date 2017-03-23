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
    all_fields: [],
    send_checks: [],
    deleted_field: null
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
    
    // put the chosen values in the field that will send to the controller to store in database
    // .v_check represent fields that refer to visibility the values of it (show , add , edit)
    // #check_all is check box to check all the check box
    // #send_c_value-(order) that refer to the hidden input that will send to store it in database
    // .v_check_(val)-(order) that class have been created to use it to detect which input choosed (show or add or , edit)

  	chose_all(ord){
        //document.getElementsByClassName("v_check-"+ord).checked = true;
        //console.log($(".v_check-1").checked = true)
        $(".v_check-"+ord).prop('checked', $("#check_all-"+ord).prop("checked"));
        document.getElementById("send_c_value-"+ord).value = "show,add,edit,";
        if (!$("#check_all-"+ord).prop("checked")){
            document.getElementById("send_c_value-"+ord).value = "";
        }
  	},
    check_exist(){
        var checkers = document.getElementsByClassName("checks").length;
        var get_current_id = document.getElementsByClassName("ids");
        for (var c = 0; c < checkers; c++) {
            if ($("#check_all-"+get_current_id[c].value).prop("checked")) {
                $(".v_check-"+get_current_id[c].value).prop('checked', $("#check_all-"+get_current_id[c].value).prop("checked"));
                document.getElementById("send_c_value-"+get_current_id[c].value).value = "show,add,edit,"
            }
        }
    },
    // put the chosen values in the field that will send to the controller to store in database
    // .v_check represent fields that refer to visibility the values of it (show , add , edit)
    // #check_all is check box to check all the check box
    // #send_c_value-(order) that refer to the hidden input that will send to store it in database
    // .v_check_(val)-(order) that class have been created to use it to detect which input choosed (show or add or , edit)
    send_v_checks(order,val){
      var chosed_allready = document.getElementById("send_c_value-"+order).value;
      if ($(".v_check_"+ val +"-"+order).prop("checked") && chosed_allready.search(val) == -1) {
        document.getElementById("send_c_value-"+order).value += val + ","
        if (document.getElementById("send_c_value-"+order).value.search("add") > -1 && document.getElementById("send_c_value-"+order).value.search("edit") > -1 && document.getElementById("send_c_value-"+order).value.search("show") > -1){
          $("#check_all-"+order).prop("checked" , true)
        } 
      }
      if (!$(".v_check_"+ val +"-"+order).prop("checked")){
        var new_value = document.getElementById("send_c_value-"+order).value.replace(val + "," , '');
        document.getElementById("send_c_value-"+order).value = new_value
        if (document.getElementById("send_c_value-"+order).value == ""){
          $("#check_all-"+order).prop("checked" , false)
        }
      }
    },

    delete_field(id){
        $("#edit_field-"+id).remove();
        this.$http.post("/api/v1/delete_field" , {id: id}).then(response => {
            console.log("response" , response.data);
            this.deleted_field = response.data;
        });
    }

  },
  mounted (){
    this.check_exist();
  }

})



