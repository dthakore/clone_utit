<template>
    <span>
        <IconCrypto :coinname="coin.code" size="24" format="svg"/> {{ price }} <small :class="colorClass"><i :class="iconClass"></i> {{ percentage }}%</small>
    </span>
</template>

<script>
export default {
    name: "MarketWidget",
    props: ['coin'],
    data() {
        return {
            colorClass:'',
            iconClass: '',
            percentage: 0,
            price: 0
        }
    },
    mounted() {
        let ws = new WebSocket(`wss://stream.binance.com:9443/ws/${this.coin.name.toLowerCase()}@miniTicker`);
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
    }
}
</script>

<style scoped>

</style>
