<template>
<div>
    <div v-if="errors" class="alert alert-danger">
        <div v-for="(v, k) in errors" :key="k">
            <p v-for="error in v" :key="error" class="text-sm">
                {{ error }}
            </p>
        </div>
    </div>
    <div v-if="message" class="alert alert-success">
            <p class="text-sm">
                {{ message }}
            </p>
    </div>
     <form @submit.prevent="submitForm"
          class="vld-parent"
          ref="formContainer">
    <div class="form-group">
        <label for="name" class="text-white">Campaign Name</label>
        <input type="text" class="form-control" id="name" v-model="name" placeholder="Enter Name">
    </div>
               <div class="form-group">
         <label for="name" class="text-white">select From to To Date</label>
        <Datepicker v-model="date" range :format="format"></Datepicker>
    </div>
    <div class="form-group">
        <label for="name" class="text-white">Total</label>
        <input type="text" class="form-control" id="total" v-model="total" placeholder="Enter total">
    </div>
     <div class="form-group">
        <label for="name" class="text-white">Daily Budget</label>
        <input type="text" class="form-control" id="daily_budget" v-model="daily_budget" placeholder="Enter daily_budget">
    </div>
               
    <div class="form-group text-white" >
        <label for="images">Images</label>
        <input type="file" class="form-control" multiple  id="images" @change="fileChanged">
    </div>
        <div class="form-group">
            <ul  class="list-group">
            <li class="list-group-item list-group-item-action list-group-item-success" v-for="(image,index) in images" :key="image.original_name">
                     {{image.original_name}}  <i class="material-icons" @click="deleteImage(index)">delete</i>
            </li>
            </ul>
        </div>
        <div class="form-group">
    <button class="btn btn-primary" type="submit">Submit</button>
        </div> 
     </form>   
+     </div>    
</template>

<script>
import Datepicker from '@vuepic/vue-datepicker';
import '@vuepic/vue-datepicker/dist/main.css';

export default {
     
    components: {
        Datepicker : Datepicker,
    },
    mounted() {
        if(window.campaign)
        {
            this.editedCampagin = window.campaign;
            this.name = this.editedCampagin.name;
            this.total = this.editedCampagin.total;
            this.daily_budget = this.editedCampagin.daily_budget;
            this.images =  this.editedCampagin.images;
        }
    },
    data(){
        return{
            images:[],
            form: new FormData(),
            name : '',
            date : '',
            total : '',
            daily_budget : '',
            errors: null,
            fullPage:false,
            editedCampagin: '',
            edit: false,
            message: false,
        }
        },
    methods: {
        fileChanged(e){
            let uploadedFiles = e.target.files;
            if(uploadedFiles.length){
                for(let i=0;i<uploadedFiles.length;i++){
                    uploadedFiles[i].original_name = uploadedFiles[i].name;
                    this.images.push(uploadedFiles[i]);
                            
                }
            }
        },
        deleteImage(index){
            this.images.splice(index,1);
        },
        submitForm(){
            let loader = this.$loading.show();
            let request;
            this.loading = true;
            this.gatheringFormData();
            let config = {method:'put',headers:{'Content-Type': 'multipart/form-data'}}
            if(this.editedCampagin != ''){
             const test = {method:'put',headers:{'Content-Type': 'multipart/form-data'}}
              request = axios.post('/api/campaigns/'+ this.editedCampagin.id, this.form, test);
            } else {
                request = axios.post('/api/campaigns', this.form, config);

            }
            request.then(response=>{
               if(this.editedCampagin != ''){
                   this.message = "campaigns updated successfully";
               } else{
                   this.message = "campaigns created successfully";
                   this.clearFormData();
               }
                    loader.hide();
            })
            .catch(error=>{
                loader.hide();
                this.errors = error.response.data.errors;
            });
        },
        gatheringFormData(){
            this.form.delete('images[]');
            for(let i=0; i<this.images.length;i++){
                            console.log(i);
                if(this.images[i].id){
                    this.form.append('images[]',JSON.stringify(this.images[i]));
                } else {
                    this.form.append('images[]',this.images[i]);
                }
            }
            this.form.append('name', this.name);
            this.form.append('total', this.total);
            this.form.append('daily_budget', this.daily_budget);
            this.form.append('date', this.gratheringDate());
            document.getElementById('images').value=[];
        },
        clearFormData(){
            this.errors = null;
            this.name = '';
            this.date = '';
            this.total = '';
            this.daily_budget = '';
            this.images = [];
        },
        gratheringDate(){
            let dates = [];
            for(let i=0; i < this.date.length; i++)
            {
                const day = this.date[i].getDate();
                const month = this.date[i].getMonth() + 1;
                const year = this.date[i].getFullYear();
                dates[i] = `${year}-${month}-${day}`;
            }
            return dates;
        }
    }
}
</script>

<style>

</style>ue