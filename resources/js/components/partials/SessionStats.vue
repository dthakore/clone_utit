<template>
    <div class="card-tools float-right">
        <span v-if="avPrice !== 0" class="badge session-badge badge-secondary"><i class="far fa-clock"></i> AV Price ${{ this.avPrice.toFixed(2) }}</span>
<!--        <span class="badge session-badge" :class="badgeClass"><i class="far fa-check-circle"></i> P&L ${{ this.profitLoss.toFixed(2) }}</span>-->
<!--        <button v-if="session.status === 'OPEN'" type="button" class="btn btn-tool">Sell & Take Profit</button>-->
    </div>
</template>

<script>
export default {
    name: "SessionStats",
    props: ['trades','take_profit_button','bot','session'],
    data() {
        return {
            buy: 0,
            sell: 0,
            profitLoss: 0,
            badgeClass: 'badge-success',
            avPrice: 0
        }
    },
    mounted() {
        let totalBuyAmount = 0, totalBuyQuantity = 0;
        this.trades.map( trade => {
            if(trade.closed_at == null && trade.side === 'BUY') {
                if(trade.cover === null) {
                    totalBuyAmount += trade.executed_amount;
                    totalBuyQuantity += trade.executed_quantity;
                } else if(trade.cover != null && trade.cover.index <= this.bot.take_profit_independent_cover) {
                    totalBuyAmount += trade.executed_amount;
                    totalBuyQuantity += trade.executed_quantity;
                }
            } else if(trade.closed_at != null && trade.status) {
                if( trade.trade_type === 'SELL-IND' ) {
                    totalBuyAmount = totalBuyAmount - trade.profit_loss;
                }
            }
            this.profitLoss += trade.profit_loss
        });
        this.$emit('profitLoss', {
            "sessionId": this.session.id,
            "pl":this.profitLoss
        })
        //this.avPrice = totalBuyAmount / totalBuyQuantity;
        if(this.session.status === 'OPEN') {
            axios.get(`${process.env.MIX_BOT_API_URL}/session/${this.session.id}/details`).then( response => {
                if(response.data.new_average) {
                    this.avPrice = response.data.new_average;
                }
            })
        }
    },

}
</script>

<style scoped>
.session-badge {
    font-size: 15px;
    font-weight: 500;
}
</style>
