<template>
    <div>
        <b-row>
            <b-col>
                <b-alert :show="this.bots.length >= this.allowedBots" variant="info">Your subscription plan allows you to create <b>{{ this.allowedBots }}</b> bots.</b-alert>
                <b-alert :show="this.walletBalance < 10" variant="warning">Please fund your wallet to continue uninterrupted trading. <a href="/wallet">Click here to check your wallet balance</a> </b-alert>
            </b-col>
        </b-row>
        <b-row>
            <div class="col-lg-3 col-6" v-for="bot in bots" :key="bot.id">
                <div class="small-box bg-light">
                    <div class="inner">
                        <h4><market-widget :coin="bot.symbol"/></h4>
                        <p>{{ bot.user_exchange != null ? bot.user_exchange.name : ''}} | ${{ bot.balance }}</p>
                    </div>
                    <a :href="`/bots/${bot.id}`" class="small-box-footer">
                        {{ bot.title }} (<small>{{bot.symbol.name}}</small>)
                        <i v-if="bot.status" class="fas fa-check-circle market-plus"></i>
                        <i v-if="!bot.status" class="fas fa-times-circle market-minus"></i>
                    </a>
                </div>
            </div>
            <div class="col-lg-3 col-6" v-if="addNewBot">
                <div class="small-box bg-secondary">
                    <div class="inner">
                        <h3>Add New</h3>
                        <p>&nbsp;</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-plus"></i>
                    </div>
                    <a href="/bots/create" class="small-box-footer">
                        Configurations
                        <b-icon-alarm />
                    </a>
                </div>
            </div>
        </b-row>
    </div>
</template>

<script>
import IconCrypto from "vue-cryptocurrency-icons";

export default {
    name: "BotList",
    props: ["allowedBots","walletBalance"],
    components: {IconCrypto},
    data() {
        return {
            bots: [],
            addNewBot: false
        }
    },
    mounted() {
        this.getBots();
    },
    methods: {
        getBots() {
            axios.get('/api/v1/bots', {})
                .then(res => {
                    this.bots = res.data.data
                    if( this.bots.length < this.allowedBots ) {
                        this.addNewBot = true;
                    }
                })
                .catch( err => { console.log(err) })
        }
    }
}
</script>

<style scoped>

</style>
