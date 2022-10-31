<template>
    <div>
        <div class="row">
            <div class="col text-right mb-2">
                <b-button type="button" variant="outline-danger" @click="deleteBot"><i class="fas fa-trash"/></b-button>
                <a :href="editUrl">
                    <button type="button" class="btn btn-outline-primary"><i class="fas fa-cogs"></i> Configurations</button>
                </a>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <div class="card card-widget widget-user shadow">
                    <div class="widget-user-header bg-secondary">
                        <h3 class="widget-user-username">{{ bot.title }}</h3>
                        <h5 class="widget-user-desc">{{ bot.symbol.pair }}</h5>
                    </div>
                    <div class="widget-user-image">
                        <IconCrypto class="img-circle elevation-2" :coinname="bot.symbol.code" size="24" format="svg"/>
                    </div>
                    <div class="card-footer">
                        <div class="row">
                            <div class="col-sm-4 border-right">
                                <div class="description-block">
                                    <h5 class="description-header">${{ profit.toFixed(2) }}</h5>
                                    <span class="description-text">{{ profit >= 0 ? 'PROFIT':'LOSS' }}</span>
                                </div>
                            </div>
                            <div class="col-sm-4 border-right">
                                <div class="description-block">
                                    <h5 class="description-header">{{ price }}</h5>
                                    <span class="description-text" :class="colorClass"><i :class="iconClass"></i> {{ percentage }}%</span>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="description-block">
                                    <h5 class="description-header">${{ balance.toFixed(2) }}</h5>
                                    <span class="description-text">BALANCE</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: "BotStats",
    props: ['bot'],
    data() {
        return {
            profit: 0,
            balance: parseFloat(this.bot.balance),
            colorClass:'',
            iconClass: '',
            percentage: 0,
            price: 0,
            editUrl: `/bots/${this.bot.id}/edit`
        }
    },
    mounted() {
        axios.get(`/api/v1/bot/${this.bot.id}/stats`).then( response => {
            if(response.data.trades.SELL) {
                this.profit = response.data.trades.SELL - response.data.trades.BUY;
                this.balance = this.balance - response.data.pending;
                this.balance.toFixed(2);
            }
        }).catch( error => {
            console.info(error)
        });
        if(this.$isAdmin) {
            this.editUrl = `/admin/bots/${this.bot.id}/edit`;
        }
        let ws = new WebSocket(`wss://stream.binance.com:9443/ws/${this.bot.symbol.name.toLowerCase()}@miniTicker`);
        ws.onmessage = market => {
            let data = JSON.parse(market.data);
            let percentage = ( (parseFloat(data.c) - parseFloat(data.o)) / parseFloat(data.o) ) * 100
            if( percentage > 0 ) {
                this.iconClass = 'far fa-arrow-alt-circle-up';
                this.colorClass = 'market-plus'
            } else {
                percentage = Math.abs(percentage);
                this.iconClass = 'far fa-arrow-alt-circle-down'
                this.colorClass = 'market-minus';
            }
            this.price = parseFloat(data.c).toFixed(2);
            this.percentage = parseFloat(percentage).toFixed(2);
        }
    },
    methods: {
        deleteBot() {
            this.$bvModal.msgBoxConfirm('Are you sure, You want to delete this bot?')
                .then(value => {
                    if(value) {
                        axios.get(`/api/v1/bot/${this.bot.id}/delete`).then( response => {
                            if(response.data.result) {
                                window.location.href = this.$isAdmin ? `/admin/bots` : `/bots`;
                            } else {
                                console.error("Failed to delete bot");
                            }
                        }).catch( error => {
                            console.info(error)
                        });
                    } else {
                        console.info("Failed");
                    }
                })
                .catch(err => {
                    // An error occurred
                })
        }
    }
}
</script>

<style scoped>

</style>
