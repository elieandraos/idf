<template>
    <div class="card mt-4">
        <h2 class="card-header">Statistics</h2>
        <div class="card-body">
            <div v-if="loading">
                <center><loader></loader></center>
            </div>
            <div v-else>
                <p>
                    Your rankings improve every time you answer a question correctly.
                    Keep learning and earning course points to become one of our top learners!
                </p>
                <p>
                    <input 
                        v-on:keyup.enter="onEnter" 
                        v-model="newScore"
                        type="text" 
                        placeholder="Simulate score update (Enter new number and hit enter)" class="form-control"
                     />
                </p>
                <div class="row">
                    <div class="col-md-6">
                        <h4>You are ranked <b>#{{ data.leaderboardCountryRank }}</b> in {{ userCountry }}</h4>
                        <leaderboard :items="data.leaderboardCountry"></leaderboard>
                    </div>
                     <div class="col-md-6">
                        <h4>You are ranked <b>#{{ data.leaderboardWorldwideRank }}</b> worldwide</h4>
                        <leaderboard :items="data.leaderboardWorldwide"></leaderboard>
                    </div>
                </div>
            </div>

        </div>
    </div>
</template>

<script>
    import axios from 'axios';
    import Leaderboard from './Leaderboard.vue';
    import Loader from './../shared/Loader.vue';

    export default {
        props: {
            url: {
                required: true,
                type: String
            },
            userId: {
                required: true,
                type: Number
            },
            courseId: {
                required: true,
                type: Number
            },
            updateScoreUrl: {
                required: true,
                type: String
            }
        },
        data: () => ({
            loading: true,
            data: {},
            newScore: null,
            userCountry: 'your country'
        }),
        computed: {
            validScoreSimulation: function() {
                return ( !parseInt(this.newScore) || parseInt(this.newScore) < 0 ) ? false : true;
            }
        },
        methods: {
            getStatistics() {
                axios.get(this.url)
                .then(response => {
                    this.loading = false;
                    this.data = response.data;
                    this.userCountry = response.data.userCountry
                })
                .catch(function(error){
                    console.log(error);
                });
            },
            onEnter(){
                this.loading = true;
                if( !this.validScoreSimulation )
                {
                    alert('You must enter a valid number');
                    this.loading = false;
                    return;
                }
                
                axios.post(this.updateScoreUrl, { score: parseInt(this.newScore) })
                .then(response => {
                    this.getStatistics();
                    this.newScore = null;
                })
                .catch(function(error){
                    console.log(error);
                });
            }
        },
        mounted() {
            this.getStatistics();
        }
    }
</script>
