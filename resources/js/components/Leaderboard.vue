<template>
	<ul>
        <li v-for="(item,key) in items" class="courseRanking__rankItem">
            <div class="position">
                {{ item.user_rank }}
            </div>
            <div class="info" :class="(item.is_logged_user) ? 'bold' : ''">
                {{ item.user.name }}
	            <div class="score">
	                {{ item.score }} PTS
	            </div>
            </div>
        </li>
    </ul>
</template>

<script>
    import axios from 'axios';
    import Loader from './../shared/Loader.vue';

    export default {
        props: {
            items: {
                required: true,
                type: Array
            }
        }
   	}
</script>

<style scoped>
	ul {
		padding: 0;
	}
    .courseRanking__rankItem{
        display: flex; 
        flex-direction: row; 
        padding: 10px;
    }
    .courseRanking__rankItem .position{
        font-size: 28px; 
        color: rgb(132, 132, 132); 
        text-align: right; 
        width: 80px; 
        padding-right: 10px;
    }
    .info{
        font-size: 16px;
    }
    .score{
        font-size: 10px; 
        color: rgb(132, 132, 132);
    }
    .bold{
        font-weight: bold;
    }
    li:nth-child(3n) {
        border-bottom: 1px solid #eee;
    }
    li:nth-last-child(1){
        border: none;
    }
</style>