<template>
    <div class="card mt-4">
        <h2 class="card-header">Statistics</h2>
        <div class="card-body">
            <div v-if="loading">
                <center><loader></loader></center>
            </div>
            <div v-else>
                <p>
                    Your rankings improve every time you answer a question correctly.<br/>
                    Keep learning and earning course points to become one of our top learners!
                </p>
                <div class="row">
                    <div class="col-md-6">
                        <h4>You are ranked <b>#{{ data.leaderboardCountryRank }}</b> in your country</h4>
                        <leaderboard :items="data.leaderboardCountry"></leaderboard>
                    </div>
                     <div class="col-md-6">
                        <h4>You are ranked <b>#{{ data.leaderboardWorldwideRank }}</b> Worldwide</h4>
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
            }
        },
        data: () => ({
            loading: true,
            data: {}
        }),
        methods: {
            getStatistics() {
                axios.get(this.url)
                .then(response => {
                    this.loading = false;
                    this.data = response.data;
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
