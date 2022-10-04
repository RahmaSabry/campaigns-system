<template>
<div class="mt-8 bg-white dark:bg-gray-800 overflow-hidden shadow sm:rounded-lg">
  <div v-for="campaign in campaigns">
    <div class="p-4 border-t border-grarey-200 dark:border-gray-700">
        <a :href="'campaigns/'+campaign.id+'/edit'"><i class="material-icons" >edit</i></a>
            <h3>{{campaign.name}}</h3>
            <h3>From    :{{campaign.from}}</h3>
            <h3>To  :{{campaign.to}}</h3>
            <h3>Total   :{{campaign.total}}</h3>
            <h3>Daily Budget    :{{campaign.daily_budget}}</h3>
            <div v-if="preview == campaign.id">
                 <i class="material-icons" @click="preview = ''">close</i>
                 <div v-for="image in campaign.images">
                    <img :src="'/storage/images/'+image.name"/>
                </div>
            </div>
            <button class="btn btn-primary form-group" @click="preview = campaign.id">Preview Campaign Images</button>
        </div>
    </div>
</div>
</template>

<script>
import 'vue-loading-overlay/dist/vue-loading.css';
import { $vfm, VueFinalModal, ModalsContainer } from 'vue-final-modal';
$vfm.show({ component: 'MyDynamicModal' })
export default {
    name:'CampaignsList',
    components:{
        VueFinalModal,
        ModalsContainer
    },
     props: {
         campaigns: Array
     },
    data(){
        return {
            preview: false,
            campaignName : ''
        }
    },
    methods:{
        edit(campaignID){
            axios.get('api/campaigns/'+campaignID);
        },
        showModal(campaign){
            this.show = true;
            console.log(campaign);
        }
    }
}
</script>

<style scoped>

img {
    width:100%;
}
</style>
